
<div id="okMessageProduct2" class="ui success message">
    <div class="header">
    Product Update successfully.
    </div>
  </div>
<div class="ui modal product_box">


<div id="noChanges" class="ui negative message d-none">
  <div class="header">
  No changes detected.
  </div>
  </div>


<div id="okMessageProduct" class="ui success message d-none">
    <div class="header">
    Product Added successfully.
    </div>
  </div>

  <!-- form -->
  <form class="ui form form_add_products" class='editProduct' id="saveProduct" onsubmit="return validateForm()" enctype="multipart/form-data">

    <div class="field">
      <label class="product_name_label">Product Name </label>
      <input type="text" name="product_name" id="product_name" placeholder="Product Name">
      <p class="required d-none" id="required">This field is required.</p>
      <p class="required d-none" id="checkstring">Don't allow special char.</p>
    </div>
    <div class="field">
      <label>SKU</label>
      <input type="text" name="sku" id="sku" placeholder="SKU">
      <p class="required d-none" id="checksku">Don't allow special char and Whitespace is not allowed..</p>
      <p class="required d-none" id="skuexist">Oops! This SKU is already taken.</p>


    </div>
    <div class="field">
      <label class="price_label">Price  </label>
      <input type="text" name="price" id="price" placeholder="Price">
      <p class="required d-none" id="checknumber">Just allow number >= 0.</p>

    </div>
    <div class="box_file">
    <div class="field featured_image_box">
      <label class="featured_image_label">Featured Image </label>
      <div  class="box_gallery">
        <div class="ui small image box_input">
        <input type="file" name="featured_image"  id="featured_image" accept="image/*">
        </div>
       
        <div id="resultContainer">
          <img src="" alt="featured Image"  id="uploadedImage"/>

        </div>
      </div>
    </div>
    <div class="field featured_image_box">
      <label>Gallery<span class="required"></label>
      <div class="box_gallery">
        <div class="ui small image box_input" >
          <input accept="image/*" type="file" name="gallery[]" id="gallery" accept="image/*" multiple>
        </div>
        <div class="img_box">
          <div id="galleryPreviewContainer">
            <img src="" alt="Gallery Image" id="galleryImage" />
          </div>
        </div>

      </div>
    </div>
    </div>

    <div id="load_property">
      <div class="field featured_image_box box_property">
        <label>Category</label>
        <select id="categories_select" name="categories[]" multiple class="ui fluid dropdown select_property"> 
        <option value="">Category</option>
      </select>
     
      </div>
      <div class="field featured_image_box box_property">
        <label>Tag</label>
        <select id="tags_select" name="tags[]" multiple class="ui fluid dropdown select_property">
        <option value="">Select Tag</option>
    </select>
      </div>
    </div>
    <input type="hidden" id="product_id" name="product_id" value="">
    <input type="hidden" id="action_type" name="action_type" value="">

    <div class="box_button_add">
      <button id="close_product" class="ui button" type="button">Close</button>

      <button id="addProductButton" class="ui positive button d-none" type="submit" >Add Product</button>
   
     <button id="editProductButton" class="ui positive button d-none" type="submit">Edit Product</button>

    </div>
  </form> 
</div>


