const confirm_yes = $('.confirm-yes');
const confirm_no = $('.confirm-no'); 




$(document).off('click', 'edit_button').on('click', '.delete_button', function(e) {
    e.preventDefault();


    $('.confirmation-dialog').removeClass('show'); 
    $('.overlay').addClass('show'); 

    $('.one_delete').removeClass('d-none');
    $('.all_delete').addClass('d-none');

    function confirmDelete() {
        
        $('.confirmation-dialog').addClass('show');
        return new Promise(function(resolve, reject) {
            $(confirm_yes).on('click', function() {
                $('.confirmation-dialog').removeClass('show');
                $('.overlay').removeClass('show');
    
                resolve(true); 
            });
    
            $(confirm_no).on('click', function() {
                $('.confirmation-dialog').removeClass('show');
                $('.overlay').removeClass('show'); 
    
                resolve(false); 
            });

          
        });
    }


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

    confirmDelete().then(function(result) {
    if (result) {
        $.ajax({
            url: 'delete_product.php',
            method: 'POST',
            data: { id: productId },
            success: function(response) {
                var responseData = JSON.parse(response);

                if (responseData.status === 'success') {
                    productRow.fadeOut(function() {
                        $(this).remove();
                        
                        if (productIds.length <= 1) {
                            currentPage = Math.max(currentPage - 1, 1);  
                        } 

                            updateTableAndPagination(currentPage, filters);
                        
                        
                    });
                  console.log(responseData.count);
                  if(responseData.count === 1){
                    console.log('ok');
                    
                  }
                } else {
                    alert('Error deleting the product');
                }

            },
            error: function() {
                alert('An error occurred');
            }
        });
    }

});

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
    
    $('#mytable').off('click', '.delete_buttons').on('click', '.delete_buttons', function(event) {
        event.preventDefault();
        $('.confirmation-dialog').addClass('show');
        $('.overlay').addClass('show');

        $('.one_delete').addClass('d-none');
        $('.all_delete').removeClass('d-none');
        
    function confirmDeleteAll() {
        return new Promise(function(resolve, reject) {
            $(confirm_yes).on('click', function() {
                $('.confirmation-dialog').removeClass('show');
                $('.overlay').removeClass('show');
                resolve(true);  
            });

            $(confirm_no).on('click', function() {
                $('.confirmation-dialog').removeClass('show');
                $('.overlay').removeClass('show');

                resolve(false); 
            });
        });
    }

  

    confirmDeleteAll().then(function(result) {
        if (result) {
            $.ajax({
                url: 'delete.php', 
                type: 'POST',
                success: function(response) {
                var responseData = JSON.parse(response);
                console.log(responseData.count);
                
                if(responseData.count === 0){
                    console.log('ge');

                    $('#tableID').on('mouseenter', function() {
                        $(this).find('.box_delete_buttons').addClass('hide').removeClass('box_delete_buttons');
    
                    }).on('mouseleave', function() {
                        $(this).find('.hide').addClass('box_delete_buttons').removeClass('hide');
                    });
                }
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
});