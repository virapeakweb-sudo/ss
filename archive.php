<?php get_header(); ?>

<main class="bg-gray-50 min-h-screen pb-16 ">

    <div class="bg-primary-900 text-white py-16 relative overflow-hidden ">
        <div class="absolute inset-0 bg-black/20 z-0"></div>
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-black mb-4">مجله گردشگری سیر و سلوک</h1>
            <p class="text-primary-200 text-lg max-w-2xl mx-auto font-light">
                جدیدترین اخبار، دانستنی‌های سفر و راهنمای جامع زیارت عتبات عالیات
            </p>
        </div>
    </div>

    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <ol class="flex items-center gap-2 text-sm text-gray-500">
                <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-600 transition"><i class="fas fa-home ml-1"></i>خانه</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-primary-900 font-bold">بلاگ و مقالات</li>
            </ol>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8">
                
                <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-300 flex flex-col h-full group">
                            
                            <a href="<?php the_permalink(); ?>" class="relative h-48 overflow-hidden block">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="<?php the_title(); ?>">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php 
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) : 
                                ?>
                                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-primary-700 shadow-sm">
                                        <?php echo esc_html( $categories[0]->name ); ?>
                                    </span>
                                <?php endif; ?>
                            </a>

                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                    <span class="flex items-center gap-1"><i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span class="flex items-center gap-1"><i class="far fa-user"></i> <?php the_author(); ?></span>
                                </div>

                                <h2 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary-600 transition">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <p class="text-gray-500 text-sm line-clamp-3 mb-4 leading-relaxed">
                                    <?php echo get_the_excerpt(); ?>
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                                    <a href="<?php the_permalink(); ?>" class="text-primary-600 text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all">
                                        ادامه مطلب <i class="fas fa-arrow-left text-xs"></i>
                                    </a>
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <i class="far fa-comment"></i> <?php echo get_comments_number(); ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="mt-12 flex justify-center gap-2">
                    <?php
                    echo paginate_links( array(
                        'prev_text' => '<i class="fas fa-chevron-right"></i>',
                        'next_text' => '<i class="fas fa-chevron-left"></i>',
                        'mid_size'  => 2,
                        'type'      => 'list',
                        'class'     => 'flex gap-2',
                    ) );
                    ?>
                    <style>
                        ul.page-numbers { display: flex; gap: 8px; }
                        .page-numbers {
                            display: flex; align-items: center; justify-content: center;
                            width: 40px; height: 40px; border-radius: 8px;
                            background: white; border: 1px solid #e5e7eb;
                            color: #374151; font-weight: bold; transition: all 0.2s;
                        }
                        .page-numbers.current, .page-numbers:hover {
                            background: #16a34a; color: white; border-color: #16a34a;
                        }
                        .page-numbers.dots { border: none; background: transparent; }
                    </style>
                </div>

                <?php else : ?>
                    <div class="bg-white rounded-2xl p-10 text-center border border-dashed border-gray-300">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-700">مطلبی یافت نشد</h3>
                        <p class="text-gray-500 mt-2">متاسفانه مقاله‌ای با این مشخصات وجود ندارد.</p>
                    </div>
                <?php endif; ?>

            </div>

            <aside class="lg:col-span-4 space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm border-b pb-3">جستجو در مقالات</h3>
                    <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="relative">
                        <input type="search" name="s" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pr-4 pl-10 text-sm focus:ring-1 focus:ring-primary-500 outline-none transition" placeholder="جستجو کنید..." value="<?php echo get_search_query(); ?>">
                        <button type="submit" class="absolute left-3 top-3 text-gray-400 hover:text-primary-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm border-b pb-3">دسته‌بندی‌ها</h3>
                    <ul class="space-y-2">
                        <?php
                        $categories = get_categories();
                        foreach($categories as $cat) {
                            echo '<li>
                                <a href="' . get_category_link($cat->term_id) . '" class="flex justify-between items-center text-sm text-gray-600 hover:text-primary-600 hover:bg-gray-50 p-2 rounded-lg transition">
                                    <span>' . $cat->name . '</span>
                                    <span class="bg-gray-100 text-gray-500 text-xs py-0.5 px-2 rounded-full">' . $cat->count . '</span>
                                </a>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm border-b pb-3">آخرین مقالات</h3>
                    <div class="space-y-4">
                        <?php
                        $recent_posts = new WP_Query(array('posts_per_page' => 4, 'post_status' => 'publish', 'ignore_sticky_posts' => 1));
                        while($recent_posts->have_posts()) : $recent_posts->the_post();
                        ?>
                        <a href="<?php the_permalink(); ?>" class="flex gap-3 group">
                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 group-hover:text-primary-600 transition line-clamp-2 leading-6"><?php the_title(); ?></h4>
                                <span class="text-xs text-gray-400 mt-1 block"><?php echo get_the_date(); ?></span>
                            </div>
                        </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>

                <div class="bg-primary-900 rounded-2xl p-6 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-[url('img/pattern.png')] opacity-10 group-hover:opacity-20 transition duration-700"></div>
                    <div class="relative z-10">
                        <i class="fas fa-kaaba text-4xl text-gold-500 mb-3"></i>
                        <h3 class="text-white font-black text-xl mb-2">سفر به کربلا</h3>
                        <p class="text-gray-300 text-sm mb-6">تورهای اقساطی کربلا با بهترین امکانات و هتل‌های درجه یک.</p>
                        <a href="<?php echo home_url('/tours'); ?>" class="inline-block w-full bg-gold-500 hover:bg-gold-600 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                            مشاهده تورها
                        </a>
                    </div>
                </div>

            </aside>
            
        </div>
    </div>
</main>

<?php get_footer(); ?>