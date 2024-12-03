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
    const fileInput = this;
    const file = fileInput.files[0];

    const acceptedFormats = [
        "image/png", 
        "image/jpg", 
        "image/jpeg", 
        "image/gif", 
        "image/webp", 
        "image/bmp", 
        "image/svg+xml", 
        "image/tiff", 
        "image/ico"
    ];



    if (!file) {
        console.log("File selection was canceled.");
        return; 
    }

    const fileType = file.type;
    if (acceptedFormats.includes(fileType)) {
        const reader = new FileReader(); 
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result).show(); 
        };
        reader.readAsDataURL(file); 

        $('#fileName').val(file.name);
        $('.close_image').attr('style', 'display: flex !important');
        $('.ui.small.image.box_input.box_featured').attr('style', 'display: none !important');
        
        console.log('mnb');
        
    } else {
        alert("Invalid image format. Please upload a valid image file.");
        fileInput.value = ""; 
    }
});

$('.close_image').on('click', function() {
    $('#uploadedImage').attr('src', '').hide(); 
    $('#featured_image').val(''); 
    $('.close_image').hide();  
    $('.ui.small.image.box_input.box_featured').attr('style', 'display: block !important');

});



$('#gallery').on('change', function () {
    const fileInput = this;
    const files = fileInput.files;

    if (!files.length) {
        console.log("No files selected.");
        $('#galleryPreviewContainer').empty();  
        return;
    }

    const acceptedFormats = [
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/gif",
        "image/webp",
        "image/bmp",
        "image/svg+xml",
        "image/tiff",
        "image/ico",
    ];

    const galleryPreviewContainer = $('#galleryPreviewContainer');
    galleryPreviewContainer.empty(); 

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (acceptedFormats.includes(file.type)) {
       $('#galleryPreviewContainer').attr('style', 'display: block !important');

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = $('<img>', { src: e.target.result, alt: 'Gallery Image' }).css({
                    'width': '200px',  
                    'object-fit': 'contain',  
                    'height': '90px',       
                });

                $('.close_gallery').attr('style', 'display: flex !important');
                $('.ui.small.image.box_input.box_gallery').attr('style', 'display: none !important');
                galleryPreviewContainer.append(img);
            };
            reader.readAsDataURL(file); 
        } else {
            alert("Invalid image format. Please upload valid image files.");
            fileInput.value = ""; 
            galleryPreviewContainer.empty(); 
            break;
        }
    }
});





$('.close_gallery').on('click', function() {
    $('#galleryPreviewContainer img').attr('src', '').hide(); 
    $('#gallery').val(''); 
    $('.close_gallery').hide();  
    $('.ui.small.image.box_input.box_gallery').attr('style', 'display: block !important');

});


$(document).ready(function() {    
    if ($('#productTableBody tr').children().length === 0) {
        console.log('ffs');
        $('.box_delete_buttons').hide();
    }
});


