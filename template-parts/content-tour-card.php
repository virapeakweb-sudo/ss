<?php
/**
 * Template part for displaying tour cards.
 *
 * @package SeiroSolok
 */

// 1. دریافت داده‌ها (Data Fetching)
// --------------------------------------------------
$price          = get_field('price');
$special_price  = get_field('special_price');
$aghsat         = get_field('aghsat');
$vehicle        = get_field('vehicle'); // 'airplane' or 'bus'
$start_point    = get_field('start_point');

// هتل‌ها
$hotels = get_field('hotel');
$hotel_name = '';
if( $hotels ) {
    if ( is_array($hotels) && !empty($hotels) ) {
        // اگر آرایه است، اولی را بگیر
        $first_hotel = $hotels[0];
        $hotel_name = isset($first_hotel->post_title) ? $first_hotel->post_title : '';
    } elseif ( is_object($hotels) ) {
        // اگر آبجکت است
        $hotel_name = $hotels->post_title;
    }
}

// لیبل‌های ویژه
$labels = array();
if( have_rows('special_offer') ):
    while( have_rows('special_offer') ) : the_row();
        $label = get_sub_field('tour_lable');
        if($label) $labels[] = $label;
    endwhile;
endif;

// تاریخ: دریافت اولین تاریخ از ریپیتر
$next_date = get_field('start_date'); // فال‌بک به فیلد قدیمی
if( have_rows('tarikh') ) {
    while( have_rows('tarikh') ) : the_row();
        $date_val = get_sub_field('tarikh_harekat');
        if($date_val) {
            $next_date = $date_val; // اولین تاریخ معتبر را پیدا کن و بشکن
            break; 
        }
    endwhile;
}
 // لینک
$permalink = get_permalink();
$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
?>

<article class="tour-card group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full relative">
    
    <!-- Image Area -->
    <div class="relative h-48 overflow-hidden bg-gray-200">
        <?php if ( $thumbnail ) : ?>
            <img loading="lazy" src="<?php echo esc_url($thumbnail); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700" alt="<?php the_title(); ?>">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100"><i class="fas fa-image fa-2x"></i></div>
        <?php endif; ?>

        <!-- Top Badges (Aghsat & Labels) -->
        <div class="absolute top-3 right-3 flex flex-col gap-1 z-10 items-end">
            <?php if($aghsat): ?>
                <span class="bg-green-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm flex items-center gap-1">
                    <i class="fas fa-percent text-[9px]"></i> اقساطی
                </span>
            <?php endif; ?>
            
            <?php foreach($labels as $label): ?>
                <span class="bg-gold-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-md">
                    <?php echo esc_html($label); ?>
                </span>
            <?php endforeach; ?>
        </div>
        
        <!-- Bottom Badges (Hotel & Vehicle) -->
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-10 flex justify-between items-end">
             <div class="flex items-center gap-1">
                 <?php if($hotel_name): ?>
                    <span class="text-[10px] font-bold bg-black/40 backdrop-blur-md text-white px-2 py-1 rounded flex items-center gap-1">
                        <i class="fas fa-hotel text-gold-400"></i> <?php echo esc_html($hotel_name); ?>
                    </span>
                <?php endif; ?>
             </div>

            <span class="text-[10px] font-bold bg-white/20 backdrop-blur-md text-white px-2 py-1 rounded flex items-center gap-1">
                <i class="fas <?php echo ($vehicle == 'airplane') ? 'fa-plane' : 'fa-bus'; ?>"></i>
                <?php echo ($vehicle == 'airplane') ? 'هوایی' : 'زمینی'; ?>
            </span>
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="p-4 flex-1 flex flex-col">
        
        <!-- Title -->
        <h3 class="text-base font-bold text-gray-900 mb-3 leading-snug line-clamp-2 min-h-[2.5rem]">
            <a href="<?php echo esc_url($permalink); ?>" class="hover:text-primary-600 transition"><?php the_title(); ?></a>
        </h3>
        
        <!-- Info Rows -->
        <div class="space-y-2 text-xs text-gray-500 mb-4 flex-1">
            <?php if( $start_point ): ?>
            <div class="flex items-center gap-2">
                <i class="fas fa-location-arrow text-primary-500 w-4 text-center"></i>
                <span>مبدا: <span class="font-bold text-gray-700"><?php echo esc_html($start_point); ?></span></span>
            </div>
            <?php endif; ?>
            
            <?php if($next_date): ?>
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar-alt text-primary-500 w-4 text-center"></i>
                <span>تاریخ: <span class="font-bold text-gray-700"><?php echo esc_html($next_date); ?></span></span>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Footer: Price & Button -->
        <div class="mt-auto pt-3 border-t border-dashed border-gray-100">
            <div class="flex items-end justify-between mb-3">
                <span class="text-xs text-gray-400 font-medium pb-1">قیمت:</span>
                <div class="text-left">
                    <?php if($special_price): ?>
                        <div class="flex flex-col items-end">
                            <span class="block text-[10px] text-gray-400 line-through decoration-red-400"><?php echo number_format($price); ?></span>
                            <div class="flex items-center gap-1 text-red-600">
                                <span class="text-lg font-black"><?php echo number_format($special_price); ?></span>
                                <span class="text-[10px] font-normal text-gray-500">تومان</span>
                            </div>
                        </div>
                    <?php elseif($price): ?>
                        <div class="flex items-center gap-1 text-primary-700">
                            <span class="text-lg font-black"><?php echo number_format($price); ?></span>
                            <span class="text-[10px] font-normal text-gray-500">تومان</span>
                        </div>
                    <?php else: ?>
                        <span class="text-sm font-bold text-gray-500">تماس بگیرید</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <a href="<?php echo esc_url($permalink); ?>" class="group/btn w-full bg-primary-50 text-primary-700 border border-primary-100 hover:bg-primary-600 hover:text-white hover:border-primary-600 py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                مشاهده و رزرو
                <i class="fas fa-chevron-left text-[10px] transition-transform group-hover/btn:-translate-x-1"></i>
            </a>
        </div>

    </div>
</article>