$('#category').dropdown();
$('#tag').dropdown();
$('#categories_select').dropdown();
$('#tags_select').dropdown();

$(function(){
	$("#close_product").click(function(){
		$(".product_box").modal('hide');
        $('#okMessageProduct').removeClass('flexSPr');   
        $('#noChanges').removeClass('flexWP');  
        $('#required_featured').addClass('d-none');
        $('#required_gallery').addClass('d-none');
        $('#limit_gallery').addClass('d-none');

	});
	$(".product_box").modal({
		closable: true
	});
});  

$(document).ready(function() {
    $(".modals").click(function(event) {
        if ($(event.target).is(".modals")) {
             $('#errMessage').removeClass('flexWP'); 
             $('#okMessage').removeClass('flexSP');    
             $('#okMessageProduct').removeClass('flexSPr');     
             $('#noChanges').removeClass('flexWP');  
             $('#required_featured').addClass('d-none');
             $('#required_gallery').addClass('d-none');
             $('#limit_gallery').addClass('d-none');

        }
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
        $('#required_featured').addClass('d-none');

        const reader = new FileReader(); 
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result).show(); 
        };
        reader.readAsDataURL(file); 

        $('#fileName').val(file.name);
        $('.close_image').attr('style', 'display: flex !important');
        $('.ui.small.image.box_input.box_featured').attr('style', 'display: none !important');

    } else {
        $('#required_featured').removeClass('d-none');
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

    if (files.length > 15) {
        $('#limit_gallery').removeClass('d-none');
        fileInput.value = ""; 
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
       $('#required_gallery').addClass('d-none');
       $('#limit_gallery').addClass('d-none');

       console.log('sfsdf');
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
            
            $('#required_gallery').removeClass('d-none');
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
        $('.box_delete_buttons').hide();
    }
});


