<?php
require_once 'includes/db.inc.php';
require 'includes/functions.php';
require 'vendor/autoload.php';



$curl = curl_init();
curl_setopt($curl, CURLOPT_USERAGENT, 'Curl');
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://aliexpress.ru/item/1005007641037367.html?sku_id=12000041611596822",
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
        "Accept-Language: en-US,en;q=0.9,vi;q=0.8",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Cookie: aer_rh=248015333; aer_ec=lKqlxcqUSZlpuv5v1G6zLisUSOX9tyboveKwXFmQtQjPzI+QhLZMwVoyO3eSXuEGi2ge4BG8qse9L6JIB7U3gDy0jx/YwQoY0bjDrpGWm5E=; xman_t=H0kzj0FhY/57QJkJ3S1fyXwEjiyZ1FflHg4lJAKZCKimPf6gMCvb5VugPY+4ffBo; xman_us_f=x_locale=ru_RU&x_l=0&x_c_chg=1&acs_rt=31e8fe74144c40c9960a712cebac409b; xman_f=WHhDEvcSyj+myYNr6O1GnHkbi1duX+Kr3xIU2um/sh8/LcgsnqJpQ4xKAthZVolR6uhNuxDaSZTH17AirFyxwnGcsW8//dmyl9pkPerOKfNkVM7T54qu9A==; aer_abid=876f125e2c92d895..e8807788be6cc9e0; cna=6c7BH0rxVW0CAXGvxHQ1CfOx; _ga=GA1.2.1735361943.1733448472; adrcid=AEqaXynzFCyMVMWrWvsaGQg; tmr_lvid=e55340b97a91e9ba957d42d66f0b6da6; tmr_lvidTS=1731911912480; _ym_uid=1731911914474990564; _ym_d=1733448472; autoRegion=lastGeoUpdate=1733448471&countryCode=VN&latitude=21.5941&longitude=105.8432; aer_lang=en_US; ae_ru_pp_v=1.0.2; aep_usuc_f=b_locale=en_US&c_tp=RUB&region=RU&site=rus&province=917477670000000000&city=917477679070000000; xlly_s=1; _gid=GA1.2.1107561096.1733974279; acs_3=%7B%22hash%22%3A%22768a608b20ce960ff29026da95a81203ec583ad1%22%2C%22nextSyncTime%22%3A1734060680350%2C%22syncLog%22%3A%7B%22224%22%3A1733974280350%2C%221228%22%3A1733974280350%2C%221230%22%3A1733974280350%7D%7D; adrdel=1733974281197; _ym_isad=1; domain_sid=IPFRRCGUUVRmATLY78_3w%3A1733974284048; a_r_t_info=%7B%22name%22%3A%22%22%2C%22id%22%3A%22%22%2C%22chinaName%22%3A%22%22%2C%22referralUrl%22%3A%22https%3A%2F%2Faliexpress.ru%2Fitem%2F1005007641037367.html%22%7D; a_t_info=%7B%22name%22%3A%22pdp%22%2C%22id%22%3A%22dc5290b3-edc6-4216-bf39-88825b6828c8%22%2C%22chinaName%22%3A%22detail%22%2C%22referralUrl%22%3A%22https%3A%2F%2Faliexpress.ru%2Fitem%2F1005007641037367.html%22%7D; _ym_visorc=b; tmr_detect=0%7C1733987694428; isg=BCcnBDCXDGTIy4iU9fY_8o43tlvxrPuOM5zHZvmUGLbc6ESqAX5X3o-gCvD2LNMG; tfstk=g48iAfM_jhS6Xkv8Bp7s0f2rCSnpf5_fgKUAHZBqY9WI1ZKt1SR2iL4TWISYupv9ahIO7GReT_CV3R5V3wRFg_aa0PR4isJpLKjj1tBVnKd2XX3-yCO1lZJme438xt9ybd2NQilVYs5r91R8N4YhlZk-pdndJx_XFSs3BdREtsCYusJVQy7FG954bZJVLM5PwR7VuKlh8sCbuRWV_97Fw9WVuZJ2TXfxiPnNCE8e8AHqYTtfTvTFsGXy_OJvHeJYeTONKrzVr1jg4CW3ur8Hv61wWOo79t_OCBfMh4a17ix2Ww8ZLq7yVpYc4amx1GRDxK_98jrNUhpO8F-ugrRhStJJ8MyiKT86TU_Fv4lkTe991eAYgq5pe9R67Z0rNNbNQwfBkvaNnH-2WG_bQxXX-B8wmg74Yu5hrr1EMerbcG5CtTE_PGG5yJowvXc34jsNO16-tXqbcG5CtThntuufb611e; intl_common_forever=vG4xXyei0JoHEuS0UahmPE8I6GU+P7J2pXGrI1g1FF2/Jo6WyUcG1w==; ali_apache_id=33.22.87.206.1733987706936.026764.1; JSESSIONID=66CE8D99F0F5EF2BD20B1B853D1C9298",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36"
    ),
));

curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

$response = curl_exec($curl);   

curl_close($curl);

$doc = new DOMDocument();
libxml_use_internal_errors(true); // Để bỏ qua lỗi nếu có (do HTML không hợp lệ)
$doc->loadHTML($response);

// Lấy tất cả các thẻ h1
$h1Tags = $doc->getElementsByTagName('h1');

// Echo nội dung của thẻ h1 đầu tiên (nếu có)
if ($h1Tags->length > 0) {
    echo $h1Tags->item(0)->nodeValue;
} else {
    echo "Không tìm thấy thẻ h1.";
}


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
