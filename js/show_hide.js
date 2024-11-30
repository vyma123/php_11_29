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
        $('#uploadedImage').attr('src', '').hide(); 
        return; 
    }

    const fileType = file.type;
    if (acceptedFormats.includes(fileType)) {
        const reader = new FileReader(); 
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result).show(); 
        };
        reader.readAsDataURL(file); 
    } else {
        alert("Invalid image format. Please upload a valid image file.");
        fileInput.value = ""; 
        $('#uploadedImage').attr('src', '').hide(); 
    }
});



$('#gallery').on('change', function () {
    const fileInput = this;
    const files = fileInput.files;

    if (!files.length) {
        console.log("No files selected.");
        $('#galleryImage').attr('src', '').hide(); 
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

    const galleryImage = $('#galleryPreviewContainer img'); 

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (acceptedFormats.includes(file.type)) {
            const reader = new FileReader();
            reader.onload = function (e) {
                galleryImage.attr('src', e.target.result).show(); 
            };
            reader.readAsDataURL(file);
        } else {
            alert("Invalid image format. Please upload valid image files.");
            fileInput.value = ""; 
            galleryImage.attr('src', '').hide(); 
            break;
        }
    }
});



$(document).ready(function() {    
    if ($('#productTableBody tr').children().length === 0) {
        console.log('ffs');
        $('.box_delete_buttons').hide();
    }
});


