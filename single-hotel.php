<?php get_header(); ?>

<!-- افزودن استایل و اسکریپت لایت‌باکس (Fancybox) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<main class="bg-gray-50 min-h-screen pb-16">
    
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        // -----------------------------------------
        // دریافت داده‌ها از ACF
        // -----------------------------------------
        $stars = get_field('stars');
        $distance = get_field('distance_to_shrine');
        $address = get_field('hotel_address');
        $facilities = get_field('hotel_facilities'); // آرایه
        $gallery = get_field('hotel_gallery');
        
        // مختصات جغرافیایی
        $lat = get_field('lat');
        $long = get_field('long');
        
        // ذخیره ID هتل فعلی برای کوئری بعدی
        $current_hotel_id = get_the_ID();
    ?>

    <!-- Hero / Header -->
    <div class="relative h-[300px] md:h-[400px] bg-gray-800 overflow-hidden">
        <?php if ( has_post_thumbnail() ) : ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" class="w-full h-full object-cover opacity-60" alt="<?php the_title(); ?>">
        <?php else: ?>
            <div class="w-full h-full bg-gray-700 flex items-center justify-center text-white/20"><i class="fas fa-hotel fa-4x"></i></div>
        <?php endif; ?>
        
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12 z-10">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <div class="flex items-center gap-2 text-white/80 text-sm mb-2">
                        <a href="<?php echo home_url(); ?>" class="hover:text-white">خانه</a>
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span>هتل‌ها</span>
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span class="text-white font-bold"><?php the_title(); ?></span>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black text-white mb-3 shadow-sm"><?php the_title(); ?></h1>
                    <div class="flex items-center gap-4 text-white">
                        <div class="flex text-gold-400 text-sm">
                            <?php 
                            $star_count = $stars ? $stars : 3;
                            for($i=0; $i < $star_count; $i++) echo '<i class="fas fa-star"></i>'; 
                            ?>
                        </div>
                        <?php if($distance): ?>
                        <div class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            <i class="fas fa-walking"></i> <?php echo esc_html($distance); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Right Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Gallery with Lightbox -->
                <?php if($gallery): ?>
                <div class="bg-white rounded-2xl shadow-sm p-4">
                    <h2 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">تصاویر هتل</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <?php foreach( $gallery as $image ): ?>
                            <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="hotel-gallery" data-caption="<?php echo esc_attr($image['title']); ?>" class="aspect-square rounded-xl overflow-hidden cursor-pointer group relative block">
                                <img src="<?php echo esc_url($image['sizes']['medium']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="<?php echo esc_attr($image['alt']); ?>">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition transform scale-75 group-hover:scale-100"></i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
                    <h2 class="font-bold text-gray-800 mb-4 text-lg flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary-500"></i> معرفی هتل
                    </h2>
                    <div class="prose prose-sm md:prose-base max-w-none text-gray-600 leading-8 text-justify">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Facilities (Corrected) -->
                <?php if($facilities): ?>
                <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
                    <h2 class="font-bold text-gray-800 mb-6 text-lg flex items-center gap-2">
                        <i class="fas fa-concierge-bell text-gold-500"></i> امکانات رفاهی
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach($facilities as $facility): 
                            // بررسی اینکه آیا مقدار بازگشتی آرایه است یا رشته ساده
                            $label = is_array($facility) ? $facility['label'] : $facility;
                        ?>
                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm font-medium text-gray-700"><?php echo esc_html($label); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- Left Column (Sidebar) -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Map & Navigation -->
                <?php if($lat && $long): ?>
                <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-200">
                    <div class="rounded-xl overflow-hidden border border-gray-200 mb-4">
                        <iframe 
                            width="100%" 
                            height="200" 
                            frameborder="0" 
                            scrolling="no" 
                            marginheight="0" 
                            marginwidth="0" 
                            src="https://maps.google.com/maps?q=<?php echo esc_attr($lat); ?>,<?php echo esc_attr($long); ?>&hl=fa&z=15&output=embed"
                            class="w-full"
                        >
                        </iframe>
                    </div>

                    <h4 class="font-bold text-gray-800 mb-3 text-sm text-center">مسیریابی با اپلیکیشن‌ها:</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <!-- نشان -->
                        <a href="nshn:<?php echo $lat; ?>,<?php echo $long; ?>" class="flex items-center justify-center gap-2 bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                             نشان <i class="fas fa-location-arrow"></i>
                        </a>
                        <!-- بلد -->
                        <a href="balad://route?dest_lat=<?php echo $lat; ?>&dest_long=<?php echo $long; ?>&mode=driving" class="flex items-center justify-center gap-2 bg-green-600 text-white py-2 rounded-lg text-sm hover:bg-green-700 transition">
                             بلد <i class="fas fa-map-marked-alt"></i>
                        </a>
                        <!-- ویز -->
                        <a href="https://waze.com/ul?ll=<?php echo $lat; ?>,<?php echo $long; ?>&navigate=yes" class="flex items-center justify-center gap-2 bg-cyan-500 text-white py-2 rounded-lg text-sm hover:bg-cyan-600 transition">
                             ویز <i class="fab fa-waze"></i>
                        </a>
                        <!-- گوگل مپ -->
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $lat; ?>,<?php echo $long; ?>" target="_blank" class="flex items-center justify-center gap-2 bg-gray-100 text-gray-700 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                             گوگل <i class="fab fa-google"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Address & Contact -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border-t-4 border-primary-500">
                    <h3 class="font-bold text-gray-800 mb-4">آدرس و موقعیت</h3>
                    <?php if($address): ?>
                    <p class="text-gray-600 text-sm leading-7 mb-4">
                        <i class="fas fa-map-pin text-red-500 ml-1"></i>
                        <?php echo nl2br(esc_html($address)); ?>
                    </p>
                    <?php endif; ?>
                    
                    <div class="bg-blue-50 p-4 rounded-xl flex items-center gap-3">
                        <div class="bg-white p-2 rounded-full text-blue-500">
                            <i class="fas fa-headset text-xl"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500">نیاز به راهنمایی دارید؟</span>
                            <span class="font-bold text-gray-800 dir-ltr block">021 - 8888 1234</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- بخش جدید: لیست تورهای مرتبط با این هتل -->
        <?php
        // کوئری برای پیدا کردن تورهایی که این هتل را در فیلد 'hotel' انتخاب کرده‌اند
        $related_tours = new WP_Query(array(
            'post_type' => 'tour',
            'posts_per_page' => 3, // نمایش ۳ تور آخر
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'hotel', // نام فیلد در پست تایپ تور
                    'value' => '"' . $current_hotel_id . '"', // برای زمانی که دیتای Serialize شده داریم (آرایه)
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'hotel',
                    'value' => $current_hotel_id, // برای زمانی که فقط یک ID ذخیره شده است
                    'compare' => '='
                )
            )
        ));

        if ($related_tours->have_posts()) :
        ?>
        <div class="mt-16 pt-10 border-t border-gray-200">
            <h2 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <span class="w-2 h-8 bg-primary-600 rounded-full"></span>
                تورهای فعال با اقامت در <?php the_title(); ?>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                while ($related_tours->have_posts()) : $related_tours->the_post();
                    // فراخوانی کارت تور از فایل template-parts
                    include(locate_template('template-parts/content-tour-card.php'));
                endwhile; 
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <?php endwhile; endif; ?>

</main>

<script>
    // فعال‌سازی Fancybox
    Fancybox.bind("[data-fancybox]", {
        // تنظیمات دلخواه
        Thumbs : {
            type: "modern"
        }
    });
</script>

<?php get_footer(); ?>