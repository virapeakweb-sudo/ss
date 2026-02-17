<?php
/**
 * توابع و تعاریف قالب سیر و سلوک
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // خروج در صورت دسترسی مستقیم
}

/**
 * 1. تنظیمات اولیه قالب
 */
function seirosolok_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    
    // سایزهای اختصاصی تصاویر
    add_image_size( 'tour-thumb', 600, 400, true );
    add_image_size( 'tour-gallery', 800, 600, true );

    // ثبت منوها
    register_nav_menus( array(
        'primary' => __( 'منوی اصلی', 'seirosolok' ),
        'footer'  => __( 'منوی فوتر', 'seirosolok' ),
    ) );
}
add_action( 'after_setup_theme', 'seirosolok_theme_setup' );

/**
 * 2. فراخوانی فایل‌ها و استایل‌ها
 */
function seirosolok_enqueue_scripts() {
    // الف) Tailwind CSS (نسخه CDN برای توسعه)
    wp_enqueue_script( 'tailwindcss',  get_template_directory_uri() . '/js/tailwindcss.js', array(), '3.4.1', false );

    // کانفیگ تیلویند و فونت‌ها
    $tailwind_config = "
    tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['YekanBakh', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#22c55e', // مقدار پیش‌فرض برای کلاس bg-primary
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    500: '#22c55e',
                    600: '#B31D37', // رنگ خاص قرمز که درخواست کردید
                    700: '#15803d',
                    800: '#166534',
                    900: '#111827'
                },
                gold: {
                    DEFAULT: '#f59e0b',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706'
                },
                // برای جلوگیری از بهم ریختگی جاهایی که قبلا secondary بود
                secondary: {
                    DEFAULT: '#f59e0b', // همان رنگ طلایی 500
                    hover: '#d97706'    // همان رنگ طلایی 600
                },
                dark: '#0f172a',
            }
        }
    }
}";
    wp_add_inline_script( 'tailwindcss', $tailwind_config );

    // ب) آیکون‌ها
    wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

    // ج) تقویم شمسی (JalaliDatePicker)
    wp_enqueue_style( 'jalalidatepicker-css', 'https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css', array(), '0.9.6' );
    wp_enqueue_script( 'jalalidatepicker-js', 'https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js', array(), '0.9.6', true );

    // د) استایل اصلی قالب
    wp_enqueue_style( 'seirosolok-style', get_stylesheet_uri() );

    // ه) اسکریپت فیلتر آرشیو (فقط در صفحه آرشیو تور)
    if ( is_post_type_archive('tour') ) {
        wp_enqueue_script( 'archive-filter', get_template_directory_uri() . '/js/archive-filter.js', array('jquery'), '1.0.0', true );
        wp_localize_script( 'archive-filter', 'seirosolok_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
}
add_action( 'wp_enqueue_scripts', 'seirosolok_enqueue_scripts' );

/**
 * 3. ثبت پست تایپ‌ها و تاکسونومی‌ها
 */
function seirosolok_register_post_types() {
    // پست تایپ "تور"
    register_post_type('tour', array(
        'labels' => array(
            'name' => 'تورها',
            'singular_name' => 'تور',
            'add_new' => 'افزودن تور جدید',
            'add_new_item' => 'افزودن تور جدید',
            'edit_item' => 'ویرایش تور',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-airplane',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'tours'),
    ));

    // پست تایپ "هتل"
    register_post_type('hotel', array(
        'labels' => array(
            'name' => 'هتل‌ها',
            'singular_name' => 'هتل',
            'add_new' => 'افزودن هتل جدید',
            'edit_item' => 'ویرایش هتل',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-building',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));

    // تاکسونومی "شهر هتل" (مقصد)
    register_taxonomy('hotel_city', 'tour', array(
        'labels' => array(
            'name' => 'شهرها (مقاصد)',
            'singular_name' => 'شهر',
        ),
        'hierarchical' => true,
        'public' => true,
    ));

    // تاکسونومی "نوع تور"
    register_taxonomy('tour_type', 'tour', array(
        'labels' => array(
            'name' => 'انواع تور',
            'singular_name' => 'نوع تور',
        ),
        'hierarchical' => true,
        'public' => true,
    ));
}
add_action('init', 'seirosolok_register_post_types');

/**
 * 4. منطق فیلتر تورها (مشترک بین AJAX و Main Query)
 */
function seirosolok_get_tour_filter_args($params) {
    $args = array(
        'post_type'      => 'tour',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'meta_query'     => array('relation' => 'AND'),
        'tax_query'      => array('relation' => 'AND')
    );

    // صفحه‌بندی
    if (isset($params['page'])) {
        $args['paged'] = intval($params['page']);
    }

    // فیلترهای متا (قیمت، وسیله، مدت، اقساط)
    if (!empty($params['start_point'])) {
        $args['meta_query'][] = array('key' => 'start_point', 'value' => sanitize_text_field($params['start_point']), 'compare' => 'LIKE');
    }
    if (!empty($params['min_price'])) {
        $args['meta_query'][] = array('key' => 'price', 'value' => intval($params['min_price']), 'compare' => '>=', 'type' => 'NUMERIC');
    }
    if (!empty($params['max_price'])) {
        $args['meta_query'][] = array('key' => 'price', 'value' => intval($params['max_price']), 'compare' => '<=', 'type' => 'NUMERIC');
    }
    if (!empty($params['vehicle']) && is_array($params['vehicle'])) {
        $args['meta_query'][] = array('key' => 'vehicle', 'value' => $params['vehicle'], 'compare' => 'IN');
    }
    if (!empty($params['duration']) && is_array($params['duration'])) {
        $args['meta_query'][] = array('key' => 'length_of_stay', 'value' => $params['duration'], 'compare' => 'IN');
    }
    if (!empty($params['has_aghsat']) && $params['has_aghsat'] == '1') {
        $args['meta_query'][] = array('key' => 'aghsat', 'value' => '1', 'compare' => '=');
    }
    
    // فیلتر مقصد (Taxonomy)
    if (!empty($params['destination'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'hotel_city',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($params['destination']),
        );
    }

    // فیلتر تاریخ (Repeater: tarikh_harekat)
    global $wpdb;
    $date_from = !empty($params['date_from']) ? sanitize_text_field($params['date_from']) : '';
    $date_to   = !empty($params['date_to']) ? sanitize_text_field($params['date_to']) : '';
    
    if ($date_from || $date_to) {
        $sql = "SELECT DISTINCT post_id FROM {$wpdb->postmeta} WHERE meta_key LIKE 'tarikh_%_tarikh_harekat'";
        
        if ($date_from && $date_to) {
            $sql .= $wpdb->prepare(" AND meta_value BETWEEN %s AND %s", $date_from, $date_to);
        } elseif ($date_from) {
            $sql .= $wpdb->prepare(" AND meta_value >= %s", $date_from);
        } elseif ($date_to) {
            $sql .= $wpdb->prepare(" AND meta_value <= %s", $date_to);
        }
        
        $date_post_ids = $wpdb->get_col($sql);
        
        if (!empty($date_post_ids)) {
            $args['post__in'] = $date_post_ids;
        } else {
            $args['post__in'] = array(0); // نتیجه تهی
        }
    } 

    return $args;
}

/**
 * 5. تغییر کوئری اصلی آرشیو (Pre Get Posts)
 */
function seirosolok_modify_archive_query($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('tour')) {
        
        $params = array(
            'start_point' => isset($_GET['start_point']) ? $_GET['start_point'] : '',
            'min_price'   => isset($_GET['min_price']) ? $_GET['min_price'] : '',
            'max_price'   => isset($_GET['max_price']) ? $_GET['max_price'] : '',
            'vehicle'     => isset($_GET['vehicle']) ? $_GET['vehicle'] : '',
            'duration'    => isset($_GET['duration']) ? $_GET['duration'] : '',
            'has_aghsat'  => isset($_GET['has_aghsat']) ? $_GET['has_aghsat'] : '',
            'destination' => isset($_GET['destination']) ? $_GET['destination'] : '',
            'date_from'   => isset($_GET['date_from']) ? $_GET['date_from'] : '',
            'date_to'     => isset($_GET['date_to']) ? $_GET['date_to'] : '',
        );

        $args = seirosolok_get_tour_filter_args($params);

        foreach ($args as $key => $value) {
            $query->set($key, $value);
        }
    }
}
add_action('pre_get_posts', 'seirosolok_modify_archive_query');

/**
 * 6. هندلر AJAX برای فیلتر تورها
 */
function seirosolok_filter_tours_ajax() {
    $params = $_POST;
    $args = seirosolok_get_tour_filter_args($params);
    $args['paged'] = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $query = new WP_Query($args);

    ob_start();
    if( $query->have_posts() ) {
        while( $query->have_posts() ) {
            $query->the_post();
            include(locate_template('template-parts/content-tour-card.php')); 
        }
    } else {
        echo '<div class="col-span-full text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <i class="fas fa-search text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-500">متاسفانه توری با این مشخصات یافت نشد.</p>
              </div>';
    }
    $html_content = ob_get_clean();

    // صفحه بندی AJAX
    $pagination_html = '';
    if ( $query->max_num_pages > 1 ) {
        for ( $i = 1; $i <= $query->max_num_pages; $i++ ) {
            $active_class = ($args['paged'] == $i) ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200';
            $pagination_html .= '<button class="ajax-pagination-btn w-10 h-10 rounded-lg flex items-center justify-center font-bold transition ' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
        }
    }

    wp_send_json_success(array( 'html' => $html_content, 'count' => $query->found_posts, 'pagination' => $pagination_html ));
    wp_die();
}
add_action('wp_ajax_filter_tours', 'seirosolok_filter_tours_ajax');
add_action('wp_ajax_nopriv_filter_tours', 'seirosolok_filter_tours_ajax');

/**
 * 7. استایل‌های اضافی (فیکس فونت دیت‌پیکر)
 */
function seirosolok_custom_styles() {
    ?> 
    <style> 
        jdp-container { z-index: 999999 !important; } 
        .datepicker-plot-area { font-family: 'YekanBakh', sans-serif !important; } 
    </style> 
    <?php
}
add_action('wp_head', 'seirosolok_custom_styles');


// ---------------------------------------------------------
// بخش جدید: مدیریت رزروهای تور
// ---------------------------------------------------------

/**
 * 8. ساخت جدول رزروها هنگام فعال‌سازی قالب
 * نکته: برای اجرای این تابع باید یک بار قالب را غیرفعال و دوباره فعال کنید.
 */
function seirosolok_create_reservations_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'seirosolok_reservations';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        tour_name text NOT NULL,
        tour_date varchar(50) NOT NULL,
        fullname varchar(100) NOT NULL,
        mobile varchar(20) NOT NULL,
        status varchar(20) DEFAULT 'pending' NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'seirosolok_create_reservations_table');

/**
 * 9. هندلر AJAX برای ثبت رزرو در دیتابیس
 */
function seirosolok_submit_reservation_ajax() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'seirosolok_reservations';

    // دریافت و ایمن‌سازی داده‌ها
    $tour_name = isset($_POST['tour']) ? sanitize_text_field($_POST['tour']) : '';
    $tour_date = isset($_POST['tourDate']) ? sanitize_text_field($_POST['tourDate']) : '';
    $fullname  = isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']) : '';
    $mobile    = isset($_POST['mobile']) ? sanitize_text_field($_POST['mobile']) : '';

    // اعتبارسنجی
    if (empty($mobile) || empty($fullname)) {
        wp_send_json_error(array('message' => 'لطفاً نام و شماره موبایل خود را وارد کنید.'));
    }

    // درج در دیتابیس
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'tour_name' => $tour_name,
            'tour_date' => $tour_date,
            'fullname'  => $fullname,
            'mobile'    => $mobile,
            'status'    => 'pending'
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );

    if ($inserted) {
        wp_send_json_success(array('message' => 'رزرو شما با موفقیت ثبت شد. کارشناسان ما به زودی با شما تماس می‌گیرند.'));
    } else {
        wp_send_json_error(array('message' => 'متاسفانه مشکلی در ثبت اطلاعات رخ داد. لطفاً با پشتیبانی تماس بگیرید.'));
    }
}
add_action('wp_ajax_submit_reservation', 'seirosolok_submit_reservation_ajax');
add_action('wp_ajax_nopriv_submit_reservation', 'seirosolok_submit_reservation_ajax');

function get_reading_time() {
    global $post;
    
    // 1. گرفتن محتوای پست و حذف شورت‌کدها و تگ‌های HTML
    $content = get_post_field('post_content', $post->ID);
    $clean_content = strip_shortcodes($content);
    $clean_content = strip_tags($clean_content);
    
    // 2. شمارش کلمات (روش سازگار با فارسی)
    // متن را بر اساس فاصله‌های خالی تکه تکه می‌کنیم تا آرایه کلمات بدست بیاید
    $words = preg_split('/\s+/', $clean_content, -1, PREG_SPLIT_NO_EMPTY);
    $word_count = count($words);
    
    // 3. محاسبه زمان (میانگین سرعت مطالعه: ۲۰۰ تا ۲۵۰ کلمه در دقیقه)
    $words_per_minute = 200; 
    $minutes = ceil($word_count / $words_per_minute);
    
    // 4. تبدیل اعداد انگلیسی به فارسی
    $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_num = range(0, 9);
    $output = str_replace($english_num, $persian_num, $minutes);
    
    // اگر کمتر از ۱ دقیقه بود، بنویس ۱
    if($minutes < 1) {
        return '۱ دقیقه مطالعه';
    }
    
    return $output . ' دقیقه مطالعه';
}

// تابعی که تاکسونومی شهرها را می‌سازد (کد قبلی را پیدا و با این جایگزین کنید یا این را ویرایش کنید)
function register_hotel_city_taxonomy() {
    $labels = array(
        'name'              => 'شهرها',
        'singular_name'     => 'شهر',
        'search_items'      => 'جستجوی شهرها',
        'all_items'         => 'همه شهرها',
        'parent_item'       => 'شهر مادر',
        'parent_item_colon' => 'شهر مادر:',
        'edit_item'         => 'ویرایش شهر',
        'update_item'       => 'بروزرسانی شهر',
        'add_new_item'      => 'افزودن شهر جدید',
        'new_item_name'     => 'نام شهر جدید',
        'menu_name'         => 'شهرها',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        // تغییر مهم: تبدیل hotel_city به city در آدرس‌دهی
        'rewrite'           => array( 'slug' => 'city', 'with_front' => false ),
    );

    register_taxonomy( 'hotel_city', array( 'hotel', 'tour' ), $args );
}
add_action( 'init', 'register_hotel_city_taxonomy' );