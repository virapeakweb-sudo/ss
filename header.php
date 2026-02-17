<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- SEO Meta Tags are handled by Plugins or WP Head -->
    
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-50 font-sans text-gray-800 antialiased overflow-x-hidden selection:bg-primary-100 selection:text-primary-900' ); ?>>

    <!-- Mobile Menu Overlay (Full Screen from Left) -->
    <div id="mobile-menu-backdrop" onclick="toggleMobileMenu()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>
    <div id="mobile-menu-drawer" class="fixed top-0 left-0 bottom-0 w-[85%] max-w-sm bg-white z-[70] shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col h-full">
        <!-- Menu Header -->
        <div class="p-5 border-b flex justify-between items-center bg-gray-50">
            <div class="flex items-center gap-2">
                <img class="h-8 w-auto" src="https://seirosolok.com/wp-content/uploads/2024/12/Frame-21.png" alt="سیر و سلوک">
            </div>
            <button onclick="toggleMobileMenu()" class="text-gray-500 hover:text-red-500 transition p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Menu Items -->
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="<?php echo home_url(); ?>" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3 text-primary-700 bg-primary-50 rounded-xl font-bold">
                <i class="fas fa-home w-5"></i> صفحه اصلی
            </a>
            <a href="<?php echo home_url('/tours'); ?>" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl font-medium">
                <i class="fas fa-kaaba w-5"></i> تورهای کربلا
            </a>
            <a href="#installment" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl font-medium">
                <i class="fas fa-percent w-5"></i> شرایط اقساط
            </a>
            <a href="#features" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl font-medium">
                <i class="fas fa-hotel w-5"></i> خدمات هتل
            </a>
            <a href="tel:۰۲۱-۸۸۳۲۵۶۷۴" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl font-medium">
                <i class="fas fa-headset w-5"></i> پشتیبانی
            </a>
        </div>

        <!-- Menu Footer -->
        <div class="p-5 border-t bg-gray-50 mt-auto">
            <button onclick="openAuthSheet(); toggleMobileMenu();" class="w-full bg-primary-600 text-white py-3 rounded-xl font-bold shadow-lg hover:bg-primary-700 transition flex justify-center items-center gap-2">
                <i class="fas fa-user-circle"></i>
                ورود / ثبت نام
            </button>
            <div class="mt-4 flex justify-center gap-6 text-gray-400">
                <a href="#" class="hover:text-primary-600 transition"><i class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-primary-600 transition"><i class="fab fa-telegram text-xl"></i></a>
                <a href="#" class="hover:text-primary-600 transition"><i class="fas fa-phone text-xl"></i></a>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="fixed w-full z-40 transition-all duration-300 bg-white/95 shadow-sm backdrop-blur-md" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                <!-- Mobile Toggle Button -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-primary-600 focus:outline-none p-2 rounded-lg active:bg-gray-100 transition" aria-label="منو">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2 mx-auto md:mx-0">
                    <a href="<?php echo home_url(); ?>" class="flex items-center gap-2">
                        <img class="h-10 md:h-12 w-auto" src="https://seirosolok.com/wp-content/uploads/2024/12/Frame-21.png" alt="مجری تورهای زیارتی اقساطی سیر و سلوک" width="48" height="48">
                    
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 space-x-reverse">
                    <a href="<?php echo home_url(); ?>" class="text-primary-900 font-bold hover:text-gold-600 px-3 py-2 transition relative group">
                        صفحه اصلی
                        <span class="absolute bottom-0 right-0 w-full h-0.5 bg-gold-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-right"></span>
                    </a>
                    <a href="<?php echo home_url('/tours'); ?>" class="text-gray-600 hover:text-primary-700 px-3 py-2 transition">تورهای کربلا</a>
                    <a href="#installment" class="text-gray-600 hover:text-primary-700 px-3 py-2 transition">شرایط اقساط</a>
                    <a href="#features" class="text-gray-600 hover:text-primary-700 px-3 py-2 transition">خدمات</a>
                    <a href="#contact" class="text-gray-600 hover:text-primary-700 px-3 py-2 transition">تماس با ما</a>
                </div>

                <!-- Desktop CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <div class="flex flex-col items-end text-sm ml-2">
                        <span class="text-gray-500 text-xs">پشتیبانی ۲۴ ساعته</span>
                        <a href="tel:+982188325674" class="font-bold text-lg text-primary-800 dir-ltr tracking-tight">021-88325674</a>
                    </div>
                    <button onclick="openAuthSheet()" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-full shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-sm font-bold flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        ورود
                    </button>
                </div>

                <!-- Mobile Call Icon -->
                <div class="md:hidden flex items-center">
                    <a href="tel:02112345678" class="w-10 h-10 flex items-center justify-center bg-green-50 text-green-600 rounded-full hover:bg-green-100 transition">
                        <i class="fas fa-phone-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>