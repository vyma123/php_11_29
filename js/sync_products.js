
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
                $('#mytable').load(location.href + " #mytable"); 
            },
            error: function() {
                alert('err');
            },
            complete: function() {
                $('.ui.loader').removeClass('active');
            }
        });
    });
});


