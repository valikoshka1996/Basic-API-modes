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

// Пошук назви товару
$xpath = new DOMXPath($dom);
$productName = '';

// Пошук основних заголовків
$possibleSelectors = [
    "//h1[contains(@class, 'product-title') or contains(@class, 'title') or contains(@class, 'product_name')]",
    "//h1[not(contains(@class, 'site-title'))]",
    "//meta[@property='og:title']/@content",
    "//meta[@name='twitter:title']/@content",
    "//meta[@name='title']/@content",
    "//div[contains(@class, 'product-name') or contains(@class, 'product_title')]",
    "//span[contains(@class, 'product-name') or contains(@class, 'product_title')]",
    "//title"
];

foreach ($possibleSelectors as $selector) {
    $nodes = $xpath->query($selector);
    if ($nodes->length > 0) {
        $productName = trim($nodes[0]->nodeValue ?? $nodes[0]->textContent);
        if (!empty($productName)) {
            break;
        }
    }
}

// Фільтрація загальних назв (наприклад, назва сайту)
$productName = preg_replace(
    '/(ROZETKA|купити|низькі ціни|гарантія|знижки|оплата частинами|магазин|інтернет-магазин|\|)/i',
    '',
    $productName
);
$productName = trim($productName);

// Якщо нічого не знайдено, повертаємо помилку
if (empty($productName)) {
    http_response_code(404);
    echo json_encode(['error' => 'Product name not found.']);
    exit;
}

// Повертаємо результат
http_response_code(200);
echo json_encode(['name' => $productName]);
exit;