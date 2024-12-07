const toast = document.getElementById("errMessage");


const removeToast = (toast, className) => {
    toast.classList.remove(className);
    toast.classList.add("remove");
};
let toastTimeout = null; 

$(function(){
	$("#add_property").click(function(){
		$(".category_box").modal('show');
       $('#errMessage').removeClass('flexWP'); 
       $('#okMessage').removeClass('flexSP');     
       $('#input_cate').val('');
       $('#input_tag').val('');
       $('#checkstringP').addClass('d-none');     
       $('#checkstring2').addClass('d-none');     
       $('#checkstringcomma').addClass('d-none');
       $('#checkstringcomma2').addClass('d-none');
	});
	

    $("#close_property").click(function(){
		$(".category_box").modal('hide');
            $('#errMessage').removeClass('flexWP');  
            $('#okMessage').removeClass('flexSP');     
	});
	$(".category_box").modal({
        closable: true
	});
});  

    
function validateFormProperty(event) {
    
    const input_cate = document.getElementById("input_cate").value;
    const input_tag = document.getElementById("input_tag").value;

    const regex = /^[\p{L}0-9-_, ]*$/u;

    $('#errMessage')
    .removeClass('flexWP');
           $('#okMessage').removeClass('flexSP');   


    let hasError = false;

    if (input_cate.trim() === "" && input_tag.trim() === "") {
        
    setTimeout(() => {
        $('#errMessage').addClass('flexWP'); 
        $('#okMessage').removeClass('flexSP');   
    }, 200);

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
        $('#checkstringP').removeClass('d-none');             
 
         console.log("Don't allow special characters cate");
         hasError = true;
    }else{
        $('#checkstringP').addClass('d-none');             
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
        console.log('111');
    setTimeout(() => {
        $('#okMessage').addClass('flexSP');   
        $('#checkstringcomma').addClass('d-none');
        $('#checkstringcomma2').addClass('d-none');
    }, 200);
    
        return true;
    }else{

        return false;
    }
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

    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
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
                $('#tag').html(res.tagsHTML);
            }
		}
	})
})


