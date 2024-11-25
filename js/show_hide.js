$('#category').dropdown();
$('#tag').dropdown();
    

$('#add_product').click(function() {

    $('#editProductButton').css({
        'display': 'none',  
      
    });
    $('#addProductButton').css({
        'display': 'block',  
      
    });
    });

    $(function(){
        $("#add_product").click(function(){
            $(".product_box").modal('show');
            
            $('#saveProduct')[0].reset(); 
    
    
            $('#errMessage_add').addClass('d-none');
            $('#err_valid_Message_product').addClass('d-none');
            $('#okMessage_product').addClass('d-none');
            $('#err_valid_Message_price').addClass('d-none');
    
            $('#uploadedImage').hide();
            $('#galleryPreviewContainer').hide();
            $('#required').addClass('d-none');
            $('#checkstring').addClass('d-none');
            $('#checksku').addClass('d-none');
            $('#checknumber').addClass('d-none');
            $('.product_added').removeClass('flex');
    
            $('#featured_image').val('');
            $('#gallery').val('');
        });
    
        $(".product_box").modal({
            closable: true
        });
    });
    



