<?php
// Встановлюємо заголовок Content-Type
header('Content-Type: application/json');

// Дозволені методи запиту
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Only POST requests are supported.']);
    exit;
}

// Отримуємо JSON-запит
$data = json_decode(file_get_contents('php://input'), true);

// Перевіряємо наявність та валідність URL
if (empty($data['url']) || !filter_var($data['url'], FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing URL.']);
    exit;
}

$url = $data['url'];

// Завантажуємо HTML-сторінку
$htmlContent = @file_get_contents($url);
if ($htmlContent === false) {
    http_response_code(404);
    echo json_encode(['error' => 'Failed to fetch the page content.']);
    exit;
}

// Визначення та конвертація кодування сторінки
$encoding = mb_detect_encoding($htmlContent, ['UTF-8', 'ISO-8859-1', 'Windows-1251'], true);
if ($encoding) {
    $htmlContent = mb_convert_encoding($htmlContent, 'HTML-ENTITIES', $encoding);
} else {
    $htmlContent = mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8');
}

// Використовуємо DOMDocument для аналізу HTML
libxml_use_internal_errors(true);
$dom = new DOMDocument();
@$dom->loadHTML($htmlContent);
libxml_clear_errors();

// Пошук ціни за селекторами
$xpath = new DOMXPath($dom);
$productPrice = '';

// Можливі селектори ціни
$priceSelectors = [
    "//span[contains(@class, 'current-price') or contains(@class, 'sale-price') or contains(@class, 'final-price')]",
    "//div[contains(@class, 'current-price') or contains(@class, 'sale-price') or contains(@class, 'final-price')]",
    "//*[contains(@class, 'discount-price') or contains(@class, 'product-price')]",
    "//meta[@itemprop='price']/@content",
    "//meta[@property='product:price:amount']/@content",
    "//meta[contains(@name, 'price')]/@content",
    "//div[contains(@class, 'product-box__main_price')]",
    "//div[contains(@class, 'price__current')]",
    "//div[contains(@class, 'sum')]",
    "//div[contains(@class, 'product-price__item')]",
    "//div[contains(@data-quad, 'product_price')]",
    "//span[contains(@class, 'price') and not(contains(@class, 'old'))]",
    "//div[contains(@class, 'price') and not(contains(@class, 'old'))]",
    "//span[contains(@class, 'price__current')]",
    "//div[contains(@class, 'main-price')]",
    "//div[contains(@class, 'final-price')]",
    "//meta[@name='product_price']/@content",
    "//meta[@property='og:price:amount']/@content",
    "//meta[@name='product:price']/@content",
];

foreach ($priceSelectors as $selector) {
    $nodes = $xpath->query($selector);
    if ($nodes->length > 0) {
        foreach ($nodes as $node) {
            $text = trim($node->nodeValue ?? $node->textContent);
            if (empty($text) && $node->nodeType === XML_ATTRIBUTE_NODE) {
                $text = trim($node->nodeValue);
            }
            if (!empty($text) && !preg_match('/old|crossed|del|strikethrough/i', $text)) {
                if (preg_match('/\d+[\s.,]?\d*/', $text, $match)) {
                    $cleanPrice = preg_replace('/[\s.,]+/', '', $match[0]);
                    if (!empty($cleanPrice)) {
                        $productPrice = $cleanPrice;
                        break 2;
                    }
                }
            }
        }
    }
}

// Якщо ціну не знайдено, повертаємо помилку
if (empty($productPrice)) {
    http_response_code(404);
    echo json_encode(['error' => 'Product price not found.']);
    exit;
}

// Повертаємо результат
http_response_code(200);
echo json_encode(['price' => $productPrice]);
exit;
