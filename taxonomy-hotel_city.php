<?php get_header(); ?>

<main class="bg-gray-50 min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 mb-2">تورهای کربلا و نجف</h1>
                <p class="text-gray-500 text-sm">لیست کامل تورهای زیارتی با بهترین قیمت و کیفیت</p>
            </div>
            <div class="text-sm text-gray-500 hidden md:block">
                <span id="result-count" class="font-bold text-gray-900"><?php echo $wp_query->found_posts; ?></span> تور موجود
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                <!-- Mobile Filter Toggle -->
                <div class="lg:hidden mb-4 sticky top-20 z-30">
                    <button id="mobile-filter-toggle" class="w-full bg-white border border-gray-200 text-gray-700 font-bold py-3 rounded-xl shadow-sm flex justify-center items-center gap-2 hover:bg-gray-50 transition">
                        <i class="fas fa-sliders-h text-primary-600"></i> فیلتر پیشرفته
                    </button>
                </div>

                <!-- Filter Container -->
                <div id="filter-sidebar" class="fixed inset-0 z-50 bg-white lg:bg-transparent lg:static lg:block hidden lg:z-auto transition-transform duration-300 transform translate-y-full lg:translate-y-0 flex flex-col lg:block">
                    <div class="lg:hidden flex justify-between items-center p-4 border-b border-gray-100 bg-white sticky top-0 z-10">
                        <span class="font-bold text-gray-800 text-lg">فیلتر تورها</span>
                        <button id="close-filter-sidebar" class="text-gray-500 hover:text-red-500 p-2"><i class="fas fa-times text-xl"></i></button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-5 lg:p-0 lg:overflow-visible">
                        <div class="bg-white lg:rounded-2xl lg:shadow-sm lg:border lg:border-gray-100 lg:p-5 lg:sticky lg:top-24">
                            <div class="hidden lg:flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800">فیلترها</h3>
                                <button id="reset-filters" class="text-xs text-red-500 hover:text-red-700 transition">حذف همه</button>
                            </div>

                            <form id="tour-filter-form" class="space-y-6 pb-20 lg:pb-0">
                                <!-- Pre-fill Values from URL -->
                                <?php 
                                    $start_point_val = isset($_GET['start_point']) ? sanitize_text_field($_GET['start_point']) : '';
                                    $date_from_val = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
                                    $destination_val = isset($_GET['destination']) ? sanitize_text_field($_GET['destination']) : '';
                                ?>
                                <input type="hidden" name="destination" value="<?php echo esc_attr($destination_val); ?>">

                                <!-- Start Point -->
                                <div>
                                    <h4 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-map-marker-alt text-primary-500"></i> مبدا حرکت</h4>
                                    <select name="start_point" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary-500 outline-none transition cursor-pointer">
                                        <option value="">همه شهرها</option>
                                        <option value="تهران" <?php selected($start_point_val, 'تهران'); ?>>تهران</option>
                                        <option value="مشهد" <?php selected($start_point_val, 'مشهد'); ?>>مشهد</option>
                                        <option value="اصفهان" <?php selected($start_point_val, 'اصفهان'); ?>>اصفهان</option>
                                        <option value="شیراز" <?php selected($start_point_val, 'شیراز'); ?>>شیراز</option>
                                        <option value="تبریز" <?php selected($start_point_val, 'تبریز'); ?>>تبریز</option>
                                        <option value="قم" <?php selected($start_point_val, 'قم'); ?>>قم</option>
                                        <option value="کرج" <?php selected($start_point_val, 'کرج'); ?>>کرج</option>
                                    </select>
                                </div>

                                <!-- Date Range -->
                                <div>
                                    <h4 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-calendar-alt text-primary-500"></i> تاریخ سفر</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <input type="text" name="date_from" value="<?php echo esc_attr($date_from_val); ?>" data-jdp class="w-full bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 text-xs text-center focus:ring-1 focus:ring-primary-500 outline-none cursor-pointer" placeholder="از تاریخ">
                                        </div>
                                        <div class="relative">
                                            <input type="text" name="date_to" data-jdp class="w-full bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 text-xs text-center focus:ring-1 focus:ring-primary-500 outline-none cursor-pointer" placeholder="تا تاریخ">
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle -->
                                <div>
                                    <h4 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-plane text-primary-500"></i> وسیله سفر</h4>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 cursor-pointer group hover:bg-gray-50 p-1 rounded transition">
                                            <input type="checkbox" name="vehicle[]" value="airplane" class="rounded text-primary-600 focus:ring-primary-500 border-gray-300 w-4 h-4">
                                            <span class="text-sm text-gray-600">هوایی</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer group hover:bg-gray-50 p-1 rounded transition">
                                            <input type="checkbox" name="vehicle[]" value="bus" class="rounded text-primary-600 focus:ring-primary-500 border-gray-300 w-4 h-4">
                                            <span class="text-sm text-gray-600">زمینی (اتوبوس)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div>
                                    <h4 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-tag text-primary-500"></i> محدوده قیمت (تومان)</h4>
                                    <div class="flex gap-2 items-center">
                                        <input type="number" name="min_price" placeholder="از" class="w-1/2 bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 text-sm text-center focus:ring-1 focus:ring-primary-500 outline-none dir-ltr">
                                        <span class="text-gray-400">-</span>
                                        <input type="number" name="max_price" placeholder="تا" class="w-1/2 bg-gray-50 border border-gray-200 rounded-lg px-2 py-2 text-sm text-center focus:ring-1 focus:ring-primary-500 outline-none dir-ltr">
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div>
                                    <h4 class="font-bold text-sm text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-clock text-primary-500"></i> مدت اقامت</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <?php
                                        $durations = [3, 4, 5, 6, 7, 8];
                                        foreach ($durations as $d) {
                                            echo '<label class="cursor-pointer">
                                                    <input type="checkbox" name="duration[]" value="' . $d . '" class="hidden peer">
                                                    <span class="block px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-500 peer-checked:bg-primary-50 peer-checked:text-primary-700 peer-checked:border-primary-500 transition hover:bg-gray-100">' . $d . ' شب</span>
                                                  </label>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Aghsat -->
                                <div>
                                    <label class="flex items-center gap-2 cursor-pointer bg-green-50 p-3 rounded-xl border border-green-100 hover:bg-green-100 transition">
                                        <input type="checkbox" name="has_aghsat" value="1" class="rounded text-green-600 focus:ring-green-500 border-gray-300 w-5 h-5">
                                        <span class="text-sm font-bold text-green-800">فقط تورهای اقساطی</span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="lg:hidden p-4 bg-white border-t border-gray-200 sticky bottom-0 z-10 shadow-lg">
                        <div class="flex gap-3">
                            <button id="apply-filters-mobile" class="flex-1 bg-primary-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-primary-700 transition">مشاهده نتایج</button>
                            <button id="reset-filters-mobile" class="px-4 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition"><i class="fas fa-redo-alt"></i></button>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <div id="filter-loader" class="hidden text-center py-20">
                    <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-t-primary-600"></div>
                    <p class="mt-3 text-gray-500 text-sm font-medium">در حال جستجو...</p>
                </div>
                
                <div id="tours-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    // از کوئری اصلی وردپرس استفاده می‌کنیم که توسط functions.php فیلتر شده است
                    if(have_posts()):
                        while(have_posts()): the_post();
                            include(locate_template('template-parts/content-tour-card.php')); 
                        endwhile;
                    else:
                        echo '<div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-gray-800 font-bold mb-2">توری یافت نشد!</h3>
                                <p class="text-gray-500 text-sm">لطفاً فیلترهای جستجو را تغییر دهید.</p>
                              </div>';
                    endif;
                    ?>
                </div>
                
                <div id="pagination-container" class="mt-12 flex justify-center gap-2">
                    <?php
                    // صفحه‌بندی ساده PHP برای لود اولیه
                    $total_pages = $wp_query->max_num_pages;
                    if ($total_pages > 1) {
                        $current_page = max(1, get_query_var('paged'));
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($current_page == $i) ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200';
                            echo '<button class="ajax-pagination-btn w-10 h-10 rounded-lg flex items-center justify-center font-bold transition ' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof jalaliDatepicker !== 'undefined') {
            jalaliDatepicker.startWatch({ minDate: "attr", maxDate: "attr", time: false, hasSecond: false });
        }
        
        const mobileToggle = document.getElementById('mobile-filter-toggle');
        const sidebar = document.getElementById('filter-sidebar');
        const closeBtn = document.getElementById('close-filter-sidebar');
        const applyBtn = document.getElementById('apply-filters-mobile');
        
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.remove('hidden');
            setTimeout(() => sidebar.classList.remove('translate-y-full'), 10);
            document.body.style.overflow = 'hidden';
        });
        function closeSidebar() {
            sidebar.classList.add('translate-y-full');
            setTimeout(() => sidebar.classList.add('hidden'), 300);
            document.body.style.overflow = '';
        }
        closeBtn.addEventListener('click', closeSidebar);
        applyBtn.addEventListener('click', closeSidebar);
    });
</script>

<?php get_footer(); ?>