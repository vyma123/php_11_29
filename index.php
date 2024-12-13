<?php
require_once './includes/db.inc.php';
require_once './includes/functions.php';
include './handler_property.php';
include './includes/select_products.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css"  />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

    <title>PHP1</title>
</head>
<body>

<?php include('model_add_product.php');?>
<?php include('model_add_property.php');?>

    <section class="container">
        <div class="product_header">
            <div class="product_header_top">
                <div class="left_header">
                    <button id="add_product" class="ui primary button" >Add product</button>
                    <button id="add_property" class="ui button">Add property</button>
                    <a href="#" class="ui button" id="syncButton">Sync online</a>
                    <div class="ui centered inline loader "></div>
                </div>
                <div class="ui icon input">
                    <input id="search" type="text" placeholder="Search product..." value="">
                </div>
            </div>
            <div class="product_header_bottom">
                <select class="ui dropdown" id="sort_by">
                    <option value="date">Date</option>
                    <option value="product_name">Name</option>
                    <option value="price">Price</option>
                </select>
                <select class="ui dropdown" id="order">
                    <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                </select>

                <div class="category_boxx category_update">

                <select name="category[]" id="category" class="ui fluid search dropdown select_category" multiple="">
                <option value="">Category</option>
                <?php
                $query = "SELECT p.id, p.name_ FROM property p WHERE p.type_ = 'category'";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $selectedCategory = $_GET['category'] ?? [];
                foreach ($categories as $category) {
                    $selected = in_array($category['id'], $selectedCategory) ? 'selected' : '';
                    echo "<option $selected value=\"{$category['id']}\">" . htmlspecialchars($category['name_']) . "</option>";
                }
                ?>
        </select>
        </div>
        <div class="category_boxx tag_update">
        <select name="tag[]" id="tag" class="ui fluid search dropdown select_tag" name="tag[]" multiple="">
                <option value="">Select Tag</option>
                <?php
                $query = "SELECT p.id, p.name_ FROM property p WHERE p.type_ = 'tag'";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $selectedTag = $_GET['tag'] ?? [];
                foreach ($tags as $tag) {
                    $selected = in_array($tag['id'], $selectedTag) ? 'selected' : '';
                    echo "<option $selected value=\"{$tag['id']}\">" . htmlspecialchars($tag['name_']) . "</option>";
                }
                ?>
            </select>
            </div>
                <div class="ui input"><input type="date" id="date_from"></div>
                <div class="ui input"><input type="date" id="date_to"></div>
                <div class="ui input">
                    <input class="" type="number" id="price_from" placeholder="price from">
                </div>
                <div class="ui input"><input  type="number" id="price_to" placeholder="price to"></div>
                <button id="filter" class="ui button">Filter</button>
            </div>
        </div>
     
            <!-- table -->
         <div id="inputpage"></div>
         <div id="mytable" class="mytable">
         <div id="box_table" class="box_table table_index">
            <table id="tableID" class="ui compact celled table ">
            <thead>
            <tr>
            <th class="date">Date</th>
            <th class="prd_name">Product name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Feature Image</th>
            <th class="gallery_name">Gallery</th>
            <th >Categories</th>
            <th class="tag_name">Tags</th>
            <th id="action_box" class="action_box">
                <span>Action</span>
                <div class="box_delete_buttons">
                    <a  class="delete_buttons" >
                        <i class="trash icon"></i>
                    </a>
                </div>
            </th>
            </tr>
            </thead>
            <tbody id="productTableBody">
            <?php 
            if (isset($_GET["page"])) {    
                $page = $_GET["page"];    
                if (!is_numeric($page) || $page <= 0) {
                    $page = 1;
                }
            } else {    
                $page = 1;
            }
                if (count($results) > 0) {
                    foreach ($results as $row){
                    $product_id = $row['id']; 
                    $imageSrc = $row['featured_image'];

                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
                    if ($date !== false) {
                        $date = $date->format('d/m/Y');
                    } else {
                        $date = 'error date'; 
                    }

                    ?>
            <tr>
                <td><?php echo htmlspecialchars($date)?></td>
                <td class="product_name"><?php echo htmlspecialchars(htmlspecialchars_decode($row['product_name'] ?? ''), ENT_QUOTES, 'UTF-8');?></td>
                <td class="sku"><?php echo htmlspecialchars($row['sku'] ?? '')?></td>
                <td>$<span class="price"><?php echo htmlspecialchars(rtrim(rtrim($row['price'], '0'), '.') ?? '')?></span></td>

                <td class="featured_image">
                    <?php
                    if (  trim($imageSrc) !== '') {
                            echo '<img class="f_image" src="uploads/' . htmlspecialchars($imageSrc) . '">';
                    } else {
                        echo ''; 
                    }
                    ?>
                </td>
                <?php
           $galleryImages = $row['gallery_images'] ?? ''; 
           if (!empty($galleryImages)) {
               $galleryImagesArray = explode(', ', $galleryImages);
               echo "<td class='gallery'>
                       <div class='gallery-container'>";
               foreach ($galleryImagesArray as $image) {
                   echo "<img src='uploads/" . htmlspecialchars($image, ENT_QUOTES, 'UTF-8') . "'>";
               }
               echo "</div></td>";
           } else {
               echo '<td></td>'; 
           }
           
             echo "<td class='category'>" . htmlspecialchars($row['categories'] ?? '') . "</td>";
             echo "<td class='tag'>" . htmlspecialchars($row['tags'] ?? '') . "</td>";
             ?>
            <td>
            <input  type="hidden" name="id" id="id">
                <button type="submit" data-id="<?= $row['id']?>"  value="<?= $row['id']?>" class="edit_button" >
                <i class="edit icon"></i>
                </button>
            
                <a class="delete_button" data-id="<?= $row['id'] ?>">
                <i class="trash icon"></i>
                </a>
            </td>
            </tr> 
            <?php }}else {?>
                <tr>
                    <td colspan="9" >Product not found</td>
                </tr>
                <?php }?>
            </tbody>
            </table>
        </div>

<div id="paginationBox" class="pagination_box">
    <div class="ui pagination menu">
        <?php
        $total_pages = ceil($total_records / $per_page_record);
        if ($page > 1) {
            echo '<a class="item pagination-link active" data-page="' . ($page - 1) . '">
            <i class="arrow left icon"></i>
            </a>';
        } else {
            echo '<a class="item disabled">
            <i class="arrow left icon"></i>
            </a>
            ';
        }

     
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $page) ? 'active' : '';
            echo '<a class="item pagination-link ' . $active_class . '" data-page="' . $i . '">' . $i . '</a>';
        }

      
        if ($page < $total_pages) {
            echo '<a class="item pagination-link" data-page="' . ($page + 1) . '">
        <i class="arrow right icon"></i>
            </a>';
        } else {
            echo '<a class="item disabled">
        <i class="arrow right icon"></i>
            </a>';
        }
        ?>
    </div>
</div>
</div>
         
<input type="hidden" id="currentPage" value='<?php echo $page ?>'> 

<!-- pagination -->


<div class="overlay">
    <div class="confirmation-dialog">
        <div class="top_delete">
            <div class="box_text_delete">
                <div class="box_delete_icon">
                    <i class="exclamation triangle icon"></i>
                </div>
                <div class="text_delete"> 
                    <h3>Delete Confirmation</h3>
                    <p class="one_delete">Are you sure you want to delete this item? This action cannot be undone.</p>
                    <p class="all_delete">Are you sure you want to delete all items? This action cannot be undone.</p>
                </div>
            </div>
        </div>
        <div class="bottom_delete">
            <button class="confirm-no confirm">Cancel</button>
            <button class="confirm-yes confirm">Delete</button>
        </div>
    </div>
    </div>

</section>
    <script src="./js/submit_product.js" defer></script>
    <script src="./js/edit_product.js" defer></script>
    <script src="./js/submit_property.js" defer></script>
    <script src="./js/show_hide.js" defer></script>
    <script src="./js/filter.js" defer></script>
    <script src="./js/pagination.js" defer></script>
    <script src="./js/delete_product.js" defer></script>
    <script src="./js/sync_products.js" defer></script>
</body>
</html>

</body>
</html>
