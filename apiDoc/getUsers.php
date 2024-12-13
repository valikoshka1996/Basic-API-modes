<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .endpoint {
            margin-top: 20px;
        }
        code {
            background: #ecf0f1;
            padding: 5px;
            border-radius: 3px;
        }
        .example {
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>API Documentation</h1>
    <h2>Endpoint: Get Users</h2>
    <div class="endpoint">
        <h3>URL</h3>
        <p><code>/api/getUsers.php?admin_api_key=YOUR_API_KEY</code></p>

        <h3>Method</h3>
        <p>GET</p>

        <h3>Parameters</h3>
        <ul>
            <li><strong>admin_api_key</strong> (required): API ключ адміністратора.</li>
        </ul>

        <h3>Response</h3>
        <p>Успішний запит повертає JSON масив з об'єктами:</p>
        <pre class="example">[
    {
        "id": 1,
        "email": "1@1.1"
    },
    {
        "id": 2,
        "email": "2@2.2"
    }
]</pre>

        <h3>Errors</h3>
        <ul>
            <li><strong>400:</strong> API Admin key required</li>
            <li><strong>403:</strong> User isn't admin</li>
            <li><strong>404:</strong> User exist</li>
            <li><strong>405:</strong> Only GET requests are allowed</li>
            <li><strong>500:</strong> Database error</li>
        </ul>

        <h3>Example Request</h3>
        <p>GET <code>/api/getUsers.php?admin_api_key=123456</code></p>

        <h3>Example Response</h3>
        <pre class="example">[
    {
        "id": 1,
        "email": "user1@example.com"
    },
    {
        "id": 2,
        "email": "user2@example.com"
    }
]</pre>
    </div>
</body>
</html>
