<?php get_header(); ?>

<main class="overflow-x-hidden">
    <!-- Hero Section -->
    <div class="relative bg-primary-900 h-[500px] md:h-[650px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="<?php echo get_template_directory_uri();?>/img/hero.jpg" 
                 class="w-full h-full object-cover opacity-40 animate-pulse bg-gray-800" 
                 alt="حرم مطهر کربلا"
                 onload="this.classList.remove('animate-pulse')">
            <div class="absolute inset-0 bg-gradient-to-t from-primary-900 via-primary-900/40 to-transparent"></div>
            <div class="absolute inset-0 hero-pattern opacity-30"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-[-30px] md:mt-[-50px]">
            <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-gold-500/20 border border-gold-500 text-gold-400 text-xs md:text-sm font-bold mb-6 backdrop-blur-sm">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-gold-500"></span>
                </span>
                ثبت نام کاروان‌های ویژه رمضان و نوروز آغاز شد
            </span>
            <h1 class="text-3xl md:text-6xl font-black text-white mb-4 md:mb-6 leading-tight drop-shadow-lg">
                سفر به کربلا، با شرایط
                <br class="hidden md:block">
                <span class="text-gold-500">اقساطی و بدون ضامن</span>
            </h1>
            <p class="text-base md:text-xl text-gray-200 mb-8 font-light max-w-2xl mx-auto px-4 md:px-0 leading-relaxed">
                زیارت آسان با تورهای متنوع. رزرو آنلاین، اعزام فوری و هتل‌های نزدیک به حرم با منوی غذایی ایرانی.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center px-6">
                <a href="#tours" class="w-full sm:w-auto bg-gold-500 hover:bg-gold-600 text-white px-8 py-3.5 rounded-xl font-bold text-lg shadow-lg shadow-orange-500/20 transition transform active:scale-95 flex items-center justify-center gap-2">
                    لیست کاروان‌ها
                    <i class="fas fa-arrow-left mt-1 text-sm"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Search Widget -->
    <div class="relative z-20 max-w-6xl mx-auto px-4 -mt-16 md:-mt-24 mb-10 md:mb-16">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-4 md:p-8 border border-gray-100">
            <!-- IMPORTANT: Action points to archive page, method is GET -->
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end" action="<?php echo get_post_type_archive_link('tour'); ?>" method="get">
                
                <!-- فیلد 1: مبدا حرکت -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-gray-700 pr-1">مبدا حرکت</label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute right-3 top-3.5 text-gray-400"></i>
                        <select name="start_point" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl py-3 pr-10 focus:ring-2 focus:ring-primary-500 outline-none appearance-none cursor-pointer">
                            <option value="">همه شهرها</option>
                            <option value="تهران">تهران</option>
                            <option value="مشهد">مشهد</option>
                            <option value="اصفهان">اصفهان</option>
                            <option value="شیراز">شیراز</option>
                            <option value="تبریز">تبریز</option>
                            <option value="قم">قم</option>
                            <option value="کرج">کرج</option>
                        </select>
                    </div>
                </div>

                <!-- فیلد 2: مقصد -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-gray-700 pr-1">مقصد سفر</label>
                    <div class="relative">
                        <i class="fas fa-kaaba absolute right-3 top-3.5 text-gray-400"></i>
                        <select name="destination" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl py-3 pr-10 focus:ring-2 focus:ring-primary-500 outline-none appearance-none cursor-pointer">
                            <option value="">همه مقاصد</option>
                            <?php
                            $cities = get_terms(array(
                                'taxonomy' => 'hotel_city',
                                'hide_empty' => false,
                            ));
                            if ( ! is_wp_error( $cities ) && ! empty( $cities ) ) {
                                foreach ( $cities as $city ) {
                                    echo '<option value="' . esc_attr( $city->slug ) . '">' . esc_html( $city->name ) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- فیلد 3: تاریخ رفت (نام فیلد date_from است برای هماهنگی با آرشیو) -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-gray-700 pr-1">تاریخ رفت</label>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute right-3 top-3.5 text-gray-400 z-10 pointer-events-none"></i>
                        <input type="text" name="date_from" data-jdp class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl py-3 pr-10 focus:ring-2 focus:ring-primary-500 outline-none cursor-pointer" placeholder="انتخاب تاریخ">
                    </div>
                </div>

                <!-- دکمه جستجو -->
                <div>
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl  transition duration-200 active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        جستجو
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Access Banners -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    <!-- کربلا -->
            <a href="#" class="block relative group hover:opacity-95 transition transform hover:-translate-y-1 rounded-xl overflow-hidden shadow-md">
                <img src="https://hs90.ir/seirosolok/wp-content/uploads/2026/01/home-karbala.webp" class="w-full h-[130px] object-cover" alt="تور کربلا">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <span class="absolute bottom-3 right-4 text-white font-black text-lg md:text-xl drop-shadow-lg">تور کربلا</span>
            </a>

            <!-- مشهد -->
            <a href="#" class="block relative group hover:opacity-95 transition transform hover:-translate-y-1 rounded-xl overflow-hidden shadow-md">
                <img src="https://hs90.ir/seirosolok/wp-content/uploads/2026/01/home-mashhad.webp" class="w-full h-[130px] object-cover" alt="تور مشهد">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <span class="absolute bottom-3 right-4 text-white font-black text-lg md:text-xl drop-shadow-lg">تور مشهد</span>
            </a>

                        <a href="#" class="block relative group hover:opacity-95 transition transform hover:-translate-y-1 rounded-xl overflow-hidden shadow-md">
                <img src="https://hs90.ir/seirosolok/wp-content/uploads/2026/01/home-kish.webp" class="w-full h-[130px] object-cover" alt="تور کیش">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <span class="absolute bottom-3 right-4 text-white font-black text-lg md:text-xl drop-shadow-lg">تور کیش</span>
            </a>
                        <a href="#" class="block relative group hover:opacity-95 transition transform hover:-translate-y-1 rounded-xl overflow-hidden shadow-md">
                <img src="https://hs90.ir/seirosolok/wp-content/uploads/2026/01/home-qeshm.webp" class="w-full h-[130px] object-cover" alt="تور قشم">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <span class="absolute bottom-3 right-4 text-white font-black text-lg md:text-xl drop-shadow-lg">تور قشم</span>
            </a>
        
        </div>
    </div>

    <!-- Tours Section -->
    <section class="py-12 md:py-16 bg-white" id="tours">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 gap-4">
                <div class="text-center md:text-right">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-2">لیست کاروان‌های اعزامی</h2>
                    <p class="text-gray-500 text-sm">بهترین تورها را بر اساس نیاز خود انتخاب کنید</p>
                </div>
                
                <!-- Filter Chips -->
                <div class="flex overflow-x-auto pb-4 md:pb-0 gap-2 w-full md:w-auto no-scrollbar snap-x px-1">
                    <button onclick="filterTours('all', this)" class="filter-btn active snap-center whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold border bg-primary-600 text-white border-transparent transition-all shadow-sm">همه تورها</button>
                    <button onclick="filterTours('airplane', this)" class="filter-btn snap-center whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold border border-gray-200 text-gray-600 hover:border-primary-500 transition-all">فقط هوایی</button>
                    <button onclick="filterTours('bus', this)" class="filter-btn snap-center whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold border border-gray-200 text-gray-600 hover:border-primary-500 transition-all">فقط زمینی</button>
                </div>
            </div>

            <!-- Tours Grid / Slider (Structure Modified for Swiper) -->
            <div class="swiper myToursSwiper md:!grid md:!grid-cols-2 lg:!grid-cols-3 md:!gap-8 md:!overflow-visible">
                <div class="swiper-wrapper md:!contents" id="tours-grid">
                    
                    <?php
                    $args = array(
                        'post_type'      => 'tour',
                        'posts_per_page' => 6,
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    );
                    
                    $tours_query = new WP_Query( $args );

                    if ( $tours_query->have_posts() ) :
                        while ( $tours_query->have_posts() ) : $tours_query->the_post();
                            include(locate_template('template-parts/content-tour-card.php')); 
                        endwhile; 
                        wp_reset_postdata(); 
                    else : 
                    ?>
                        <div class="col-span-full text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300 w-full">
                            <i class="fas fa-box-open text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">در حال حاضر توری موجود نیست.</p>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- Swiper Pagination (Only visible on mobile via CSS logic) -->
                <div class="swiper-pagination md:hidden mt-4"></div>
            </div>
            
            <div class="mt-12 text-center">
                 <a href="<?php echo get_post_type_archive_link('tour'); ?>" class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-600 font-bold px-8 py-3 rounded-xl hover:border-primary-600 hover:text-primary-600 transition shadow-sm hover:shadow-md">
                    مشاهده آرشیو کامل تورها
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Hotels Section -->
    <section class="py-12 md:py-16 bg-gray-50" id="hotels">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-1">هتل‌های پیشنهادی</h2>
                    <p class="text-gray-500 text-sm">اقامت در بهترین هتل‌های نزدیک به حرم</p>
                </div>
                <a href="<?php echo get_post_type_archive_link('hotel'); ?>" class="text-primary-600 text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                    مشاهده همه <i class="fas fa-chevron-left text-xs"></i>
                </a>
            </div>

            <!-- Hotels Slider/Grid -->
            <div class="flex overflow-x-auto snap-x gap-5 pb-8 -mx-4 px-4 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
                <?php
                $hotel_args = array(
                    'post_type'      => 'hotel',
                    'posts_per_page' => 4,
                );
                $hotels_query = new WP_Query($hotel_args);
                
                if($hotels_query->have_posts()):
                    while($hotels_query->have_posts()): $hotels_query->the_post();
                        $stars = get_field('stars');
                        $distance = get_field('distance_to_shrine');
                ?>
                <div class="min-w-[280px] snap-center md:min-w-0 bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-xl transition group">
                    <div class="relative h-48 overflow-hidden">
                        <?php if ( has_post_thumbnail() ) : ?>
                         <a href="<?php the_permalink(); ?>" >  <img src="<?php the_post_thumbnail_url('medium'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="<?php the_title(); ?>"></a>
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400"><i class="fas fa-hotel fa-3x"></i></div>
                        <?php endif; ?>
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-700 shadow-sm">
                            <i class="fas fa-map-marker-alt text-red-500 ml-1"></i> کربلا
                        </div>
                    </div>
                    <div class="p-4">
                        <h3><a href="<?php the_permalink(); ?>"  class="font-bold text-gray-900 text-lg mb-2 truncate"><?php the_title(); ?></a></h3>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-gold-400 text-xs">
                                <?php for($i=0; $i < ($stars ? $stars : 3); $i++) echo '<i class="fas fa-star"></i>'; ?>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                <?php echo $distance ? esc_html($distance) : 'نزدیک به حرم'; ?>
                            </span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="block w-full text-center bg-primary-50 text-primary-700 font-bold py-2 rounded-xl text-sm hover:bg-primary-600 hover:text-white transition">مشاهده و رزرو</a>
                    </div>
                </div>
                <?php 
                    endwhile; 
                    wp_reset_postdata();
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 md:py-16 bg-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-50 rounded-full blur-3xl opacity-50 -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold-50 rounded-full blur-3xl opacity-50 -ml-20 -mb-20"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-bold text-sm bg-primary-50 px-3 py-1 rounded-full">رضایت زائرین</span>
                <h2 class="text-2xl md:text-4xl font-black text-gray-900 mt-3 mb-4">تجربه سفر با سیر و سلوک</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">نظرات واقعی زائرینی که افتخار میزبانی آن‌ها را در تورهای کربلا و نجف داشته‌ایم.</p>
            </div>

            <div class="flex overflow-x-auto snap-x gap-6 pb-8 -mx-4 px-4 md:grid md:grid-cols-3 md:gap-6 md:overflow-visible md:pb-0 md:mx-0 md:px-0">
                <!-- Testimonial 1 -->
                <div class="min-w-[300px] snap-center md:min-w-0 bg-gray-50 p-6 rounded-2xl border border-gray-100 relative">
                    <i class="fas fa-quote-right text-4xl text-gray-200 absolute top-6 right-6"></i>
                    <p class="text-gray-600 text-sm leading-7 mb-6 relative z-10">
                        «بسیار سفر معنوی و خوبی بود. هتل واقعاً نزدیک حرم بود و خدمات غذایی عالی بود. مدیر کاروان هم بسیار دلسوزانه پیگیر کارها بودند. تشکر از تیم سیر و سلوک.»
                    </p>
                    <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold">م</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">محمد حسینی</h4>
                            <span class="text-xs text-gray-500">زائر تور هوایی کربلا - دی ۱۴۰۳</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="min-w-[300px] snap-center md:min-w-0 bg-gray-50 p-6 rounded-2xl border border-gray-100 relative mt-0 md:-mt-4 shadow-lg shadow-gray-200/50 bg-white">
                    <i class="fas fa-quote-right text-4xl text-primary-100 absolute top-6 right-6"></i>
                    <p class="text-gray-600 text-sm leading-7 mb-6 relative z-10">
                        «شرایط اقساطی واقعاً کمک کرد تا بتونم پدر و مادرم رو بفرستم کربلا. برخورد پرسنل عالی بود و همه چیز طبق برنامه پیش رفت. خدا خیرتون بده.»
                    </p>
                    <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
                        <div class="w-10 h-10 bg-gold-100 rounded-full flex items-center justify-center text-gold-600 font-bold">ع</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">علی رضایی</h4>
                            <span class="text-xs text-gray-500">زائر تور زمینی - آذر ۱۴۰۳</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="min-w-[300px] snap-center md:min-w-0 bg-gray-50 p-6 rounded-2xl border border-gray-100 relative">
                    <i class="fas fa-quote-right text-4xl text-gray-200 absolute top-6 right-6"></i>
                    <p class="text-gray-600 text-sm leading-7 mb-6 relative z-10">
                        «هتل انتخابی بسیار تمیز بود. وای‌فای هتل سرعت خوبی داشت و وعده‌های غذایی دقیقاً طبق منوی ایرانی بود که گفته بودند. حتماً دوباره با شما سفر خواهم کرد.»
                    </p>
                    <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold">س</div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">سارا کمالی</h4>
                            <span class="text-xs text-gray-500">زائر تور هوایی نجف - دی ۱۴۰۳</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultation CTA -->
    <section class="bg-primary-900 relative overflow-hidden py-12 md:py-20">
        <div class="absolute inset-0 z-0">
             <img src="<?php echo get_template_directory_uri(); ?>/img/bg-footer2.webp" class="w-full h-full object-cover opacity-20 md:opacity-100" alt="Background">
             <div class="absolute inset-0 bg-primary-900/80 md:bg-primary-900/40"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 md:p-12 border border-white/20 shadow-2xl text-center md:text-right flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1">
                    <h2 class="text-2xl md:text-4xl font-black text-white mb-3">هنوز تصمیم نگرفته‌اید؟</h2>
                    <p class="text-white/90 text-sm md:text-lg leading-relaxed max-w-2xl">
                        کارشناسان ما آماده‌اند تا بهترین تور را متناسب با بودجه و شرایط شما پیشنهاد دهند. مشاوره کاملاً رایگان است.
                    </p>
                </div>
                <a href="tel:+982188325674" class="w-full md:w-auto bg-white text-primary-900 px-8 py-4 rounded-xl font-black text-lg hover:bg-gray-50 transition shadow-lg shadow-black/20 flex items-center justify-center gap-3 group">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="group-hover:scale-105 transition-transform">تماس با مشاوران</span>
                    <span class="dir-ltr text-sm font-normal text-gray-500 mr-1 hidden md:inline-block">(۰۲۱-۸۸۳۲۵۶۷۴)</span>
                </a>
            </div>
        </div>
    </section>
</main>

<!-- اسکریپت‌ها: دیت‌پیکر، اسلایدر Swiper و فیلتر -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Jalali Datepicker Init
        if (typeof jalaliDatepicker !== 'undefined') {
            jalaliDatepicker.startWatch({
                minDate: "attr",
                maxDate: "attr",
                time: false, 
                hasSecond: false
            });
        }

        // 2. Initialize Swiper (Only active on Mobile)
        if (typeof Swiper !== 'undefined') {
            const swiper = new Swiper(".myToursSwiper", {
                slidesPerView: 1.2, // نمایش تکه‌ای از اسلاید بعدی
                spaceBetween: 16,
                centeredSlides: false,
                observer: true, // مهم برای کارکرد فیلتر
                observeParents: true, // مهم برای کارکرد فیلتر
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        enabled: false, // غیرفعال در دسکتاپ (تبدیل به گرید)
                        slidesPerView: 'auto',
                    }
                }
            });
        }

        // 3. Simple JS Filter for Tours
        window.filterTours = function(type, btn) {
            // A. تغییر استایل دکمه‌ها
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active', 'bg-primary-600', 'text-white', 'border-transparent');
                b.classList.add('bg-transparent', 'text-gray-600', 'border-gray-200');
            });
            btn.classList.add('active', 'bg-primary-600', 'text-white', 'border-transparent');
            btn.classList.remove('bg-transparent', 'text-gray-600', 'border-gray-200');

            // B. فیلتر کردن آیتم‌ها
            const items = document.querySelectorAll('.tour-card-item');
            items.forEach(item => {
                const vehicleType = item.getAttribute('data-vehicle');
                
                // مقایسه نوع (مقادیر data-vehicle باید 'airplane' یا 'bus' باشند)
                if (type === 'all') {
                    item.style.display = ''; // نمایش
                } else {
                    if (vehicleType === type) {
                        item.style.display = ''; // نمایش
                    } else {
                        item.style.display = 'none'; // مخفی
                    }
                }
            });
            
            // C. آپدیت اسلایدر (در صورت نیاز)
            if (typeof Swiper !== 'undefined' && document.querySelector('.myToursSwiper').swiper) {
                document.querySelector('.myToursSwiper').swiper.update();
            }
        }
    });
</script>

<?php get_footer(); ?>