<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getUserWish</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        code {
            background: #eef;
            padding: 2px 4px;
            border-radius: 4px;
            color: #c00;
        }
        pre {
            background: #eef;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API Documentation</h1>
        <h2>getUserWish Endpoint</h2>
        <p><strong>URL:</strong> <code>/api/getUserWish.php</code></p>
        <p><strong>Method:</strong> GET</p>
        <p><strong>Description:</strong> Returns all wishes for a given user ID.</p>

        <h3>Request Parameters</h3>
        <ul>
            <li><code>user_id</code> (required): The ID of the user whose wishes you want to retrieve.</li>
        </ul>

        <h3>Response</h3>
        <h4>Success (200):</h4>
        <p>If wishes are found:</p>
        <pre>
{
    [
        {
            "id": 1,
            "name": "Wish Name",
            "price": 100,
            "link": "http://example.com",
            "jar": "Gift Jar",
            "priority": "High",
            "desc": "Description of the wish."
        },
        {
            "id": 2,
            "name": "Another Wish",
            "price": 200,
            "link": "http://example.com",
            "jar": "Travel Jar",
            "priority": "Medium",
            "desc": "Another wish description."
        }
    ]
}
        </pre>
        <p>If no wishes are found:</p>
        <pre>
{
    "message": "There are no wishes"
}
        </pre>

        <h4>Error Responses:</h4>
        <ul>
            <li><code>400 Bad Request</code>: <code>{"error": "user_id is required"}</code></li>
            <li><code>405 Method Not Allowed</code>: <code>{"error": "Only GET requests are allowed"}</code></li>
            <li><code>500 Internal Server Error</code>: <code>{"error": "Database connection failed: [error message]"}</code></li>
        </ul>

        <h3>Example Usage</h3>
        <p>Request:</p>
        <pre>
GET /api/getUserWish.php?user_id=123
        </pre>
        <p>Response:</p>
        <pre>
{
    [
        {
            "id": 1,
            "name": "Wish Name",
            "price": 100,
            "link": "http://example.com",
            "jar": "Gift Jar",
            "priority": "High",
            "desc": "Description of the wish."
        }
    ]
}
        </pre>
    </div>
</body>
</html>
