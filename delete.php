<?php 
require_once 'includes/db.inc.php';
try {
   
    $stmt = $pdo->prepare("DELETE FROM products"); 
    $stmt->execute();

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

    $query = "SELECT COUNT(*) AS count FROM products";
    $stmtp = $pdo->prepare($query);
    $stmtp->execute();
    $count = $stmtp->fetch(PDO::FETCH_ASSOC);

try {

$uploadDir = 'uploads/';

if (is_dir($uploadDir)) {
    $files = glob($uploadDir . '*'); 
    
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); 
        }
    }
}
   
    $stmt = $pdo->prepare("DELETE FROM property where type_ = 'gallery'"); 
    $stmt->execute();
    echo json_encode([
    'success' => true,
    'count' => $count['count'],
    ['countf' => count($files)]
    
]);


} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}





?>