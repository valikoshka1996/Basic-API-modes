<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API документація - Пошук ціни товару</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2 {
            color: #0056b3;
        }
        pre {
            background: #f4f4f4;
            border: 1px solid #ddd;
            padding: 10px;
            overflow-x: auto;
        }
        code {
            color: #d63384;
        }
        .example {
            background: #eef;
            padding: 10px;
            margin-top: 10px;
            border-left: 3px solid #007BFF;
        }
    </style>
</head>
<body>
    <h1>API документація: Пошук ціни товару</h1>

    <p>Цей API дозволяє отримати ціну товару зі сторінки за вказаним URL шляхом аналізу HTML-контенту.</p>

    <h2>Метод запиту</h2>
    <p><strong>POST</strong></p>

    <h2>URL ендпоінту</h2>
    <pre><code>/getProductPrice.php</code></pre>

    <h2>Тіло запиту</h2>
    <p>Запит повинен містити JSON-об'єкт із наступним полем:</p>
    <pre><code>{
  "url": "https://example.com/product-page"
}</code></pre>

    <h2>Відповідь API</h2>
    <p>API повертає JSON-об'єкт з результатом або помилкою:</p>

    <h3>Успішна відповідь</h3>
    <pre><code>{
  "price": "$199.99"
}</code></pre>

    <h3>Помилка</h3>
    <p>У разі помилки API повертає відповідний статус та опис:</p>
    <pre><code>{
  "error": "Product price not found."
}</code></pre>

    <h2>Коди статусів</h2>
    <ul>
        <li><strong>200 OK</strong>: Успішний запит, знайдено ціну товару.</li>
        <li><strong>400 Bad Request</strong>: Невалідний або відсутній URL у запиті.</li>
        <li><strong>404 Not Found</strong>: Ціну товару не знайдено або неможливо завантажити сторінку.</li>
        <li><strong>405 Method Not Allowed</strong>: Неправильний метод запиту (дозволено тільки POST).</li>
    </ul>

    <h2>Приклад використання</h2>
    <p>Нижче наведено приклад відправки запиту через <strong>cURL</strong>:</p>
    <pre><code>curl -X POST -H "Content-Type: application/json" \
-d '{
  "url": "https://example.com/product-page"
}' https://yourdomain.com/getProductPrice.php</code></pre>

    <div class="example">
        <strong>Приклад відповіді:</strong>
        <pre><code>{
  "price": "1999 ₴"
}</code></pre>
    </div>

    <h2>Обмеження</h2>
    <ul>
        <li>URL повинен бути дійсним та доступним.</li>
        <li>API не підтримує парсинг складних динамічних сайтів (JavaScript-rendered контент).</li>
        <li>Сторінка повинна містити ціну у HTML-тегах, які відповідають шаблонам селекторів.</li>
    </ul>

    <footer>
        <p>&copy; 2024 API Пошуку цін. Усі права захищено.</p>
    </footer>
</body>
</html>