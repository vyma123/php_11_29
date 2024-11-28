

$(document).on('click', '.delete_button', function(e) {
    e.preventDefault();

    var productId = $(this).data('id');
    var productRow = $(this).closest('tr');
    var productIds = [];
    var currentPage = $('#currentPages').val();
    
    if (isNaN(currentPage)) {
        currentPage = 1;
    }

    $('#tableID tr').each(function() {
        var id = $(this).find('.delete_button').data('id');
        if (id) { productIds.push(id); }
    });

    console.log(productIds);
    

    var filters = {
        category: $('#category').val() || '',
        tag: $('#tag').val() || '',
        search: $('#search').val() || '',
        sort_by: $('#sort_by').val() || '',
        order: $('#order').val() || '',
        date_from: $('#date_from').val() || '',
        date_to: $('#date_to').val() || '',
        price_from: $('#price_from').val() || '',
        price_to: $('#price_to').val() || '',
        gallery: $('#gallery').val() || ''
    };

    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: 'delete_product.php',
            method: 'POST',
            data: { id: productId },
            success: function(response) {
                if (response === 'success') {
                    productRow.fadeOut(function() {
                        $(this).remove();
                        
                        if (productIds.length <= 1) {
                            currentPage = Math.max(currentPage - 1, 1);  
                        } 

                            updateTableAndPagination(currentPage, filters);
                        
                        
                    });
                } else {
                    alert('Error deleting the product');
                }
            },
            error: function() {
                alert('An error occurred');
            }
        });
    }


    function updateTableAndPagination(page, filters) {
        
        const queryParams = $.param({
            page: page,
            category: filters.category,
            tag: filters.tag,
            search: filters.search,
            sort_by: filters.sort_by,
            order: filters.order,
            date_from: filters.date_from,
            date_to: filters.date_to,
            price_from: filters.price_from,
            price_to: filters.price_to,
            gallery: filters.gallery
        });
    
        const query = `index.php?${queryParams}`;
        $('#mytable').load(`${query} #mytable`);
        $('#currentPages').val(page); 
    
    }

    
});



$('#mytable').load(location.href + " #mytable", function() {
    
    $('#mytable').on('click', '.delete_buttons', function(event) {
        
        event.preventDefault();
        
        if (confirm('Delete all products!')) {
            $.ajax({
                url: 'delete.php', 
                type: 'POST',
                success: function(response) {
                    $('#tableID tbody').empty(); 
                    $('#paginationBox').empty();
                },
                
                error: function(xhr, status, error) {
                    alert('Đã xảy ra lỗi: ' + error);
                }
            });
        }
    });
});