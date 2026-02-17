<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        // محاسبه زمان مطالعه
        $content = get_post_field( 'post_content', $post->ID );
        $word_count = str_word_count( strip_tags( $content ) );
        $reading_time = ceil( $word_count / 250 );
        
        // دریافت آواتار نویسنده
        $author_id = get_the_author_meta('ID');
        $author_avatar = get_avatar_url($author_id);
    ?>

    <nav class="flex text-sm text-gray-500 mb-6 overflow-x-auto whitespace-nowrap pb-2">
        <ol class="flex items-center gap-2">
            <li><a href="<?php echo home_url(); ?>" class="hover:text-primary-600 transition"><i class="fas fa-home ml-1"></i>خانه</a></li>
            <li class="text-gray-300">/</li>
            <li><a href="<?php echo home_url('/blog'); ?>" class="hover:text-primary-600 transition">مجله گردشگری</a></li>
            <li class="text-gray-300">/</li>
            <?php 
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo '<li><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="hover:text-primary-600 transition">' . esc_html( $categories[0]->name ) . '</a></li>';
                echo '<li class="text-gray-300">/</li>';
            }
            ?>
            <li class="text-primary-900 font-bold truncate max-w-[200px]" aria-current="page"><?php the_title(); ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <article class="lg:col-span-8">
            
            <header class="mb-8">
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                        foreach($tags as $tag) {
                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="bg-primary-50 text-primary-600 px-3 py-1 rounded-full text-xs font-bold border border-primary-100 hover:bg-primary-100 transition">' . $tag->name . '</a>';
                        }
                    } else {
                        // اگر تگ نداشت، دسته‌بندی را نشان بده
                        foreach($categories as $cat) {
                            echo '<span class="bg-gold-50 text-gold-600 px-3 py-1 rounded-full text-xs font-bold border border-gold-100">' . $cat->name . '</span>';
                        }
                    }
                    ?>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 leading-tight mb-6">
                    <?php the_title(); ?>
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 border-b border-gray-200 pb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 overflow-hidden">
                            <?php if($author_avatar): ?>
                                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php the_author(); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fas fa-user-tie"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <span class="block text-gray-900 font-bold"><?php the_author(); ?></span>
                            <span class="text-xs">نویسنده</span>
                        </div>
                    </div>
                    <span class="hidden sm:inline w-1 h-1 bg-gray-300 rounded-full"></span>
                    <div class="flex items-center gap-1">
                        <i class="far fa-calendar-alt"></i>
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                    </div>
                    <span class="hidden sm:inline w-1 h-1 bg-gray-300 rounded-full"></span>
                    <div class="flex items-center gap-1">
    <i class="far fa-clock"></i>
    <span><?php echo get_reading_time(); ?></span>
</div>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
            <figure class="mb-10 relative group rounded-2xl overflow-hidden shadow-xl border border-gray-100">
                <img 
                    src="<?php the_post_thumbnail_url('full'); ?>" 
                    alt="<?php the_title(); ?>" 
                    class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-700 ease-in-out"
                >
            </figure>
            <?php endif; ?>

            <div id="post-content" class="prose prose-lg prose-gray max-w-none prose-img:rounded-xl prose-headings:font-black prose-headings:text-primary-900 prose-a:text-gold-600 prose-a:no-underline hover:prose-a:underline">
                <?php the_content(); ?>
            </div>

            <div class="mt-16 bg-white border border-gray-200 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-6 shadow-md">
                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php the_author(); ?>" class="w-20 h-20 rounded-full object-cover border-4 border-gold-100">
                <div class="text-center md:text-right flex-1">
                    <div class="flex flex-col md:flex-row md:justify-between items-center mb-2">
                        <h3 class="font-bold text-xl text-primary-900">درباره نویسنده: <?php the_author(); ?></h3>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        <?php echo get_the_author_meta('description') ? get_the_author_meta('description') : 'نویسنده و کارشناس گردشگری در مجموعه سیر و سلوک.'; ?>
                    </p>
                </div>
            </div>

        </article>

        <aside class="lg:col-span-4 space-y-8">
            
            <div class="sticky top-24">
                
                <div id="toc-container" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6 hidden lg:block">
                    <h5 class="font-bold text-primary-900 mb-4 flex items-center gap-2 border-b pb-3">
                        <i class="fas fa-list-ul text-gold-500"></i>
                        فهرست مطالب
                    </h5>
                    <nav id="toc-list" class="space-y-1">
                        </nav>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="bg-primary-900 px-6 py-4">
                        <h5 class="font-bold text-white text-sm flex items-center gap-2">
                            <i class="fas fa-plane-departure"></i>
                            پیشنهاد تورهای زیارتی
                        </h5>
                    </div>
                    <div class="p-4 space-y-4">
                        <?php
                        // کوئری برای دریافت ۳ تور آخر
                        $sidebar_tours = new WP_Query(array(
                            'post_type' => 'tour',
                            'posts_per_page' => 3,
                            'post_status' => 'publish'
                        ));

                        if ($sidebar_tours->have_posts()) :
                            while ($sidebar_tours->have_posts()) : $sidebar_tours->the_post();
                                $price = get_field('price');
                                $special_price = get_field('special_price');
                                $final_price = $special_price ? $special_price : $price;
                                $start_date = get_field('start_date'); // یا دریافت از ریپیتر
                        ?>
                        <a href="<?php the_permalink(); ?>" class="flex gap-4 group items-center border-b border-gray-100 last:border-0 pb-4 last:pb-0">
                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden relative">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('thumbnail'); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500"><i class="fas fa-mosque"></i></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h6 class="text-sm font-bold text-gray-800 group-hover:text-primary-600 transition line-clamp-1"><?php the_title(); ?></h6>
                                <?php if($start_date): ?>
                                <span class="text-xs text-gray-500 block mt-1"><i class="far fa-calendar text-gold-500 ml-1"></i><?php echo esc_html($start_date); ?></span>
                                <?php endif; ?>
                                <span class="text-xs font-bold text-green-600 mt-1 block"><?php echo number_format($final_price); ?> تومان</span>
                            </div>
                        </a>
                        <?php 
                            endwhile; 
                            wp_reset_postdata();
                        else:
                            echo '<p class="text-xs text-gray-500 text-center">تور فعالی یافت نشد.</p>';
                        endif; 
                        ?>
                    </div>
                    <div class="p-3 bg-gray-50 text-center border-t border-gray-100">
                            <a href="<?php echo get_post_type_archive_link('tour'); ?>" class="text-xs font-bold text-primary-600 hover:text-primary-800">مشاهده همه تورها <i class="fas fa-arrow-left mr-1"></i></a>
                    </div>
                </div>

                <div class="mt-8">
                    <span class="block text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider">اشتراک‌گذاری این مطلب</span>
                    <div class="flex gap-2">
                        <a href="https://t.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="flex-1 bg-blue-500 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-blue-600 transition flex justify-center items-center gap-2 shadow-lg shadow-blue-500/20">
                            <i class="fab fa-telegram-plane"></i> تلگرام
                        </a>
                        <a href="https://wa.me/?text=<?php the_permalink(); ?>" target="_blank" class="flex-1 bg-green-500 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-green-600 transition flex justify-center items-center gap-2 shadow-lg shadow-green-500/20">
                            <i class="fab fa-whatsapp"></i> واتساپ
                        </a>
                    </div>
                </div>

            </div>
        </aside>
    </div>

    <?php endwhile; endif; ?>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Auto Generate Table of Contents
        const content = document.getElementById('post-content');
        const tocList = document.getElementById('toc-list');
        const tocContainer = document.getElementById('toc-container');
        
        if (content && tocList) {
            const headers = content.querySelectorAll('h2');
            
            if (headers.length > 0) {
                headers.forEach((header, index) => {
                    // Assign ID if missing
                    if (!header.id) {
                        header.id = 'section-' + (index + 1);
                    }
                    
                    // Create Link
                    const link = document.createElement('a');
                    link.href = '#' + header.id;
                    link.className = 'toc-link block text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 px-3 py-2 rounded-lg transition border-r-2 border-transparent hover:border-primary-500';
                    link.innerText = header.innerText;
                    
                    tocList.appendChild(link);
                });
            } else {
                // Hide TOC if no h2 found
                if(tocContainer) tocContainer.style.display = 'none';
            }
        }

        // 2. Scroll Spy / Active State Highlighter
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    document.querySelectorAll('.toc-link').forEach(link => {
                        link.classList.remove('text-primary-600', 'bg-primary-50', 'border-primary-500');
                        link.classList.add('text-gray-600', 'border-transparent');
                    });
                    
                    const id = entry.target.getAttribute('id');
                    const link = document.querySelector(`.toc-link[href="#${id}"]`);
                    if (link) {
                        link.classList.remove('text-gray-600', 'border-transparent');
                        link.classList.add('text-primary-600', 'bg-primary-50', 'border-primary-500');
                    }
                }
            });
        }, { rootMargin: '-100px 0px -60% 0px' });

        if(content) {
            content.querySelectorAll('h2').forEach((section) => {
                observer.observe(section);
            });
        }
    });
</script>

<?php get_footer();?>