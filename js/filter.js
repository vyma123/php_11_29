let debounceTimeout;

function validatePrice(event) {
    

    const priceInput1 = document.getElementById("price_from").value;
    const priceInput2 = document.getElementById("price_to").value;
    const regexprice = /^[0-9.]+$/;
    let hasError = false;

if (priceInput1.trim() !== "" && !regexprice.test(priceInput1)) {
    $('#price_from').addClass('err_border');  

    console.log("price numbers, and hyphens (no spaces)");
    hasError = true;
} else {
    $('#price_from').removeClass('err_border');  
}

if (priceInput2.trim() !== "" && !regexprice.test(priceInput2) || priceInput2.trim() !== "" && priceInput2.trim() <= 0) {
    $('#price_to').addClass('err_border');  

    hasError = true;
} else {
    $('#price_to').removeClass('err_border');  
}

    if (hasError) {
        return false;
    }
 
    return true;
}


function handleFilterClick(event) {
    console.log('bkdf');
    
    if (validatePrice(event)) {
        applyFilters(event); 
    } else {
        event.preventDefault(); 
    }
}


function loadApplyFilters(event) {

    
	clearTimeout(debounceTimeout);

	debounceTimeout = setTimeout(() => {
		applyFilters(event);
	}, 400);
}

function applyFilters(event) {

    event.preventDefault();

    const category = $('#category').val();  
    const tag = $('#tag').val();

    const search = document.getElementById("search").value;
    const sortBy = document.getElementById("sort_by").value;
    const order = document.getElementById("order").value;
    const dateFrom = document.getElementById("date_from").value;
    const dateTo = document.getElementById("date_to").value;
    const priceFrom = document.getElementById("price_from").value;
    const priceTo = document.getElementById("price_to").value;
    const gallery = document.getElementById("gallery").value;

    const data = {
        search: search || '', 
        sort_by: sortBy,
        order: order,
        date_from: dateFrom,
        date_to: dateTo,
        price_from: priceFrom,
        price_to: priceTo,
        gallery: gallery,
		category: category || [],  
        tag: tag || [] 
    };

    $.ajax({
        url: 'get_products.php',
        type: 'GET',
        data: data,  
        success: function(response) {
            var data = JSON.parse(response); 
            $('#tableID').html(data.content); 
            $('#paginationBox').html(data.pagination); 
            $('#inputpage').html(data.inputpage);

            console.log(data.totalProducts);

            if(data.totalProducts === 0 ){
                console.log('dghss');
                
                $('#tableID').on('mouseenter', function() {
                    $(this).find('.box_delete_buttons').addClass('hide').removeClass('box_delete_buttons');

                }).on('mouseleave', function() {
                    $(this).find('.hide').addClass('box_delete_buttons').removeClass('hide');
                });
                
            }else {
                $('#tableID').on('mouseenter', function() {
                    $(this).find('.hide').addClass('box_delete_buttons');

                }).on('mouseleave', function() {
                    $(this).find('.box_delete_buttons').addClass('hide');
                });
                
            }
        },
        error: function(error) {
            console.error("Error loading data:", error);
        }
    });
}