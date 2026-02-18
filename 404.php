<?php get_header(); ?>

<main class="relative min-h-screen flex items-center justify-center bg-primary-900 overflow-hidden text-center px-4 py-20">
    
    <div class="absolute inset-0">
        <img src="<?php echo get_template_directory_uri(); ?>/img/bg-footer.webp" class="w-full h-full object-cover opacity-10 blur-sm" alt="Background">
        <div class="absolute inset-0 hero-pattern opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-primary-900/90 via-primary-900/80 to-primary-900"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto">
        
        <div class="mb-8 relative inline-block">
            <div class="absolute inset-0 bg-gold-500 blur-[60px] opacity-20 rounded-full animate-pulse"></div>
            <i class="fas fa-compass text-7xl md:text-9xl text-gold-500/90 drop-shadow-2xl animate-float"></i>
        </div>

        <h1 class="text-3xl md:text-4xl font-black text-white mb-6 leading-tight">
            انگار مسیر کاروان تغییر کرده است...
        </h1>
        
        <p class="text-primary-200 text-lg md:text-xl mb-2 text-white">
            صفحه‌ای که به دنبال آن بودید پیدا نشد.
        </p>
        <p class="text-white text-sm mb-10 leading-relaxed max-w-lg mx-auto">
            در مسیر عاشقی گاهی گم شدن بخشی از رسیدن است. نگران نباشید، تمامی راه‌ها در نهایت به مقصد می‌رسند.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="<?php echo home_url(); ?>" class="w-full sm:w-auto px-8 py-3.5 bg-gold-500 hover:bg-gold-600 text-white rounded-xl font-bold transition shadow-lg shadow-gold-500/20 flex items-center justify-center gap-2 transform hover:-translate-y-1">
                <i class="fas fa-home"></i>
                بازگشت به خانه
            </a>
            <a href="<?php echo get_post_type_archive_link('tour'); ?>" class="w-full sm:w-auto px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-xl font-bold transition backdrop-blur-sm flex items-center justify-center gap-2">
                <i class="fas fa-kaaba"></i>
                مشاهده تورها
            </a>
        </div>

        <div class="mt-12 max-w-md mx-auto relative">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                <input type="search" name="s" class="w-full bg-primary-800/50 border border-primary-700 text-white placeholder-primary-400 rounded-full py-3 pr-5 pl-12 focus:ring-2 focus:ring-gold-500 outline-none transition text-sm" placeholder="جستجو در سایت...">
                <button type="submit" class="absolute left-1.5 top-1.5 bottom-1.5 bg-gold-500 hover:bg-gold-600 text-white w-10 h-10 rounded-full flex items-center justify-center transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

    </div>

    <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-[15rem] md:text-[25rem] font-black text-white/[0.03] select-none pointer-events-none z-0 dir-ltr">
        404
    </span>

</main>

<style>
    /* انیمیشن شناور برای آیکون */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>

<?php get_footer(); ?>