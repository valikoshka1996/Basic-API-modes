<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Документація - getWishById</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; line-height: 1.6; }
        h1, h2 { color: #333; }
        code { background: #f4f4f4; padding: 3px 6px; border: 1px solid #ddd; border-radius: 4px; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; overflow-x: auto; border-radius: 4px; }
        .endpoint { color: #d63384; font-weight: bold; }
        ul { margin: 0; padding-left: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>API Документація: Отримання даних бажання за ID</h1>
    <p>Цей API дозволяє отримати дані про бажання з бази даних за вказаним <code>ID</code>.</p>

    <h2>Ендпоінт</h2>
    <p><span class="endpoint">GET /api/getWishById.php</span></p>

    <h2>Параметри</h2>
    <table>
        <thead>
            <tr>
                <th>Назва</th>
                <th>Тип</th>
                <th>Обов'язковий</th>
                <th>Опис</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>id</code></td>
                <td>integer</td>
                <td>Так</td>
                <td>ID бажання, яке потрібно отримати.</td>
            </tr>
            <tr>
                <td><code>data</code></td>
                <td>string</td>
                <td>Ні</td>
                <td>Перелік полів для повернення. Можна вказати кілька через кому. <br>Доступні значення: <code>all</code>, <code>id</code>, <code>created_at</code>, <code>user_id</code>, <code>name</code>, <code>price</code>, <code>link</code>, <code>jar</code>, <code>priority</code>, <code>visibility</code>, <code>desc</code></td>
            </tr>
        </tbody>
    </table>

    <h2>Приклади запитів</h2>
    <h3>Отримання всіх полів для бажання з ID = 1</h3>
    <pre>GET /api/getWishById.php?id=1</pre>

    <h3>Отримання конкретних полів: name, price</h3>
    <pre>GET /api/getWishById.php?id=1&data=name,price</pre>

    <h2>Відповіді</h2>
    <h3>Успішна відповідь (приклад)</h3>
    <pre>{
    "id": 1,
    "created_at": "2024-07-10 12:00:00",
    "user_id": 123,
    "name": "Новий ноутбук",
    "price": 1500.50,
    "link": "https://example.com/product",
    "jar": "https://example.com/jar",
    "priority": "high",
    "visibility": true,
    "desc": "Опис бажання"
}</pre>

    <h3>Відповідь з обраними полями</h3>
    <pre>{
    "name": "Новий ноутбук",
    "price": 1500.50
}</pre>

    <h3>Помилка: ID не вказано</h3>
    <pre>{
    "error": "Wish ID is required"
}</pre>

    <h3>Помилка: Невірний параметр data</h3>
    <pre>{
    "error": "Wrong data type"
}</pre>

    <h3>Помилка: Бажання не знайдено</h3>
    <pre>{
    "error": "Wish does not exist"
}</pre>

    <h2>HTTP-коди відповідей</h2>
    <ul>
        <li><strong>200 OK</strong> - Запит успішно оброблено</li>
        <li><strong>400 Bad Request</strong> - Неправильні параметри запиту</li>
        <li><strong>404 Not Found</strong> - Бажання з таким ID не знайдено</li>
        <li><strong>405 Method Not Allowed</strong> - Неправильний метод запиту (тільки GET)</li>
        <li><strong>500 Internal Server Error</strong> - Помилка на сервері</li>
    </ul>
</body>
</html>
