
$(document).ready(function() {
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
               loadPage(page);
          });
            $('#applyFilters').click(function() {
                loadPage(1); 
            });

    function loadPage(page) {
        var search = $('#search').val();
        var sort_by = $('#sort_by').val();
        var order = $('#order').val();
        var category = $('#category').val();
        var tag = $('#tag').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var price_from = $('#price_from').val();
        var price_to = $('#price_to').val();

            $.ajax({
                    url: 'get_products.php',
                    method: 'GET',
                     data: {
                        page: page,
                        search: search,
                        sort_by: sort_by,
                        order: order,
                        category: category,
                        tag: tag,
                        date_from: date_from,
                        date_to: date_to,
                        price_from: price_from,
                        price_to: price_to
            },
                    success: function(response) {
                        var data = JSON.parse(response); 
                        $('#tableID').html(data.content);
                        $('#paginationBox').html(data.pagination);
                        $('#inputpage').html(data.inputpage);
                    },
                    error: function() {
                        alert("Có lỗi xảy ra trong quá trình tải dữ liệu.");
                    }
                });
            }
});
