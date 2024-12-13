<?php
function select_all_products(object $pdo)  {
    $query = "SELECT * FROM products";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo=null;
    $stmt=null;
    return $results;
}

function getPropertiesByType($pdo, $type) {
    $query = "SELECT id, name_ FROM property WHERE type_ = :type";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['type' => $type]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isValidInput($input){
    return preg_match('/^[\p{L}0-9 .,–\-_]+$/u', $input);
}



function insert_property(object $pdo, string $type_, string $name_) {
    try {
        $data = [
            'type_' => $type_,
            'name_' => $name_
        ];

        $query = "INSERT INTO property (type_, name_) VALUES (:type_, :name_)";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute($data)) {
            return $pdo->lastInsertId(); 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false; 
    }
}


function getRecordCount($pdo, $searchTermLike, $category = null, $tag = null, $date_from = null, 
                        $date_to = null, $price_from = null, $price_to = null) {
    $query = "SELECT COUNT(DISTINCT products.id) FROM products";
    $conditions = ["(products.product_name LIKE :search_term OR products.sku LIKE :search_term) "];
    $params = [':search_term' => $searchTermLike];
    
    if ($category) {
        $categoryPlaceholders = implode(',', array_map(function ($index) {
            return ':category' . $index;
        }, array_keys($category)));
        
        $query .= " JOIN product_property pp1 ON products.id = pp1.product_id AND pp1.property_id IN ($categoryPlaceholders)";
        
        foreach ($category as $index => $category_id) {
            $params[':category' . $index] = $category_id;
        }
    }

    if ($tag) {
        $tagPlaceholders = implode(',', array_map(function ($index) {
            return ':tag' . $index;
        }, array_keys($tag)));
        
        $query .= " JOIN product_property pp2 ON products.id = pp2.product_id AND pp2.property_id IN ($tagPlaceholders)";
        
        foreach ($tag as $index => $tag_id) {
            $params[':tag' . $index] = $tag_id;
        }
    }

    if ($date_from && $date_to) {
        $conditions[] = "products.date BETWEEN :date_from AND :date_to ";
        $params[':date_from'] = $date_from;
        $params[':date_to'] = $date_to;
    } elseif ($date_from) {
        $conditions[] = "products.date >= :date_from ";
        $params[':date_from'] = $date_from;
    } elseif ($date_to) {
        $end_of_day = $date_to . ' 23:59:59';
        $conditions[] = "products.date <= :end_of_day ";
        $params[':end_of_day'] = $end_of_day;
    }

    if ($price_from !== '' && $price_to !== '') {
        $conditions[] = "products.price BETWEEN :price_from AND :price_to ";
        $params[':price_from'] = $price_from;
        $params[':price_to'] = $price_to;
    } elseif ($price_from != null) {

        $conditions[] = "products.price >= :price_from ";
        $params[':price_from'] = $price_from;

    } elseif ($price_to != null) {
            $conditions[] = "products.price <= :price_to ";
        
        $params[':price_to'] = $price_to;
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();

    return $stmt->fetchColumn();
}


function isValidInputSKU($input) {
    return preg_match('/^[\p{L}0-9 .,–\-\s]*$/u', $input);
}


function isValidNumberWithDotInput($input) {
    return preg_match('/^[0-9.]+$/', $input);
}
function generateRandomLetterSKU() {
    return chr(rand(97, 122)); 
}

function generateSKU($pdo) {

    do {
        $part1 = generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU(); 
        $part2 = generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU(); 
        $part3 = generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU() . generateRandomLetterSKU(); 
        $sku = $part1 . '-' . $part2 . '-' . $part3;

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM products WHERE sku = :sku');
        $stmt->execute(['sku' => $sku]);
        $count = $stmt->fetchColumn();
        
    } while ($count > 0); 

    return $sku;
}


function update_product(object $pdo, int $product_id, string $product_name, string $sku, string $price, string $featured_image){
    $data = [
        'product_id' => $product_id,
        'product_name' => $product_name, 
        'sku' => $sku, 
        'price' => $price, 
        'featured_image' => $featured_image, 
    ];
    
    $query = "UPDATE products 
              SET product_name = :product_name, 
                  sku = :sku, 
                  price = :price, 
                  featured_image = :featured_image 
              WHERE id = :product_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":product_name", $product_name);
    $stmt->bindParam(":sku", $sku);
    $stmt->bindParam(":price", $price);
    $stmt->bindParam(":featured_image", $featured_image);
    $stmt->bindParam(":product_id", $product_id);
    $stmt->execute($data);

    return $stmt->rowCount(); 
}


function update_product_no_image(object $pdo, int $product_id, string $product_name, string $sku, string $price){
    $data = [
        'product_id' => $product_id,
        'product_name' => $product_name, 
        'sku' => $sku, 
        'price' => $price, 
    ];
    
    $query = "UPDATE products 
              SET product_name = :product_name, 
                  sku = :sku, 
                  price = :price
              WHERE id = :product_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":product_name", $product_name);
    $stmt->bindParam(":sku", $sku);
    $stmt->bindParam(":price", $price);
    $stmt->bindParam(":product_id", $product_id);
    $stmt->execute($data);

    return $stmt->rowCount(); 
}


function insert_product(object $pdo, string $product_name, string $sku, string $price, string $featured_image){
    $data = [
        'product_name' => $product_name, 
        'sku' => $sku, 
        'price' => $price, 
        'featured_image' => $featured_image, 

        ];
        
        $query = "INSERT INTO products (product_name, sku, price,featured_image, date) VALUES (:product_name, :sku, :price,:featured_image, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":product_name", $product_name);
        $stmt->bindParam(":sku", $sku);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":featured_image", $featured_image);
        $stmt->execute($data);
        return $pdo->lastInsertId();
}

function add_product_property(PDO $pdo, int $product_id, int $property_id) {
    $query = "INSERT INTO product_property (product_id, property_id) VALUES (:product_id, :property_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":product_id", $product_id);
    $stmt->bindParam(":property_id", $property_id);
    $stmt->execute();
}

function check_duplicate(object $pdo, string $type_, string $name_) {
    try {
        $query = "SELECT COUNT(*) FROM property WHERE type_ = :type_ AND name_ = :name_";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['type_' => $type_, 'name_' => $name_]);
        
        return $stmt->fetchColumn() > 0; 
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function checkDuplicateSKU($sku, $product_id, $pdo) {
    $query = "SELECT COUNT(*) FROM products WHERE sku = :sku AND id != :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':sku', $sku);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT); 
    $stmt->execute();
    return $stmt->fetchColumn();
}

function deleteProductGalleryProperties($product_id, $pdo) {
    $query = "DELETE prop
              FROM property AS prop
              JOIN product_property AS pp ON prop.id = pp.property_id
              JOIN products AS p ON pp.product_id = p.id
              WHERE p.id = :product_id AND prop.type_ = 'gallery'";
    $relatedStmt = $pdo->prepare($query);
    $relatedStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $relatedStmt->execute();

    $query = "DELETE FROM product_property WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
}


function addGalleryProperty($product_id, $file_name, $pdo) {
    $query = "INSERT INTO property (name_, type_) VALUES (:name_, 'gallery')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name_', $file_name);
    $stmt->execute();
    
    $property_id = $pdo->lastInsertId();
    
    $query = "INSERT INTO product_property (product_id, property_id) VALUES (:product_id, :property_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':property_id', $property_id);
    $stmt->execute();
}


function deleteProductProperty($product_id, $propertyType, $pdo) {
    $query = "DELETE pp FROM product_property pp
              JOIN property p ON pp.property_id = p.id
              WHERE pp.product_id = :product_id AND p.type_ = :property";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':property', $propertyType);
    $stmt->execute();
}


function addProductProperties($product_id, $selected_properties, $pdo, $property_type) {
    $stmt = $pdo->prepare("INSERT INTO product_property (product_id, property_id) VALUES (:product_id, :property_id)");

    foreach ($selected_properties as $property) {
        $stmt->execute([
            ':product_id' => $product_id,
            ':property_id' => $property
        ]);
    }
}

function getProperty($pdo, $type_) {
    $query = "SELECT p.id, p.name_ FROM property p WHERE p.type_ = :type_";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':type_' => $type_]); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}


function getExistingProperty($product_id, object $pdo, $type_) {
    $propertySelected = "
        SELECT p.id FROM product_property pp
        JOIN property p ON pp.property_id = p.id
        WHERE pp.product_id = :product_id AND p.type_ = :type_
    ";
    $stmt = $pdo->prepare($propertySelected);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->bindParam(':type_', $type_, PDO::PARAM_STR); 
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

function getNamePropertybyID($product_id, object $pdo, $type_) {
    $propertySelected = "
        SELECT p.name_ FROM product_property pp
        JOIN property p ON pp.property_id = p.id
        WHERE pp.product_id = :product_id AND p.type_ = :type_
    ";
    $stmt = $pdo->prepare($propertySelected);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->bindParam(':type_', $type_, PDO::PARAM_STR); 
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

function getExistingGallery($product_id, object $pdo, $type_) {
    $selectColumn = $type_ === 'gallery' ? 'p.name_' : 'p.id';

    $propertySelected = "
        SELECT $selectColumn FROM product_property pp
        JOIN property p ON pp.property_id = p.id
        WHERE pp.product_id = :product_id AND p.type_ = :type_
    ";
    
    $stmt = $pdo->prepare($propertySelected);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->bindParam(':type_', $type_, PDO::PARAM_STR); 
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}


function checkPropertyMatch($selected_ids, $product_id, $pdo, $type_) {
    $selected_ids = is_array($selected_ids) ? array_map('intval', array_merge(...$selected_ids)) : [];

    $existing_ids = array_column(getExistingProperty($product_id, $pdo, $type_), 'id');

    return empty(array_diff($selected_ids, $existing_ids)) 
           && empty(array_diff($existing_ids, $selected_ids));
}



?>