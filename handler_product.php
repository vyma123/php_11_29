<?php 
require_once './includes/db.inc.php';
require_once './includes/functions.php';
require_once './includes/select_products.php';



$categories = getPropertiesByType($pdo, 'category');
$tags = getPropertiesByType($pdo, 'tag');





if (isset($_POST['action_type'])) {
    $action_type = $_POST['action_type'];
    
    if ($action_type === 'edit_product') { 

        $product_id = $_POST['product_id'];
        $product_name = test_input($_POST['product_name']);
        $sku = test_input($_POST['sku']);
        $price = test_input($_POST['price']);
        $gallery_images = $_FILES['gallery'];
         
        $selected_categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : [];
        $selected_tags = isset($_POST['tags']) ? json_decode($_POST['tags'], true) : [];
      

        if(!empty($sku)){

            $count = checkDuplicateSKU($sku, $product_id, $pdo);

            
            if ($count > 0) {
                $errors[] = [
                    'field' => 'exist',
                    'message' => 'The SKU already exists for another product.'
                ];
            }
        }

     
        if (!empty($errors)) {
            $res = [
                'status' => '400',
                'errors' => $errors
            ];
            echo json_encode($res);
            return;
        }
       
            $featured_image = $_FILES['featured_image'];
            $file_name = $featured_image['name'];
            $file_tmp_name = $featured_image['tmp_name'];
            
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true); 
            }

            if (move_uploaded_file($file_tmp_name, $upload_dir . $file_name)) {
                if(empty($sku)){
                    $sku = generateSKU($pdo);
                    update_product($pdo, $product_id ,$product_name, $sku, $price, $file_name);
                }else{
                    update_product($pdo, $product_id ,$product_name, $sku, $price, $file_name);
                }
            } else{
                if(empty($sku)){
                    $sku = generateSKU($pdo);
                    update_product_no_image($pdo, $product_id ,$product_name, $sku, $price);
                }else{
                    update_product_no_image($pdo, $product_id ,$product_name, $sku, $price);
                }
            }
       
        
        if (isset($_FILES['gallery'])) {
            $gallery_images = $_FILES['gallery'];
            $gallery_filenames = [];
        
            $upload_dir = 'uploads/';
            if (isset($_FILES['gallery']) && $_FILES['gallery']['error'][0] == 0) {

            deleteProductGalleryProperties($product_id, $pdo);

            foreach ($gallery_images['name'] as $key => $name) {
                $tmp_name = $gallery_images['tmp_name'][$key];
                $file_name = basename($name);
                $target_path = $upload_dir . $file_name;

                if (move_uploaded_file($tmp_name, $target_path)) {

                    addGalleryProperty($product_id, $file_name, $pdo);

                }
            }
        }
        }
      
        if (!empty($selected_categories)) {
            $propertyType = 'category';  
           deleteProductProperty($product_id, $propertyType, $pdo);

        }

        if (!empty($selected_categories) && is_array($selected_categories[0])) {
            $selected_categories = $selected_categories[0];
        }

        addProductProperties($product_id, $selected_categories, $pdo, 'category');

        $responses[] = ['status' => 200, 'message' => 'Categories added successfully.'];

        $categorySelected = "SELECT p.name_ FROM product_property pp
        JOIN property p ON pp.property_id = p.id
        WHERE pp.product_id = :product_id AND p.type_ = 'category'";
            $stmt = $pdo->prepare($categorySelected);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $categoriesse = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($selected_tags)) {
            $propertyType = 'tag';  
            deleteProductProperty($product_id, $propertyType, $pdo);
        }
        if (!empty($selected_tags) && is_array($selected_tags[0])) {
            $selected_tags = $selected_tags[0];
        }

        addProductProperties($product_id, $selected_tags, $pdo, 'tag');

        $responses[] = ['status' => 200, 'message' => 'Tags added successfully.'];
        
        $tagSelected = "SELECT p.name_ FROM product_property pp
        JOIN property p ON pp.property_id = p.id
        WHERE pp.product_id = :product_id AND p.type_ = 'tag'";
        $stmt = $pdo->prepare($tagSelected);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $tagsse = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
         $res = ['status' => 200, 'action' => 'edit', 
                  'message' => 'Product updated successfully',
                  'product_id' => $product_id,
                  'product_name' => $product_name,
                  'sku' => $sku,
                  'price' => $price,
                  'featured_image' => $featured_image, 
                  'gallery' => $gallery_images, 
                  'category' => $categoriesse, 
                  'tag' => $tagsse, 

                ];
         echo json_encode($res);
         return;

    } elseif ($action_type === 'add_product') {
       
        $selected_categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : [];
        $selected_tags = isset($_POST['tags']) ? json_decode($_POST['tags'], true) : [];

        $product_name = test_input($_POST['product_name']);
        $sku = test_input($_POST['sku']);
        $price = test_input($_POST['price']);
        $featured_image = $_FILES['featured_image'];
        $gallery_images = $_FILES['gallery'];
        $errors = [];
        $responses = [];

        

        if(!empty($sku)){
            $query = "SELECT COUNT(*) FROM products WHERE sku = :sku";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if($count > 0){
                $errors[] = [
                    'field' => 'exist',
                    'message' => 'exist'
                ];
            }
        }


        if (!empty($errors)) {
            $res = [
                'status' => '400',
                'errors' => $errors
            ];
            echo json_encode($res);
            return;
        }

            $file_name = $featured_image['name'];
            move_uploaded_file($featured_image['tmp_name'], 'uploads/' . $file_name);
           
                if(empty($sku)){
                    $sku = generateSKU($pdo);
                    $product_id = insert_product($pdo, $product_name, $sku, $price, $file_name);
                }else{
                    $product_id = insert_product($pdo, $product_name, $sku, $price, $file_name);
                }
            

            if (!$product_id) {
                echo json_encode(['status' => 500, 'message' => 'Failed to insert product.']);
                return;
            }
        

        if (!empty($selected_categories) && is_array($selected_categories[0])) {
            $selected_categories = $selected_categories[0];
        }

        addProductProperties($product_id, $selected_categories, $pdo, 'category');

        
        $responses[] = ['status' => 200, 'message' => 'Categories added successfully.'];

        if (!empty($selected_tags) && is_array($selected_tags[0])) {
            $selected_tags = $selected_tags[0];
        }

        addProductProperties($product_id, $selected_tags, $pdo, 'tag');

        $responses[] = ['status' => 200, 'message' => 'Tags added successfully.'];

        if (!empty($gallery_images['name'][0])) {
            $unique_images = []; 
            
            foreach ($gallery_images['error'] as $key => $error) {
                if ($error === UPLOAD_ERR_OK) {
                    $gallery_file_name = $gallery_images['name'][$key];
                    
                    if (!in_array($gallery_file_name, $unique_images)) {
                        move_uploaded_file($gallery_images['tmp_name'][$key], 'uploads/' . $gallery_file_name);
        
                        $property_id = insert_property($pdo, 'gallery', $gallery_file_name);
                        add_product_property($pdo, $product_id, $property_id);
        
                        $responses[] = [
                            'status' => 200,
                            'message' => 'Gallery image ' . $gallery_file_name . ' uploaded successfully.'
                        ];
        
                        $unique_images[] = $gallery_file_name;
                    }
                }
            }
        }

    


        $res = [
                 'status' => 200, 'action' => 'add',
                 'message' => 'Product added successfully',
                ];
        echo json_encode($res);

        return;
    }
} 


if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];


    $query = "SELECT * FROM products WHERE id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);  

        $categoryQuery = "SELECT id, name_ FROM property WHERE type_ = 'category'";
        $categoryStmt = $pdo->prepare($categoryQuery);
        $categoryStmt->execute();
        $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

        $categorySelected = "SELECT p.name_ FROM product_property pp
                    JOIN property p ON pp.property_id = p.id
                    WHERE pp.product_id = :product_id AND p.type_ = 'category'";
        $stmt = $pdo->prepare($categorySelected);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $categoriesse = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $tagQuery = "SELECT id, name_ FROM property WHERE type_ = 'tag'";
        $tagStmt = $pdo->prepare($tagQuery);
        $tagStmt->execute();
        $tags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);

        
        $tagSelected = "SELECT p.name_ FROM product_property pp
                    JOIN property p ON pp.property_id = p.id
                    WHERE pp.product_id = :product_id AND p.type_ = 'tag'";
        $stmt = $pdo->prepare($tagSelected);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $tagsse = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $galleryQuery = "SELECT p.name_ FROM product_property pp
                    JOIN property p ON pp.property_id = p.id
                    WHERE pp.product_id = :product_id AND p.type_ = 'gallery'";
        $galleryStmt = $pdo->prepare($galleryQuery);
        $galleryStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $galleryStmt->execute();
        $gallery = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);


        $res = [
            'status' => 200,
            'data' => $product,
            'categories' => $categories,
            'tags' => $tags,
            'gallery' => $gallery,
            'categoriesse' => $categoriesse,
            'tagsse' => $tagsse,

        ];
        
    } else {
        $res = [
            'status' => 404,
            'message' => 'Product not found',
        ];
    }
    
    echo json_encode($res);
}

if (!isset($_POST['action_type']) && !isset($_GET['product_id'])) {
    $res = [
        'categories' => $categories,
        'tags' => $tags,
    ];
    echo json_encode($res);
    return;
}
?>