
$(document).ready(function() {
    $('#syncButton').click(function(e) {
        e.preventDefault();

        $('.ui.loader').addClass('active');

        $.ajax({
            url: 'sync_products.php',
            method: 'POST',
            data: {
                url: 'https://aliexpress.ru/item/1005007662056562.html'
            },
            
            success: function(response) {
                console.log(response);
                $('#tableID').load(location.href + " #tableID"); 
                $('#paginationBox').load(location.href + " #paginationBox"); 

                $('.category_update').load(location.href + " .category_update", function() {
                    $('#category').dropdown();
                });

                $('.tag_update').load(location.href + " .tag_update", function() {
                    $('#tag').dropdown();
                });
                
            },
            error: function() {
                alert('Có lỗi xảy ra khi đồng bộ sản phẩm.');
            },
            complete: function() {
                $('.ui.loader').removeClass('active');
            }
        });
    });
    

});
