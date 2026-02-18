<footer class="bg-gray-900 text-gray-300 pt-16 pb-24 md:pb-8 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10 text-center md:text-right">
            <div>
                <div class="flex items-center justify-center md:justify-start gap-3 mb-6">
                    <img src="https://seirosolok.com/wp-content/uploads/2024/12/Frame-21.png" class="h-10 w-auto brightness-0 invert" alt="لوگو سیر و سلوک">
                </div>
                <p class="text-sm leading-7 text-gray-400 mb-6">
                    اولین سامانه هوشمند رزرو تورهای زیارتی اقساطی. زیارت آسان حق هر عاشق است.
                </p>
            </div>
            <div class="hidden md:block">
                <h3 class="text-white font-bold text-lg mb-6">دسترسی سریع</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-gold-500 transition">درباره ما</a></li>
                    <li><a href="#" class="hover:text-gold-500 transition">قوانین و مقررات</a></li>
                    <li><a href="#" class="hover:text-gold-500 transition">پیگیری رزرو</a></li>
                </ul>
            </div>
            <div class="md:col-span-2">
                <h3 class="text-white font-bold text-lg mb-6">تماس با ما</h3>
                <ul class="space-y-4 text-sm flex flex-col items-center md:items-start">
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-primary-500"></i>
                        <a href="tel:+982188325674"><span class="dir-ltr text-lg">۰۲۱-۸۸۳۲۵۶۷۴</span></a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-primary-500"></i>
                        <a href="tel:+982188325674"><span class="dir-ltr text-lg">۰۲۱-۸۸۳۲۵۶۷۴</span></a>
                    </li>
                    <li class="flex items-start gap-3 text-center md:text-right">
                        <i class="fas fa-map-marker-alt text-primary-500 mt-1"></i>
                        <span>تهران خیابان مفتح شمالی بعد از پمپ بنزین پلاک ۲۷۳ برج مرجان طبقه ۱۲</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 text-center text-xs text-gray-600 flex flex-col gap-2">
            <p>© <?php echo date_i18n('Y'); ?> تمام حقوق برای آژانس مسافرتی سیر و سلوک محفوظ است.</p>
            <div class="flex items-center justify-center gap-1">
                <span>طراحی و توسعه با</span>
                <i class="fas fa-heart text-red-600 animate-pulse"></i>
                <span>توسط <a href="https://virapeak.ir/" target="_blank" class="text-[#10B981] font-bold hover:text-[#0ea5e9] transition-colors">ویراپیک</a></span>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    .swiper-pagination {
        position: relative !important;
        bottom: 0 !important;
        margin-top: 24px !important;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        z-index: 10;
    }
    .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background-color: #cbd5e1;
        opacity: 1;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 50%;
    }
    .swiper-pagination-bullet-active {
        width: 28px;
        border-radius: 100px;
        background-color: #B31D37 !important;
        box-shadow: 0 4px 6px -1px rgba(179, 29, 55, 0.3);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div id="auth-backdrop" onclick="closeAuthSheet()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[80] hidden opacity-0 transition-opacity duration-300"></div>
<div id="auth-sheet" class="fixed bottom-0 md:top-1/2 md:left-1/2 md:bottom-auto md:-translate-x-1/2 md:-translate-y-1/2 w-full md:w-[400px] bg-white z-[90] rounded-t-3xl md:rounded-3xl shadow-2xl transform translate-y-full md:translate-y-0 md:scale-95 transition-all duration-300 ease-out hidden">
    <div class="p-2 flex justify-center md:hidden">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
    </div>
    <div class="p-6 md:p-8">
        
        <div id="step-mobile">
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">ورود / ثبت‌نام</h3>
                <p class="text-sm text-gray-500 mt-2">برای استفاده از خدمات، شماره موبایل خود را وارد کنید</p>
            </div>
            <form id="form-mobile" class="space-y-4">
                <div class="relative dir-ltr">
                    <input type="tel" id="mobile-input" placeholder="09xxxxxxxxx" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-left font-sans text-lg focus:ring-2 focus:ring-primary-500 outline-none transition" maxlength="11" required>
                    <span class="absolute right-4 top-3.5 text-gray-400 text-sm">شماره موبایل</span>
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition active:scale-95 flex justify-center items-center gap-2">
                    <span>ارسال کد تایید</span>
                    <i class="fas fa-arrow-left text-sm"></i>
                </button>
            </form>
        </div>

        <div id="step-otp" class="hidden">
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">کد تایید را وارد کنید</h3>
                <p class="text-sm text-gray-500 mt-2">کد تایید به شماره <span id="display-mobile" class="font-bold text-gray-800"></span> ارسال شد</p>
            </div>
            <form id="form-otp" class="space-y-4">
                <div class="relative dir-ltr">
                    <input type="text" id="otp-input" placeholder="- - - -" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-center font-sans text-2xl tracking-[10px] focus:ring-2 focus:ring-primary-500 outline-none transition" maxlength="4" inputmode="numeric" required>
                </div>
                <div class="text-center text-xs text-gray-400 mb-2">
                    <span id="countdown">02:00</span> تا ارسال مجدد
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition active:scale-95 flex justify-center items-center gap-2">
                    <span>تایید و ادامه</span>
                </button>
            </form>
            <button onclick="changeMobile()" class="w-full mt-3 text-sm text-gray-500 hover:text-primary-600">
                ویرایش شماره
            </button>
        </div>

        <div id="step-name" class="hidden">
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">تکمیل ثبت‌نام</h3>
                <p class="text-sm text-gray-500 mt-2">شما قبلاً ثبت‌نام نکرده‌اید. لطفاً نام خود را وارد کنید</p>
            </div>
            <form id="form-name" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" id="name-input" placeholder="نام" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-right font-sans outline-none focus:ring-2 focus:ring-primary-500" required>
                    <input type="text" id="family-input" placeholder="نام خانوادگی" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-right font-sans outline-none focus:ring-2 focus:ring-primary-500" required>
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition active:scale-95 flex justify-center items-center gap-2">
                    <span>ورود به حساب</span>
                    <i class="fas fa-check text-sm"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<?php wp_footer(); ?>

<script>
    // تابع تبدیل اعداد فارسی به انگلیسی (بسیار مهم برای OTP)
    function toEnglishDigits(str) {
        if (!str) return str;
        const persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        const arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
        
        for (let i = 0; i < 10; i++) {
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
        return str;
    }

    jQuery(document).ready(function($) {
        
        let currentMobile = '';
        let countdownInterval;

        const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';

        // 1. ارسال شماره و دریافت OTP
        $('#form-mobile').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            
            // اصلاح شماره قبل از اعتبارسنجی
            let mobile = toEnglishDigits($('#mobile-input').val());
            
            if(mobile.length < 10 || !/^09[0-9]{9}$/.test(mobile)) { 
                alert('شماره موبایل نامعتبر است. مثال: 09121234567'); 
                return; 
            }

            btn.prop('disabled', true).addClass('opacity-75').text('در حال ارسال...');

            $.post(ajaxUrl, {
                action: 'send_otp',
                mobile: mobile
            }, function(res) {
                btn.prop('disabled', false).removeClass('opacity-75').html('<span>ارسال کد تایید</span><i class="fas fa-arrow-left text-sm"></i>');
                
                if(res.success) {
                    if(res.data.message && res.data.message.includes('ارسال شد')) {
                        // فقط پیام موفقیت ساده
                    } else if (res.data.message) {
                        alert(res.data.message);
                    }

                    currentMobile = mobile;
                    $('#display-mobile').text(mobile);
                    $('#step-mobile').addClass('hidden');
                    $('#step-otp').removeClass('hidden');
                    startTimer(120);
                } else {
                    alert(res.data.message);
                }
            }).fail(function() {
                alert('خطای ارتباط با سرور.');
                btn.prop('disabled', false).removeClass('opacity-75').html('<span>ارسال کد تایید</span><i class="fas fa-arrow-left text-sm"></i>');
            });
        });

        // 2. تایید OTP
        $('#form-otp').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            
            // اصلاح کد تایید (تبدیل فارسی به انگلیسی)
            const otp = toEnglishDigits($('#otp-input').val());

            // دیباگ برای اطمینان (در کنسول مرورگر قابل مشاهده است)
            console.log('Sending Verify Request:', { mobile: currentMobile, otp: otp });

            btn.prop('disabled', true).addClass('opacity-75').text('در حال بررسی...');

            $.post(ajaxUrl, {
                action: 'verify_otp',
                mobile: currentMobile,
                otp: otp
            }, function(res) {
                btn.prop('disabled', false).removeClass('opacity-75').text('تایید و ادامه');

                if(res.success) {
                    if(res.data.action === 'login') {
                        location.reload();
                    } else if(res.data.action === 'get_name') {
                        $('#step-otp').addClass('hidden');
                        $('#step-name').removeClass('hidden');
                    }
                } else {
                    alert(res.data.message);
                }
            }).fail(function() {
                alert('خطای ارتباط با سرور.');
                btn.prop('disabled', false).removeClass('opacity-75').text('تایید و ادامه');
            });
        });

        // 3. ثبت نام نهایی
        $('#form-name').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            const name = $('#name-input').val();
            const family = $('#family-input').val();

            btn.prop('disabled', true).addClass('opacity-75').text('در حال ثبت...');

            $.post(ajaxUrl, {
                action: 'register_user',
                mobile: currentMobile,
                name: name,
                family: family
            }, function(res) {
                if(res.success) {
                    location.reload();
                } else {
                    alert(res.data.message);
                    btn.prop('disabled', false).removeClass('opacity-75').text('ورود به حساب');
                }
            }).fail(function() {
                alert('خطای ارتباط با سرور.');
                btn.prop('disabled', false).removeClass('opacity-75').text('ورود به حساب');
            });
        });

        // تایمر
        function startTimer(duration) {
            let timer = duration, minutes, seconds;
            clearInterval(countdownInterval);
            countdownInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                $('#countdown').text(minutes + ":" + seconds);
                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    $('#countdown').text("ارسال مجدد کد").addClass('cursor-pointer text-primary-600 font-bold').click(function() {
                        changeMobile(); 
                    });
                }
            }, 1000);
        }

        window.changeMobile = function() {
            $('#step-otp').addClass('hidden');
            $('#step-mobile').removeClass('hidden');
            clearInterval(countdownInterval);
        }

        if (typeof $.fn.pDatepicker !== 'undefined') {
             $(".jalali-datepicker").pDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                calendar: { persian: { locale: 'fa' } }
            });
        }
    });

    // توابع مودال
    function openAuthSheet() {
        const backdrop = document.getElementById('auth-backdrop');
        const sheet = document.getElementById('auth-sheet');
        backdrop.classList.remove('hidden');
        sheet.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            sheet.classList.remove('translate-y-full', 'scale-95', 'opacity-0'); 
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeAuthSheet() {
        const backdrop = document.getElementById('auth-backdrop');
        const sheet = document.getElementById('auth-sheet');
        backdrop.classList.add('opacity-0');
        if(window.innerWidth < 768) {
            sheet.classList.add('translate-y-full');
        } else {
            sheet.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            backdrop.classList.add('hidden');
            sheet.classList.add('hidden');
        }, 300);
        document.body.style.overflow = '';
        setTimeout(() => {
            jQuery('#step-otp, #step-name').addClass('hidden');
            jQuery('#step-mobile').removeClass('hidden');
        }, 300);
    }
    
    function toggleMobileMenu() {
        const backdrop = document.getElementById('mobile-menu-backdrop');
        const drawer = document.getElementById('mobile-menu-drawer');
        if (drawer.classList.contains('-translate-x-full')) {
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                drawer.classList.remove('-translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            drawer.classList.add('-translate-x-full');
            setTimeout(() => { backdrop.classList.add('hidden'); }, 300);
            document.body.style.overflow = '';
        }
    }
</script>
</body>
</html>