<?php
require_once 'includes/db.inc.php';
require 'includes/functions.php';
require 'vendor/autoload.php';



use Goutte\Client;
use Symfony\Component\BrowserKit\Cookie;

$client = new Client();

$client->getCookieJar()->set(new Cookie('aer_lang', 'en_US', time() + 3600, '/')); 

$crawler = $client->request('GET', 'https://aliexpress.ru/item/1005007641037367.html?sku_id=12000041611596822', [], [], [
    'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8', 
    'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
]);



$titles = [];  
$colorArray = [];

if ($crawler->filter('h1')->count() > 0) {
    $titles[] = $crawler->filter('h1')->text();
    $productId = $crawler->filter('div[exp_product]')->attr('exp_product');
    preg_match('/productId=(\d+)/', $productId, $matches);
} 


if ($crawler->filterXPath('(//div[@class="SnowSku_SkuPropertyItem__skuProp__1lob1"]/div)[1]//span[2]')->count() > 0) {
    $crawler->filterXPath('(//div[@class="SnowSku_SkuPropertyItem__skuProp__1lob1"]/div)[1]//span[2]')
        ->each(function ($node) use (&$colorArray) {
            $colorArray[] = $node->text();
        });

    foreach ($colorArray as $color) {
        echo "colors: $color" . PHP_EOL;
    }
} else {
    echo "no color";
}

$priceArray = [];

if ($crawler->filterXPath('//div[contains(@class, "HazeProductPrice_SnowPrice__mainS")]')->count() > 0) {
    $crawler->filterXPath('//div[contains(@class, "HazeProductPrice_SnowPrice__mainS")]')
        ->each(function ($node) use (&$priceArray) {
            $priceArray[] = $node->text();
        });

    foreach ($priceArray as $price) {
        echo "price: " . $price . PHP_EOL;
    }
} else {
    echo "no price!";
}


$sizeArray = [];

if ($crawler->filterXPath('//ul[@class="SnowSku_SkuPropertyItem__optionList__1lob1"]/li/button/span[2]')->count() > 0) {
    $crawler->filterXPath('//ul[@class="SnowSku_SkuPropertyItem__optionList__1lob1"]/li/button/span[2]')
        ->each(function ($node) use (&$sizeArray) {
            $sizeArray[] = $node->text();
        });

    foreach ($sizeArray as $size) {
        echo "sizes: " . $size . PHP_EOL;
    }
} else {
    echo "no size!";
}

$imageSrcArray = [];

if ($crawler->filterXPath('//ul[@class="SnowSku_SkuPropertyItem__optionList__1lob1"]/li/button/picture/img')->count() > 0) {
    $crawler->filterXPath('//ul[@class="SnowSku_SkuPropertyItem__optionList__1lob1"]/li/button/picture/img')
        ->each(function ($node) use (&$imageSrcArray) {
            $imageSrcArray[] = $node->attr('src');
        });

    foreach ($imageSrcArray as $image) {
        echo "featured: " . $image . PHP_EOL;
    }
} else {
    echo "no featured";
}

$imageSrcGalleryArray = [];

if ($crawler->filterXPath('//div[contains(@class, "SnowProductGallery__previews")]//div/picture/img')->count() > 0) {
    $crawler->filterXPath('//div[contains(@class, "SnowProductGallery__previews")]//div/picture/img')
        ->each(function ($node) use (&$imageSrcGalleryArray) {
            $imageSrcGalleryArray[] = $node->attr('src');
        });

    foreach ($imageSrcGalleryArray as $image) {
        echo "gallery: " . $image . PHP_EOL;
    }
} else {
    echo "no gallery!";
}


$productId = isset($matches[1]) ? $matches[1] : null;


function convertPriceToUSD($rubPrice) {
    return $rubPrice * 0.01;
}

function downloadImage($imageUrl, $imageName) {
    $imageContents = file_get_contents($imageUrl); 
    if ($imageContents === false) {
        return null; 
    }

    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($imageName);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    $saved = file_put_contents($imagePath, $imageContents); 
    if ($saved === false) {
        return null; 
    }

    return $imagePath; 
}

foreach ($titles as $key => $title) {

    $rubPrice = floatval($priceArray[$key]);
    $usdPrice = convertPriceToUSD($rubPrice);
    $featuredImageSrc = $imageSrcArray[$key] ?? null; 

    if ($featuredImageSrc) {
        $imageName = basename($featuredImageSrc);
        $downloadedImagePath = downloadImage($featuredImageSrc, $imageName);
        
        if ($downloadedImagePath) {
            $imageNameOnly = basename($downloadedImagePath); 
        } else {
            echo "Failed to save image." . PHP_EOL;
        }
    }


    foreach ($colorArray as $color) {

    echo 'mau'.$color;

        foreach ($sizeArray as $size) {
            $name = $title . ' ' . $color . ' ' . $size;

            echo $name;

            $productId++;

            $checkStmt = $pdo->prepare('SELECT crawl_p_id FROM products WHERE crawl_p_id = :crawl_p_id');
            $checkStmt->execute(['crawl_p_id' => $productId]); 
            $existingProduct = $checkStmt->fetch();

            if ($existingProduct) {

                $checkStmt = $pdo->prepare('SELECT id FROM products WHERE crawl_p_id = :crawl_p_id');
                $checkStmt->execute(['crawl_p_id' => $productId]); 
                $product_id = $checkStmt->fetchColumn();

                $sku = generateSKU($pdo);

                deleteProductGalleryProperties($product_id, $pdo);
                $updateStmt = $pdo->prepare('UPDATE products 
                SET product_name = :product_name, 
                    sku = :sku,
                    price = :price,
                    featured_image = :featured_image
                WHERE crawl_p_id = :crawl_p_id');
                $updateStmt->execute([
                'product_name' => $name,
                'sku' => $sku,
                'price' => $usdPrice,
                'featured_image' => $imageNameOnly,
                'crawl_p_id' => $productId,
                ]);

                foreach ($imageSrcGalleryArray as $galleryImageSrc) {

                    $imageName = basename($galleryImageSrc);
                    $downloadedGalleryPath = downloadImage($galleryImageSrc, $imageName);
                    
                    if ($downloadedGalleryPath) {
                        $galleryImageNameOnly = basename($downloadedGalleryPath);
                        addGalleryProperty($product_id, $galleryImageNameOnly, $pdo);
                    } else {
                        echo "Failed to save gallery image." . PHP_EOL;
                    }
                }

            } else {
                $sku = generateSKU($pdo);

                $insertStmt = $pdo->prepare('INSERT INTO products (crawl_p_id, product_name, sku, price, featured_image, date) VALUES (:crawl_p_id, :product_name, :sku, :price, :featured_image, now())');
                $insertStmt->execute([
                    'crawl_p_id' => $productId,
                    'product_name' => htmlspecialchars($name),
                    'sku' => htmlspecialchars($sku),
                    'price' => $usdPrice,
                    'featured_image' => $imageNameOnly,
                ]);
                $product_id = $pdo->lastInsertId();

                foreach ($imageSrcGalleryArray as $galleryImageSrc) {

                    $imageName = basename($galleryImageSrc);
                    $downloadedGalleryPath = downloadImage($galleryImageSrc, $imageName);
                    
                    if ($downloadedGalleryPath) {
                        $galleryImageNameOnly = basename($downloadedGalleryPath);
                        addGalleryProperty($product_id, $galleryImageNameOnly, $pdo);
                    } else {
                        echo "Failed to save gallery image." . PHP_EOL;
                    }
                }
            }
        }
    }
}

?>
