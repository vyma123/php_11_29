$('#category').dropdown();
$('#tag').dropdown();
$('#categories_select').dropdown();
$('#tags_select').dropdown();


$(function(){
	$("#close_product").click(function(){
		$(".product_box").modal('hide');
	});
	$(".product_box").modal({
		closable: true
	});
});  

    
$('#featured_image').on('change', function() {
	if (this.files && this.files[0]) {
		var reader = new FileReader(); 
		reader.onload = function(e) {
			$('#uploadedImage').attr('src', e.target.result).show(); 
		};
		reader.readAsDataURL(this.files[0]); 
	}
});

$('#gallery').on('change', function() {
    $('#galleryPreviewContainer').empty();
    
    if (this.files) {
        for (let i = 0; i < this.files.length; i++) {
            let file = this.files[i];
            let reader = new FileReader();
            
            reader.onload = function(e) {
                const img = $('<img>', {
                    src: e.target.result,
                    alt: 'Gallery Image',
                });
                $('#galleryPreviewContainer').append(img);
                $('#galleryPreviewContainer').show();
            };
            reader.readAsDataURL(file); 
        }
    }
});



$(document).ready(function() {
    console.log('ffshs');
    
    if ($('#productTableBody tr').children().length === 0) {
        console.log('ffs');
        $('.box_delete_buttons').hide();
    }
});


