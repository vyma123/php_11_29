

let isProductNameUnchanged = false; 
let oldProductName;
let oldSku;
let oldPrice;
let oldGallery;
let oldCategory;
let oldTag;
let imageUrl;
let imagePaths = [];
let selectedCategoryNames = [];
let selectedTagNames = [];

    

        $(document).on('click', '.edit_button', function(e) {
            e.preventDefault();        
        
            imagePaths = [];
            selectedCategoryNames = [];
            selectedTagNames = [];

            var product_id = $(this).val();
            
            $('.ui.button[type="submit"]:contains("Add")').addClass('d-none'); 
            $('.ui.button[type="submit"]:contains("Update")').removeClass('d-none'); 
            $('#noChanges').removeClass('flexWP');    
            
        
            $.ajax({
                type: "GET",
                url: "handler_product.php?product_id=" + product_id,
                dataType: "json", 
                success: function(res) {
                    $('.ui.modal.product_box').modal('show');
        
                    if(res.status == 422){
                        alert(res.message);
        
                        
                    } else if(res.status == 200){				
        

                        $('#product_id').val(res.data.id);
                        $('#product_name').val(res.data.product_name);
                        $('#sku').val(res.data.sku);
                        $('#price').val(res.data.price);
        
                        $('#uploadedImage').show();
                        $('#okMessage_product').hide();
                        $('#galleryPreviewContainer').show();
                        
                        imageUrl = res.data.featured_image;
                        
                        if (imageUrl.startsWith('http://') || imageUrl.startsWith('https://')) {
                            $('#uploadedImage').attr('src', imageUrl);
                        } else if(imageUrl) {
                            $('#uploadedImage').attr('src', './uploads/' + imageUrl);
                        }else{
                            $('#uploadedImage').hide();
                        }
                    
                        $('#galleryPreviewContainer').empty();
        
                        $.each(res.gallery, function(index, image) {
                            var imagePath = './uploads/' + image.name_; 
                            var imageName = imagePath.replace('./uploads/', '');
                            if (!imagePaths.includes(imagePath)) {
                                imagePaths.push(imageName);
                            }
                        
                            var imgElement = $('<img>')
                                .attr('src', imagePath)
                                .attr('alt', 'Gallery Image');  
                        
                            $('#galleryPreviewContainer').append(imgElement);
                        });
                        
                        $('#categories_select').empty();
        

                        $.each(res.categories, function(index, category) {
                            var option = $('<option></option>')
                                .attr('value', category.id)  
                                .text(category.name_);  
                        
                            $('#categories_select').append(option);
                            
                                $.each(res.categoriesse, function(i, selectedCategory) {
                                    if (selectedCategory.name_ === category.name_) {
                                        $('#categories_select option[value="' + category.id + '"]').prop('selected', true);
                                        selectedCategoryNames.push(selectedCategory.name_); 
                                    }
                                });
                                
                                
                            });
                        
                        $('#tags_select').empty();
                        
        
                        $.each(res.tags, function(index, tag) {
                            var option = $('<option></option>')
                                .attr('value', tag.id)  
                                .text(tag.name_);  
                        
                            $('#tags_select').append(option);
                        
                            $.each(res.tagsse, function(i, selectedTag) {
                                if (selectedTag.name_ === tag.name_) {
                                    $('#tags_select option[value="' + tag.id + '"]').prop('selected', true);
                                    selectedTagNames.push(selectedTag.name_); 

                                }
                            });
                        });
                        
            oldProductName = $('#product_name').val().trim(); 
            oldSku = $('#sku').val().trim(); 
            oldPrice = $('#price').val().trim(); 
            oldFeatured_image = imageUrl;
            oldCategory = selectedCategoryNames;
            oldTag = selectedTagNames;

            const imageNames = imagePaths.map(function(imagePath) {
                return imagePath.replace('./uploads/', ''); 
            }); 
            
            oldGallery = imageNames;
            }
        }
    });

            $('#editProductButton').off('click').on('click', function(event) {            
                
                const currentProductName = $('#product_name').val().trim(); 
                const currentSku = $('#sku').val().trim(); 
                const currentPrice = $('#price').val().trim(); 
                const currentFeatured_image = $('#uploadedImage').attr('src').replace('./uploads/', '');
                const currentGallery = $('#galleryPreviewContainer img').map(function() {
                    return $(this).attr('src').replace('./uploads/', ''); 
                }).get();
                const currentCategory = $('#categories_select option:selected').map(function() {
                    return $(this).text(); 
                }).get();
                const currentTag = $('#tags_select option:selected').map(function() {
                    return $(this).text(); 
                }).get();
                
            
                    if (oldProductName === currentProductName
                    && oldSku === currentSku
                    && oldPrice === currentPrice
                    && oldFeatured_image === currentFeatured_image
                    && JSON.stringify(oldGallery) === JSON.stringify(currentGallery)      
                    && JSON.stringify(oldCategory) === JSON.stringify(currentCategory)    
                    && JSON.stringify(oldTag) === JSON.stringify(currentTag)                    


                    ) {
                        $('#required').addClass('d-none'); 
                        $('#checkstring').addClass('d-none'); 
                        $('.message').addClass('flex'); 
                        $('#noChanges').addClass('flexWP');     
                        $('#checksku').addClass('d-none');  
                        $('#checknumber').addClass('d-none');      


                        console.log("No changes detected."); 
                        isProductNameUnchanged = true; 

                        return false;
                    } else{
                        isProductNameUnchanged = false; 

                        return true;
                    }


            });

        });
    
    $(document).on('click', '.edit_button', function() {
        $('#addProductButton').css({
            'display': 'none'
        });
    
        $('#editProductButton').css({
            'display': 'block'
        });
    
        var productId = $(this).val(); 
        $('#action_type').val('edit_product'); 
        $('#product_id').val(productId); 
        $('.ui.modal.product_box').modal('show'); 
    
        $('#required').addClass('d-none');
        $('#checksku').addClass('d-none');
        $('#checknumber').addClass('d-none');
        $('#checkstring').addClass('d-none');
        $(".message").removeClass('flex');
        $("#okMessageProduct").removeClass('flexSPr');
        $('#okMessageProduct2').removeClass('flexSPr'); 

    });
    
                                 
   