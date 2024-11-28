 
document.getElementById('add_product').addEventListener('click', function() {
    $('.ui.modal.product_box').modal('show');

     
    $('#categories_select').dropdown('clear');
    $('#tags_select').dropdown('clear');   

    fetch('handler_product.php')
        .then(response => response.json())
        .then(data => {
            const categoriesSelect = document.getElementById('categories_select');
            const tagsSelect = document.getElementById('tags_select');

            categoriesSelect.innerHTML = '';
            tagsSelect.innerHTML = '';

            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name_;
                categoriesSelect.appendChild(option);
            });

            data.tags.forEach(tag => {
                const option = document.createElement('option');
                option.value = tag.id;
                option.textContent = tag.name_;
                tagsSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching categories and tags:', error));
});

function validateForm(event) {
    const productName = document.getElementById("product_name").value;
    const sku = document.getElementById("sku").value;
    const priceInput = document.getElementById("price").value;
    const regex = /^[\p{L}0-9-_– ]+$/u;
    const regexsku = /^[\p{L}0-9-]+$/u;
    const regexprice = /^[0-9.]+$/;

    let hasError = false;

    if (productName.trim() === "") {
        $('#noChanges').removeClass('flexWP');     
        $('#required').removeClass('d-none'); 
        $('#checkstring').addClass('d-none');             
        hasError = true;
    } else if (!regex.test(productName)) {
        $('#required').addClass('d-none');    
        $('#checkstring').removeClass('d-none'); 
        $('#noChanges').removeClass('flexWP');     

             
        hasError = true;
    } else {
        $('#required').addClass('d-none');   
        $('#checkstring').addClass('d-none');
    }


if (sku.trim() !== "" && !regexsku.test(sku)) {
    $('#checksku').removeClass('d-none');  
    $('#noChanges').addClass('d-none');  
    $('#noChanges').removeClass('flexWP');      
    hasError = true;
} else {
    $('#checksku').addClass('d-none');      
}

if (priceInput.trim() !== "" && !regexprice.test(priceInput)) {
    $('#checknumber').removeClass('d-none');  
    $('#noChanges').removeClass('flexWP');  

    hasError = true;
} else {
    $('#checknumber').addClass('d-none');  
}

    if (hasError) {
        return false;
    }

 
    return true;
}

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
            $('#okMessageProduct').removeClass('flexSPr');  
            $('#okMessageProduct2').removeClass('flexSPr');  
            $('#noChanges').removeClass('flexWP');  

            $('#featured_image').val('');
            $('#gallery').val('');
        });
    
        $(".product_box").modal({
            closable: true
        });
    });
    

function isValidNumberWithDotInput(input) {
    const regex = /^[0-9.]+$/;
    return regex.test(input);
}

$(document).on('click', '#addProductButton', function() {
    $('#action_type').val('add_product');  
});

$(document).on('click', '#editProductButton', function() {
    $('#action_type').val('edit_product');  
});




$(document).off('submit', '#saveProduct').on('submit', '#saveProduct', function(e){
	e.preventDefault();

    if (isProductNameUnchanged) {
        return;
    }

    let hasError = false;

    if (!validateForm()) {
        hasError = true;
    }

    if (hasError) {
        return;
    }


	var formData = new FormData(this);

	if ($('#featured_image')[0].files.length > 0) {
        var file = $('#featured_image')[0].files[0]; 
        formData.append('featured_image', file); 
    }

    formData.append("action_type", $('#action_type').val());

	if ($('#action_type').val() === 'edit_product') {
		var productId = $(this).data('product-id'); 
    }

	var categories = [];
    var tags = [];

    $("select[name='categories[]']").each(function() {
      categories.push($(this).val());
    });

    $("select[name='tags[]']").each(function() {
      tags.push($(this).val());
    });


    formData.append('categories', JSON.stringify(categories));
    formData.append('tags', JSON.stringify(tags));

	$.ajax({
		type: "POST",
		url: "handler_product.php",
		data: formData,
		dataType: "",
		processData:false,
		contentType:false,
		success: function(response) {
            
            var res = jQuery.parseJSON(response);
		

            if (res.status == 200) {
				if(res.action == 'add'){
                   
                    $('#categories_select').dropdown('clear');
                    $('#tags_select').dropdown('clear');    
                    $('#okMessageProduct').removeClass('d-none');  
                    $('#okMessageProduct').addClass('flexSPr'); 
					$('#okMessage_product').removeClass('d-none').fadeIn(400); 
					$('#uploadedImage').attr('src', '').hide();
					$('#featured_image').val(''); 
					$('#galleryPreviewContainer').empty();
					$('#saveProduct')[0].reset();

					setTimeout(function() {
						$('#okMessage_product').fadeOut(400, function() {
							$(this).addClass('d-none');
						});
					}, 2000);
                    
                    $('#mytable').load(location.href + " #mytable"); 
                    
				}else if(res.action == 'edit'){


                    $('#okMessageProduct2').removeClass('d-none');  
                    $('#okMessageProduct2').addClass('flexSPr'); 

                    setTimeout(function() {
                        $('#okMessageProduct2').addClass('d-none').removeClass('flexSPr');
                    }, 2000);
                  
                    
		            $(".product_box").modal('hide');
                    $(".product_box").modal({
                        closable: true
                    });

					$('#featured_image').val(''); 
					$('#okMessage_product_update').removeClass('d-none').fadeIn(400); 
					$('#gallery').val('');

					setTimeout(function() {
						$('#okMessage_product_update').fadeOut(400, function() {
							$(this).addClass('d-none');
						});
					}, 2000);
                 
                var productId = res.product_id; 
                var updatedProductName = res.product_name; 
                var updatedSku = res.sku; 
                var updatedPrice = res.price; 
                var featuredImage = res.featured_image.name;
                var category = res.category;
                var tag = res.tag;
                var gallery = res.gallery;

       $('#tableID').find('.edit_button').each(function() {

        var currentPage = $('#currentPages').val();
    
        if(currentPage === undefined){

        var currentPage = $('#currentPage').val();
        }

        var button = $(this);
        var productIDInRow = button.val(); 
        
        if (productIDInRow == productId) {

            button.closest('tr').find('.product_name').text(updatedProductName);
            button.closest('tr').find('.sku').text(updatedSku);
            button.closest('tr').find('.price').text(parseFloat(updatedPrice));

            if(featuredImage && featuredImage !== ''){
                button.closest('tr').find('.featured_image img').attr('src', './uploads/' + featuredImage);
            }

            if(gallery && Array.isArray(gallery.name) && gallery.name != ''){
                
                
                if (gallery && Array.isArray(gallery.name)) {

                    var galleryContainer = button.closest('tr').find('.gallery .gallery-container');
                    galleryContainer.empty();  
                    
                    gallery.name.forEach(function(image) {
                        
                        var img = galleryContainer.find('img[src="./uploads/' + image + '"]');
                        
                        if (img.length > 0) {
                            
                            img.attr('src', './uploads/' + image);
                            
                        } else {
                            
                        galleryContainer.append('<img src="./uploads/' + image + '" alt="Gallery Image">');  

                         var productIds = [];

                        $('#tableID tr').each(function() {
                            var id = $(this).find('.edit_button').data('id');
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
                        
                        updateTableAndPagination(currentPage, filters);

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
                            $('#tableID').load(`${query} #tableID`);
                            $('#paginationBox').load(`${query} #paginationBox`);
                        }
                    }
                });
            }
            }

        if (category && category.length > 0) {
        var categoryNames = category.map(function(cat) {
            return cat.name_;  
        }).join(', ');  

        
        button.closest('tr').find('.category').text(categoryNames);
        } else {
            button.closest('tr').find('.category').text('');
        }

        if (tag && tag.length > 0) {
        var tagNames = tag.map(function(cat) {
            return cat.name_; 
        }).join(', ');  

        
        button.closest('tr').find('.tag').text(tagNames);
        } else {
            button.closest('tr').find('.tag').text('');
        }
        }
    });

    setTimeout(function() {
        $('#okMessage_product_update').fadeOut(400, function() {
            $(this).addClass('d-none');
        });
    }, 2000);
		}
            }
		},
        error: function(xhr, status, error) {
            console.error("An error occurred:", error);
        }
	});
})