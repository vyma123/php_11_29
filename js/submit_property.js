
$(function(){
	$("#add_property").click(function(){
		$(".category_box").modal('show');
       $('#errMessage').removeClass('flexWP'); 
       $('#okMessage').removeClass('flexSP');     
       $('#input_cate').val('');
       $('#input_tag').val('');
       $('#checkstring').addClass('d-none');     
       $('#checkstring2').addClass('d-none');     
       $('#checkstringcomma').addClass('d-none');

       $('#checkstringcomma2').addClass('d-none');


	});
	$(".category_box").modal({
		closable: true
	});
});  

$(function(){
	$("#close_property").click(function(){
		$(".category_box").modal('hide');
	});
	$(".category_box").modal({
		closable: true
	});
}); 
    
function validateFormProperty(event) {
    const input_cate = document.getElementById("input_cate").value;
    const input_tag = document.getElementById("input_tag").value;


    const regex = /^[\p{L}0-9-_, ]*$/u;

    let hasError = false;

    if (input_cate.trim() === "" && input_tag.trim() === "") {
       console.log('sdd');
       $('#errMessage').addClass('flexWP');     
        hasError = true;
    } else{
        $('#errMessage').removeClass('flexWP');   
    }

    if (/^[, ]+$/.test(input_cate.trim())) {
        $('#checkstringcomma').removeClass('d-none');
        hasError = true;
    } else{
        $('#checkstringcomma').addClass('d-none');

    }

    if (/^[, ]+$/.test(input_tag.trim())) {
        $('#checkstringcomma2').removeClass('d-none');
        hasError = true;
    } else{
        $('#checkstringcomma2').addClass('d-none');

    }
    


    if (!regex.test(input_cate)) {
       $('#okMessage').removeClass('flexSP');     
       $('#errMessage').removeClass('flexWP');     
        $('#checkstring').removeClass('d-none');             
 
         console.log("Don't allow special characters cate");
         hasError = true;
    }else{
        $('#checkstring').addClass('d-none');             

    }

    if(!regex.test(input_tag)){
       $('#okMessage').removeClass('flexSP');     
        $('#errMessage').removeClass('flexWP');     
        $('#checkstring2').removeClass('d-none');             
         console.log("Don't allow special characters tag");
         hasError = true;
    }else{
        $('#checkstring2').addClass('d-none');  
    }

    if (!hasError) {
        console.log('ok');
        $('#okMessage').addClass('flexSP');   
        $('#checkstringcomma').addClass('d-none');
        $('#checkstringcomma2').addClass('d-none');

        return true;
    }else{

        return false;
    }

}


css_property_select();

function css_property_select(){
$(document).ready(function() {
    $('#categories_select').select2({
        placeholder: "Select categories",
        closeOnSelect: false, 
        allowClear: true
    });
});
$(document).ready(function() {
    $('#tags_select').select2({
        placeholder: "Select tags",
        closeOnSelect: false,
        allowClear: true
    });
});

$('#categories_select').on('change', function() {
    const selectedOptions = $(this).val();
    const selectionContainer = $('.select2-container--default .select2-selection--multiple');

    if (selectedOptions && selectedOptions.length > 0) {
        selectionContainer.addClass('scrolling'); 
    } else {
        selectionContainer.removeClass('scrolling');
    }
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('.select2-container').length) {
        $('#categories_select').select2('close'); 
    }
});

$('#categories_select').on('change', function() {
    const selectedOptions = $(this).val();
    const selectionContainer = $('.select2-container--default .select2-selection--multiple');

    if (selectedOptions && selectedOptions.length > 0) {
        selectionContainer.addClass('scrolling'); 
    } else {
        selectionContainer.removeClass('scrolling');
    }
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('.select2-container').length) {
        $('#categories_select').select2('close'); 
    }
});

$('#tags_select').on('change', function() {
    const selectedOptions = $(this).val();
    const selectionContainer = $('.select2-container--default .select2-selection--multiple');

    if (selectedOptions && selectedOptions.length > 0) {
        selectionContainer.addClass('scrolling'); 
    } else {
        selectionContainer.removeClass('scrolling');
    }
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('.select2-container').length) {
        $('#tags_select').select2('close'); 
    }
});
}




$(document).on('submit', '#saveProperty', function(e){
	e.preventDefault();

    let hasError = false;

if (!validateFormProperty()) {
    hasError = true;
}


if (hasError) {
    return;
}
	var formData = new FormData(this);
	formData.append("save_property", true);

	$.ajax({
		type:"POST",
		url: "handler_property.php",
		data: formData,
		processData:false,
		contentType:false,
		success: function(response) {
            var res = jQuery.parseJSON(response);

                if (res.status == 200) {
                $('#saveProperty')[0].reset();
                $('#category').html(res.categoriesHTML);


            }
		}
	})
})


