<?php get_header(); ?>

<main class="bg-gray-50 min-h-screen pb-16">
    
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        // -----------------------------------------
        // 1. دریافت داده‌ها از ACF و وردپرس
        // -----------------------------------------
        $price = get_field('price');
        $special_price = get_field('special_price');
        
        // --- تغییر: دریافت تاریخ‌ها از ریپیتر ---
        $dates_repeater = get_field('tarikh'); // نام فیلد ریپیتر
        $available_dates = array();
        $next_date = '';

        if( have_rows('tarikh') ) {
            while( have_rows('tarikh') ) : the_row();
                $date_val = get_sub_field('tarikh_harekat');
                if($date_val) {
                    $available_dates[] = $date_val;
                }
            endwhile;
        }

        // اولین تاریخ را به عنوان تاریخ پیش‌فرض/نزدیک‌ترین تاریخ در نظر می‌گیریم
        if (!empty($available_dates)) {
            $next_date = $available_dates[0];
        } else {
            // پشتیبانی از فیلد قدیمی اگر ریپیتر خالی بود
            $next_date = get_field('start_date');
        }
        // -----------------------------------------

        $hotels = get_field('hotel'); // لیست هتل‌ها
        $aghsat = get_field('aghsat'); // وضعیت اقساط (True/False)

        // فیلدهای جدید
        $vehicle_select = get_field('vehicle'); // airplane, bus
        $length_of_stay = get_field('length_of_stay'); // 1, 2, ... 7, ...
        $food_service = get_field('food'); // صبحانه، نهار، شام ...
        $has_insurance = get_field('bime'); // True/False
        $price_under_2 = get_field('under_2_price');
        $price_2_12 = get_field('between_2_12_price');
        
        // فیلد ظرفیت
        $capacity = get_field('tour_capacity'); 
        $capacity = ($capacity !== '' && $capacity !== null) ? intval($capacity) : 5; 
        $is_sold_out = ($capacity <= 0);

        // -----------------------------------------
        // 2. منطق نمایش مقادیر انتخابی (Select Fields)
        // -----------------------------------------
        
        // الف) منطق وسیله سفر
        $vehicle_label = 'اتوبوس VIP'; // پیش‌فرض
        $vehicle_icon = 'fa-bus';
        $is_air_trip = false;

        if ($vehicle_select) {
            if ($vehicle_select === 'airplane') {
                $vehicle_label = 'سفر هوایی';
                $vehicle_icon = 'fa-plane';
                $is_air_trip = true;
            } elseif ($vehicle_select === 'bus') {
                $vehicle_label = 'سفر زمینی (اتوبوس)';
                $vehicle_icon = 'fa-bus';
            }
        } else {
            $tour_type_terms = get_the_terms( get_the_ID(), 'tour_type' );
            if ( $tour_type_terms && ! is_wp_error( $tour_type_terms ) ) {
                foreach($tour_type_terms as $tt) {
                    if(strpos($tt->slug, 'air') !== false || strpos($tt->slug, 'havayi') !== false) {
                        $vehicle_label = 'سفر هوایی';
                        $vehicle_icon = 'fa-plane';
                        $is_air_trip = true;
                        break;
                    }
                }
            }
        }

        // ب) منطق مدت اقامت
        $stay_choices = array(
            '1' => 'یک روز', '2' => '۲ روز', '3' => '۳ روز', '4' => '۴ روز',
            '5' => '۵ روز', '6' => '۶ روز', '7' => 'یک هفته', '8' => '۸ روز',
            '9' => '۹ روز', '10' => '۱۰ روز', '11' => '۱۱ روز', '12' => '۱۲ روز',
            '13' => '۱۳ روز', '14' => 'دو هفته'
        );
        $stay_label = isset($stay_choices[$length_of_stay]) ? $stay_choices[$length_of_stay] : ($length_of_stay . ' روز');


        // -----------------------------------------
        // 3. محاسبات مالی و اقساط
        // -----------------------------------------
        $final_price = $special_price ? $special_price : $price;
        
        $cash_payment = 0;
        $remaining_amount = 0;
        $monthly_installment_amount = 0;

        if($aghsat) {
            $cash_payment = $final_price * 0.5;
            $remaining_amount = $final_price - $cash_payment;
            $monthly_interest_rate = 0.05;
            $installment_months = 4;
            $total_interest = $remaining_amount * $monthly_interest_rate * $installment_months;
            $total_installment_debt = $remaining_amount + $total_interest;
            $monthly_installment_amount = $total_installment_debt / $installment_months;
        }
    ?>

    <!-- Header / Breadcrumb Area -->
    <div class="bg-primary-900 text-white pt-24 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20 z-0"></div>
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 text-primary-200 text-sm mb-2">
                        <a href="<?php echo home_url(); ?>" class="hover:text-white transition">خانه</a>
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span>تورها</span>
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span class="text-white font-bold"><?php the_title(); ?></span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black mb-4 leading-snug"><?php the_title(); ?></h1>
                    
                    <div class="flex flex-wrap items-center gap-3 text-sm md:text-base">
                        <?php if($next_date): ?>
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-lg">
                            <i class="fas fa-calendar-alt text-gold-400"></i>
                            <span>تاریخ رفت: <?php echo esc_html($next_date); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/10 px-3 py-1.5 rounded-lg">
                            <i class="fas <?php echo $vehicle_icon; ?> text-gold-400"></i>
                            <span><?php echo esc_html($vehicle_label); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Price Box (Desktop Only) -->
                <div class="hidden md:block bg-white text-gray-800 p-5 rounded-2xl shadow-xl min-w-[280px] border-b-4 border-gold-500">
                    <div class="text-center">
                        <span class="block text-gray-500 text-sm mb-1 font-medium">قیمت نهایی برای هر نفر</span>
                        <?php if($special_price): ?>
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <span class="text-red-600 font-black text-3xl tracking-tight"><?php echo number_format($special_price); ?></span>
                                <span class="text-xs text-gray-500 font-bold">تومان</span>
                            </div>
                            <span class="text-gray-400 line-through text-sm font-medium"><?php echo number_format($price); ?></span>
                        <?php else: ?>
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-primary-800 font-black text-3xl tracking-tight"><?php echo number_format($price); ?></span>
                                <span class="text-xs text-gray-500 font-bold">تومان</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- ستون محتوا (راست) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- تصویر اصلی / گالری -->
                <div class="bg-white rounded-2xl shadow-sm p-2 overflow-hidden border border-gray-100">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <img src="<?php the_post_thumbnail_url('full'); ?>" class="w-full h-[250px] sm:h-[350px] md:h-[450px] object-cover rounded-xl hover:scale-[1.01] transition duration-500" alt="<?php the_title(); ?>">
                    <?php endif; ?>
                </div>

                <!-- جدول مشخصات سریع -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border-b-4 border-primary-500 text-center hover:shadow-md transition">
                        <i class="fas fa-moon text-2xl text-primary-200 mb-2"></i>
                        <span class="block text-xs text-gray-500 mb-1">مدت اقامت</span>
                        <span class="font-bold text-gray-800"><?php echo $stay_label; ?></span>
                    </div>
                    
                    <div class="bg-white p-4 rounded-2xl shadow-sm border-b-4 border-gold-500 text-center hover:shadow-md transition">
                        <i class="fas <?php echo $vehicle_icon; ?> text-2xl text-gold-200 mb-2"></i>
                        <span class="block text-xs text-gray-500 mb-1">وسیله سفر</span>
                        <span class="font-bold text-gray-800 text-sm"><?php echo esc_html($vehicle_label); ?></span>
                    </div>

                    <div class="bg-white p-4 rounded-2xl shadow-sm border-b-4 border-blue-500 text-center hover:shadow-md transition">
                        <i class="fas fa-utensils text-2xl text-blue-200 mb-2"></i>
                        <span class="block text-xs text-gray-500 mb-1">پذیرایی</span>
                        <span class="font-bold text-gray-800 text-xs md:text-sm">
                            <?php echo $food_service ? esc_html($food_service) : 'فول برد (VIP)'; ?>
                        </span>
                    </div>
                    
                    <div class="bg-white p-4 rounded-2xl shadow-sm border-b-4 border-red-500 text-center hover:shadow-md transition">
                        <i class="fas fa-shield-alt text-2xl text-red-200 mb-2"></i>
                        <span class="block text-xs text-gray-500 mb-1">بیمه مسافرتی</span>
                        <span class="font-bold <?php echo $has_insurance ? 'text-green-600' : 'text-red-500'; ?>">
                            <?php echo $has_insurance ? 'دارد' : 'ندارد'; ?>
                        </span>
                    </div>
                </div>

                <!-- توضیحات کامل -->
                <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-primary-600 rounded-full"></span>
                        توضیحات سفر
                    </h2>
                    <div class="prose prose-sm md:prose-base max-w-none text-gray-600 leading-8 text-justify">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- لیست هتل‌ها -->
                <?php if($hotels): ?>
                <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-gold-500 rounded-full"></span>
                        هتل‌های محل اقامت
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php 
                        if(!is_array($hotels)) $hotels = array($hotels);
                        foreach($hotels as $hotel): 
                            $hotel_img = get_the_post_thumbnail_url($hotel->ID, 'medium');
                            $stars = get_field('stars', $hotel->ID); 
                            $distance = get_field('distance_to_shrine', $hotel->ID); 
                            $hotel_link = get_permalink($hotel->ID);
                        ?>
                        <a href="<?php echo esc_url($hotel_link); ?>" class="group block">
                            <div class="flex gap-4 border border-gray-100 bg-gray-50/50 rounded-xl p-3 hover:bg-white hover:shadow-md transition duration-300">
                                <div class="w-24 h-24 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden relative group-hover:opacity-90 transition">
                                    <?php if($hotel_img): ?>
                                        <img src="<?php echo $hotel_img; ?>" class="w-full h-full object-cover" alt="<?php echo $hotel->post_title; ?>">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-hotel fa-2x"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col justify-center py-1">
                                    <h3 class="font-bold text-gray-800 mb-1 text-lg group-hover:text-primary-600 transition"><?php echo $hotel->post_title; ?></h3>
                                    <div class="flex text-gold-400 text-xs mb-3">
                                        <?php 
                                        $star_count = $stars ? $stars : 3;
                                        for($i=0; $i < $star_count; $i++) echo '<i class="fas fa-star"></i>'; 
                                        ?>
                                    </div>
                                    <span class="text-[10px] text-gray-500 bg-white border border-gray-200 px-2 py-1 rounded-md w-max shadow-sm">
                                        <i class="fas fa-map-marker-alt text-red-400 ml-1"></i>
                                        <?php echo $distance ? esc_html($distance) : 'نزدیک به حرم'; ?>
                                    </span>
                                </div>
                                <div class="mr-auto self-center opacity-0 group-hover:opacity-100 transition -translate-x-2 group-hover:translate-x-0 text-gray-400">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- ستون کناری (چپ) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-5">
                    
                    <!-- 1. کارت رزرو -->
                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-6 border border-gray-100 relative overflow-hidden">
                        <!-- نوار بالا: وضعیت ظرفیت -->
                        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                            <span class="font-bold text-gray-500 text-sm">وضعیت ظرفیت:</span>
                            <?php if($is_sold_out): ?>
                                <span class="text-gray-500 font-bold bg-gray-100 border border-gray-200 px-3 py-1 rounded-full text-xs">
                                    <i class="fas fa-ban ml-1"></i>تکمیل ظرفیت
                                </span>
                            <?php else: ?>
                                <span class="text-red-600 font-bold bg-red-50 border border-red-100 px-3 py-1 rounded-full text-xs animate-pulse">
                                    <i class="fas fa-fire ml-1"></i><?php echo $capacity; ?> نفر باقی‌مانده
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- انتخاب تاریخ سفر (جدید) -->
                        <?php if(!empty($available_dates) && count($available_dates) > 0): ?>
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">انتخاب تاریخ حرکت:</label>
                            <div class="relative">
                                <i class="fas fa-calendar-day absolute right-3 top-3.5 text-gray-400 z-10 pointer-events-none"></i>
                                <select class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl py-3 pr-10 pl-3 focus:ring-2 focus:ring-primary-500 outline-none appearance-none cursor-pointer" name="tarikh_harekat">
                                    <?php foreach($available_dates as $date): ?>
                                        <option value="<?php echo esc_attr($date); ?>"><?php echo esc_html($date); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="fas fa-chevron-down absolute left-3 top-4 text-xs text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- قیمت (موبایل) -->
                        <div class="md:hidden text-center mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="block text-gray-500 text-xs mb-1">قیمت نهایی</span>
                             <?php if($special_price): ?>
                                <span class="text-red-600 font-black text-2xl"><?php echo number_format($special_price); ?></span>
                            <?php else: ?>
                                <span class="text-primary-800 font-black text-2xl"><?php echo number_format($price); ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-gray-400">تومان</span>
                        </div>
                        
                        <!-- نرخ کودکان -->
                        <?php if($price_under_2 || $price_2_12): ?>
                        <div class="bg-blue-50 rounded-xl p-3 mb-4 text-xs space-y-2 border border-blue-100">
                            <h5 class="font-bold text-blue-800 mb-2 flex items-center gap-1"><i class="fas fa-child"></i> نرخ ویژه کودکان:</h5>
                            <?php if($price_under_2): ?>
                            <div class="flex justify-between text-blue-700">
                                <span>زیر ۲ سال:</span>
                                <span class="font-bold">
                                    <?php echo is_numeric($price_under_2) ? number_format($price_under_2) . ' تومان' : esc_html($price_under_2); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if($price_2_12): ?>
                            <div class="flex justify-between text-blue-700">
                                <span>۲ تا ۱۲ سال:</span>
                                <span class="font-bold">
                                    <?php echo is_numeric($price_2_12) ? number_format($price_2_12) . ' تومان' : esc_html($price_2_12); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <!-- دکمه رزرو -->
                        <?php if($is_sold_out): ?>
                            <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-xl shadow-none cursor-not-allowed flex justify-center items-center gap-2">
                                <i class="fas fa-times-circle"></i>
                                ظرفیت تکمیل شد
                            </button>
                        <?php else: ?>
                            <button onclick="openAuthSheet()" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary-600/30 transition transform hover:-translate-y-1 mb-3 flex justify-center items-center gap-2 group">
                                <span class="bg-white/20 rounded-full w-6 h-6 flex items-center justify-center group-hover:bg-white/30 transition">
                                    <i class="fas fa-check text-xs"></i>
                                </span>
                                رزرو آنلاین تور
                            </button>
                        <?php endif; ?>
                        
                        <!-- دکمه تماس -->
                        <a href="tel:02188881234" class="w-full bg-white border-2 border-primary-100 text-primary-700 hover:border-primary-600 hover:text-primary-800 font-bold py-3.5 rounded-xl transition flex justify-center items-center gap-2 mt-3">
                            <i class="fas fa-phone-alt"></i>
                            مشاوره تلفنی رایگان
                        </a>

                        <?php if($aghsat): ?>
                        <div class="mt-4 pt-4 border-t border-dashed border-gray-200 text-xs text-gray-500 text-center leading-5">
                            <i class="fas fa-info-circle text-blue-500 ml-1"></i>
                            امکان پرداخت اقساطی برای این تور فعال است.
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- 2. باکس محاسبه اقساط (فقط اگر اقساطی باشد) -->
                    <?php if($aghsat): ?>
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 border border-gray-200 shadow-sm relative overflow-hidden">
                        <!-- دکور -->
                        <div class="absolute -top-6 -left-6 w-20 h-20 bg-green-100 rounded-full opacity-50 blur-xl"></div>

                        <div class="flex items-center gap-2 mb-5 border-b border-gray-200 pb-3 relative z-10">
                            <div class="bg-green-100 p-2 rounded-lg text-green-600">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <h4 class="font-bold text-gray-800">شرایط اقساط (۴ ماهه)</h4>
                        </div>
                        
                        <div class="space-y-3 text-sm relative z-10">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">مبلغ کل تور:</span>
                                <span class="font-bold text-gray-800"><?php echo number_format($final_price); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center bg-green-50 p-2.5 rounded-xl border border-green-100">
                                <span class="text-green-800 font-bold text-xs flex items-center gap-1">
                                    <i class="fas fa-check-circle"></i> پیش‌پرداخت (۵۰٪):
                                </span>
                                <span class="font-black text-green-700"><?php echo number_format($cash_payment); ?> <span class="text-[10px] font-normal opacity-70">تومان</span></span>
                            </div>

                            <div class="flex justify-between items-center px-1">
                                <span class="text-gray-500">مانده تسهیلات:</span>
                                <span class="font-medium text-gray-700"><?php echo number_format($remaining_amount); ?></span>
                            </div>

                             <div class="flex justify-between items-center px-1">
                                <span class="text-gray-500">سود ماهانه:</span>
                                <span class="font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded text-xs">۵ درصد</span>
                            </div>

                            <div class="mt-4 pt-4 border-t-2 border-dashed border-gray-200">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-700 font-bold text-xs">مبلغ هر قسط (۴ چک):</span>
                                </div>
                                <div class="text-left bg-gray-800 text-white p-3 rounded-xl shadow-md transform hover:scale-105 transition">
                                    <div class="flex items-end justify-center gap-1 line-height-1">
                                        <span class="text-2xl font-black tracking-tighter"><?php echo number_format($monthly_installment_amount); ?></span>
                                        <span class="text-[10px] text-gray-300 mb-1">تومان</span>
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 text-center flex items-center justify-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> چک صیادی بنفش الزامی است.
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- 3. باکس خدمات رایگان (داینامیک شده با ACF Repeater) -->
                    <?php if( have_rows('free_services') ): ?>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">
                            <i class="fas fa-gift text-gold-500"></i> خدمات ویژه و رایگان:
                        </h4>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <?php while( have_rows('free_services') ): the_row(); 
                                $service_title = get_sub_field('title');
                                if($service_title):
                            ?>
                            <li class="flex items-start gap-2.5">
                                <i class="fas fa-check-circle text-green-500 mt-1 shrink-0"></i>
                                <span class="leading-6"><?php echo esc_html($service_title); ?></span>
                            </li>
                            <?php 
                                endif;
                            endwhile; 
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>