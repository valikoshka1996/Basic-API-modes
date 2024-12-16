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

// Пошук опису товару
$xpath = new DOMXPath($dom);
$description = '';

// Спроба знайти meta description
define("META_QUERY", "//meta[@name='description' or @property='og:description']/@content");
$metaDescription = $xpath->query(META_QUERY);
if ($metaDescription->length > 0) {
    $description = $metaDescription[0]->nodeValue;
}

// Якщо мета-опис відсутній, шукаємо текст у специфічних елементах
if (empty($description)) {
    $possibleSelectors = [
        "//div[contains(@class, 'product-detail')]",
        "//div[contains(@class, 'description')]",
        "//span[contains(@class, 'description')]",
        "//h1",
        "//p[contains(@class, 'product-description')]",
        "//div[contains(@id, 'product-description')]"
    ];

    foreach ($possibleSelectors as $selector) {
        $nodes = $xpath->query($selector);
        if ($nodes->length > 0) {
            $description = trim($nodes[0]->textContent);
            if (!empty($description)) {
                break;
            }
        }
    }
}

// Фільтрація загальних описів (назва сайту, слоган)
$description = preg_replace(
    '/ROZETKA|купити|низькі ціни|гарантія|знижки|оплата частинами/i',
    '',
    $description
);
$description = trim($description);

// Якщо нічого не знайдено, повертаємо помилку
if (empty($description)) {
    http_response_code(404);
    echo json_encode(['error' => 'Product description not found.']);
    exit;
}

// Повертаємо результат
http_response_code(200);
echo json_encode(['description' => $description]);
exit;
