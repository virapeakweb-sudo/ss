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
                        <a href="tel:+989191239001"><span class="dir-ltr text-lg">۰۹۱۹۱۲۳۹۰۰۱</span></a>
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

<div id="auth-backdrop" onclick="closeAuthSheet()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[80] hidden opacity-0 transition-opacity duration-300"></div>
<div id="auth-sheet" class="fixed bottom-0 md:top-1/2 md:left-1/2 md:bottom-auto md:-translate-x-1/2 md:-translate-y-1/2 w-full md:w-[400px] bg-white z-[90] rounded-t-3xl md:rounded-3xl shadow-2xl transform translate-y-full md:translate-y-0 md:scale-95 transition-all duration-300 ease-out hidden">
    <div class="p-2 flex justify-center md:hidden">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
    </div>
    <div class="p-6 md:p-8">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">ثبت اطلاعات شما</h3>
            <p class="text-sm text-gray-500 mt-2">برای رزرو تور یا پیگیری سفارش شماره موبایل و نام خود را وارد کنید</p>
        </div>

        <form id="reservation-form" class="space-y-4" method="POST">
            
            <input type="hidden" name="action" value="submit_reservation">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تور درخواستی</label>
                <div class="relative dir-rtl">
                    <input type="text" name="tour" value="<?php if(is_single()) the_title(); ?>" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-3 text-right font-sans text-lg outline-none transition cursor-not-allowed" readonly required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاریخ انتخابی</label>
                <div class="relative dir-rtl">
                    <input type="text" name="tourDate" id="modal-tour-date" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-3 text-right font-sans text-lg outline-none transition cursor-not-allowed" readonly required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">نام و نام خانوادگی</label>
                <div class="relative dir-rtl">
                    <input type="text" name="fullname" placeholder="مثال: علی علوی" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-right font-sans text-lg focus:ring-2 focus:ring-primary-500 outline-none transition" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">شماره موبایل</label>
                <div class="relative dir-ltr">
                    <input type="tel" name="mobile" placeholder="0912..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-left font-sans text-lg focus:ring-2 focus:ring-primary-500 outline-none transition" pattern="[0-9]*" inputmode="numeric" required>
                    <span class="absolute right-4 top-3.5 text-gray-400 text-sm">IR (+98)</span>
                </div>
            </div>
            
            <button type="submit" id="submit-btn" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary-500/30 transition active:scale-95 flex justify-center items-center gap-2">
                <span>ثبت رزرو</span>
                <i class="fas fa-spinner fa-spin hidden" id="btn-spinner"></i>
            </button>
        </form>

        <button onclick="closeAuthSheet()" class="w-full mt-4 text-gray-400 text-sm hover:text-gray-600 p-2">
            انصراف
        </button>
    </div>
</div>

<?php wp_footer(); ?>

<script>
    jQuery(document).ready(function($) {
        
        // 1. همگام‌سازی تاریخ
        const pageDateSelect = $('select[name="tarikh_harekat"]');
        const modalDateInput = $('#modal-tour-date');

        function syncDate() {
            if (pageDateSelect.length > 0) {
                modalDateInput.val(pageDateSelect.val());
            }
        }
        syncDate();
        pageDateSelect.on('change', syncDate);

        // 2. ارسال فرم با AJAX
        $('#reservation-form').on('submit', function(e) {
            e.preventDefault(); // جلوگیری از رفرش صفحه
            
            const form = $(this);
            const submitBtn = $('#submit-btn');
            const spinner = $('#btn-spinner');
            const btnText = submitBtn.find('span');

            // قفل کردن دکمه
            submitBtn.prop('disabled', true).addClass('opacity-75');
            spinner.removeClass('hidden');
            btnText.text('در حال ثبت...');

            const formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.data.message);
                        closeAuthSheet();
                        form[0].reset();
                    } else {
                        alert(response.data.message);
                    }
                },
                error: function() {
                    alert('خطای ارتباط با سرور.');
                },
                complete: function() {
                    // بازگرداندن دکمه
                    submitBtn.prop('disabled', false).removeClass('opacity-75');
                    spinner.addClass('hidden');
                    btnText.text('ثبت رزرو');
                }
            });
        });

        // 3. Persian Datepicker Init
        if (typeof $.fn.pDatepicker !== 'undefined') {
             $(".jalali-datepicker").pDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                calendar: { persian: { locale: 'fa' } }
            });
        }
    });

    // توابع کمکی منو و مودال
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

    function openAuthSheet() {
        // سینک کردن تاریخ قبل از باز شدن
        const select = document.querySelector('select[name="tarikh_harekat"]');
        const input = document.getElementById('modal-tour-date');
        if(select && input) input.value = select.value;

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
    }
</script>
</body>
</html>