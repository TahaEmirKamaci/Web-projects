<?php
// cURL oturumunu başlat
$ch = curl_init();
ini_set('max_execution_time', 100000);
for($i = 1; $i <= 10; $i++){
// İstek yapılacak URL
$url = "https://www.trendyol.com/sr?mid=63&os=1&pi=$i";

// cURL ayarlarını yap
curl_setopt($ch, CURLOPT_URL, $url); // İstek yapılacak URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Sonuç döndürülmeli, doğrudan ekrana basılmamalı
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"); // User-Agent ekleyelim

// URL'den veriyi çek
$response = curl_exec($ch);

// Hata kontrolü
if ($response === false) {
    die('cURL Error: ' . curl_error($ch));
}

// cURL oturumunu kapat
curl_close($ch);

// DOMDocument ve DOMXPath ile HTML içeriğini parse et
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML(mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8'));
libxml_clear_errors();

$xpath = new DOMXPath($dom);

// Ürün bağlantılarını çek
$productsID = $xpath->query('//div[@class="p-card-wrppr with-campaign-view"]//a');

if ($productsID->length == 0) {
    // İlk XPath sonucu boş ise alternatif XPath ile ürünleri çek
    $productsID = $xpath->query('//div[@class="p-card-chldrn-cntnr card-border"]//a');
}

if ($productsID->length > 0) {
    foreach ($productsID as $aTag) {
        $href = $aTag->getAttribute('href');

        if ($aTag && $href) {
            // Href değerinin başına ana domain ekleyelim
            $fullUrl = "https://www.trendyol.com" . $href;
            echo "Href değeri: " . $fullUrl . "<br>";

            // Ürün detaylarını almak için cURL kullanarak yeni URL'den veri çek
            $chDetail = curl_init();
            curl_setopt($chDetail, CURLOPT_URL, $fullUrl); // Ürün detayları URL'si
            curl_setopt($chDetail, CURLOPT_RETURNTRANSFER, true); // Sonuç döndürülmeli
            curl_setopt($chDetail, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");

            $detailHtml = curl_exec($chDetail);

            if ($detailHtml === false) {
                echo 'cURL Error: ' . curl_error($chDetail);
                curl_close($chDetail);
                continue;
            }

            curl_close($chDetail);

            $newDom = new DOMDocument;
            @$newDom->loadHTML(mb_convert_encoding($detailHtml, 'HTML-ENTITIES', 'UTF-8'));
            $newXpath = new DOMXPath($newDom);

            // Ürün açıklamasını çek
            $productDescriptionNodes = $newXpath->query('//div[@class="product-detail-wrapper"]');
            $productDescription = '';
            foreach ($productDescriptionNodes as $node) {
                $productDescription .= strip_tags(trim($newDom->saveHTML($node)));
            }
            
            // Ürün fiyatını çek
            $productPriceNode = $newXpath->query('//span[@class="prc-org"]');
            $productPrice = '';
            if ($productPriceNode->length > 0) {
                $productPrice = strip_tags(trim($newDom->saveHTML($productPriceNode->item(0))));
            } else {
                $productPriceNode = $newXpath->query('//span[@class="prc-dsc"]');
                if ($productPriceNode->length > 0) {
                    $productPrice = strip_tags(trim($newDom->saveHTML($productPriceNode->item(0))));
                }
            }

            // Ürün adını çek
            $productNameNode = $newXpath->query('//h1[@class="pr-new-br"]/span');
            $productName = $productNameNode->length > 0 ? trim($productNameNode->item(0)->textContent) : '';

            // Ürün bilgilerini ekrana yazdır
            echo "Product Name: " . $productName . "<br>";
            echo "Product Price: " . $productPrice . "<br>";
            echo "Product Description: " . $productDescription . "<br>";

            // Veritabanına bağlan ve verileri ekle
            $servername = "localhost";
            $username = "root"; 
            $password = "";     
            $dbname = "products"; 

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO deneme (product_name, product_price, product_description) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param('sss', $productName, $productPrice, $productDescription);

            if ($stmt->execute()) {
                echo "Kayıt oluşturuldu<br>";
            } else {
                echo "Error: " . $stmt->error . "<br>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "a etiketi bulunamadı.<br>";
        }
    }
} else {
    echo "Belirtilen XPath sonucu boş.<br>";
}
}
?>
