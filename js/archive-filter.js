jQuery(document).ready(function ($) {

    const filterForm = $('#tour-filter-form');
    const toursContainer = $('#tours-container');
    const resultCount = $('#result-count');
    const loader = $('#filter-loader');
    const paginationContainer = $('#pagination-container');

    // Function to fetch tours
    function fetchTours(page = 1) {
        // Show loader & fade content
        toursContainer.addClass('opacity-40 pointer-events-none');
        loader.removeClass('hidden');

        // Collect filter data
        let formData = filterForm.serialize();

        // Add action and page
        let data = formData + '&action=filter_tours&page=' + page;

        $.ajax({
            url: seirosolok_ajax.ajax_url,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.success) {
                    // Update Content
                    toursContainer.html(response.data.html);
                    resultCount.text(response.data.count);
                    paginationContainer.html(response.data.pagination);

                    // Update URL (Optional but good for UX)
                    // const newUrl = window.location.pathname + '?' + formData;
                    // window.history.pushState({path: newUrl}, '', newUrl);

                } else {
                    toursContainer.html('<div class="col-span-full text-center py-10 text-gray-500">خطایی رخ داد.</div>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tours:', error);
            },
            complete: function () {
                // Hide loader
                toursContainer.removeClass('opacity-40 pointer-events-none');
                loader.addClass('hidden');

                // Scroll to top on mobile
                if ($(window).width() < 1024) {
                    $('html, body').animate({
                        scrollTop: toursContainer.offset().top - 150
                    }, 500);
                }
            }
        });
    }

    // Trigger on change
    // Using debounce for text inputs to prevent too many requests
    let debounceTimer;
    filterForm.on('change input', 'input, select', function (e) {
        // If it's a text input (like price), wait a bit
        if (e.target.type === 'text' || e.target.type === 'number') {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchTours(1);
            }, 500);
        } else {
            // Checkbox/Select trigger immediately
            fetchTours(1);
        }
    });

    // Reset Filters
    $('#reset-filters').on('click', function (e) {
        e.preventDefault();
        filterForm[0].reset();
        // Clear custom inputs like Select2 if used, or custom styled checkboxes
        fetchTours(1);
    });

    // Pagination
    $(document).on('click', '.ajax-pagination-btn', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchTours(page);
    });

});