<div id="errMessage" class="ui negative toast message toast_error">
<i class="minus circle icon"></i>
  <div class="header">
  At least one field is required.  
  </div>
  <i class="close icon" onclick="removeToast(this.parentElement, 'flexWP')"></i>
  </div>

  <div id="okMessage" class="ui success toast message toast_success">
  <i class="check circle icon"></i>
    <div class="header">
    Added successfully.
    </div>
    <i class="close icon" onclick="removeToast(this.parentElement, 'flexSP')"></i>
  </div>

<div class="ui modal category_box">
<form class="ui form form_add_property" id="saveProperty">
  <div class="field">
    <label>Category</label>
    <input class="" id="input_cate" type="text" name="category" placeholder="Category 1, Category 2, ...">
    <p class="required d-none" id="checkstringP">Don't allow special char.</p>
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


