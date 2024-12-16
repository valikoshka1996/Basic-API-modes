<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests are allowed.']);
    exit;
}

// Отримуємо вхідні дані
$data = json_decode(file_get_contents('php://input'), true);

// Перевіряємо наявність параметра 'url'
if (!isset($data['url'])) {
    http_response_code(400);
    echo json_encode(['error' => 'The "url" field is required.']);
    exit;
}

// Перевіряємо, чи є URL валідним
$url = filter_var($data['url'], FILTER_VALIDATE_URL);
if (!$url) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid URL format.']);
    exit;
}

// Завантажуємо HTML вміст сторінки
$html = @file_get_contents($url);
if ($html === false) {
    http_response_code(404);
    echo json_encode(['error' => 'Failed to fetch the page content.']);
    exit;
}

// Аналізуємо HTML за допомогою DOMDocument
libxml_use_internal_errors(true); // Ігноруємо помилки парсингу
$dom = new DOMDocument();
$dom->loadHTML($html);
libxml_clear_errors();

// Шукаємо <meta property="og:image"> (часто використовується для головного зображення)
$xpath = new DOMXPath($dom);
$ogImage = $xpath->query("//meta[@property='og:image']/@content");
if ($ogImage->length > 0) {
    $mainImageUrl = $ogImage->item(0)->nodeValue;
    echo json_encode(['image_url' => $mainImageUrl]);
    exit;
}

// Шукаємо <img> з найбільшим розміром (ширина та висота)
$images = $dom->getElementsByTagName('img');
$largestImage = null;
$largestArea = 0;

foreach ($images as $img) {
    $src = $img->getAttribute('src');
    if (filter_var($src, FILTER_VALIDATE_URL)) {
        $width = $img->getAttribute('width');
        $height = $img->getAttribute('height');

        if (is_numeric($width) && is_numeric($height)) {
            $area = $width * $height;
            if ($area > $largestArea) {
                $largestArea = $area;
                $largestImage = $src;
            }
        }
    }
}

// Повертаємо знайдене зображення
if ($largestImage) {
    echo json_encode(['image_url' => $largestImage]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'No suitable image found on the page.']);
}
