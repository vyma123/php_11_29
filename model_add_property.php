<div class="ui modal category_box">
  <div id="okMessage" class="ui success message d-none">
    <div class="header">
    Added successfully.
    </div>
  </div>
  <div id="errMessage" class="ui negative message d-none">
  <div class="header">
  At least one field is required.  </div>
  </div>
<form class="ui form form_add_property" id="saveProperty">
  <div class="field">
    <label>Category</label>
    <input class="" id="input_cate" type="text" name="category" placeholder="Category 1, Category 2, ...">
    <p class="required d-none" id="checkstring">Don't allow special char.</p>
    <p class="required d-none" id="checkstringcomma"> input only contains commas (,).</p>


  </div>
  <div class="field">
    <label>Tag</label>
    <input class="" id="input_tag" type="text" name="tag" placeholder="Tag 1, Tag 2, ...">
    <p class="required d-none" id="checkstring2">Don't allow special char.</p>
    <p class="required d-none" id="checkstringcomma2"> input only contains commas (,).</p>


  </div>
  
  <div class="box_button_add">
      <button id="close_property" class="ui button" type="button">Close</button>
      <button class="ui button positive" type="submit">Submit</button>
    </div>
</form>
</div>


