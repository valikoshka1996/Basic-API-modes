<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        code {
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 4px;
            font-family: monospace;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            overflow-x: auto;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .example {
            background: #eef;
            padding: 15px;
            border-left: 4px solid #3a8;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login API Documentation</h1>

        <h2>Endpoint</h2>
        <p><code>POST /api/userLogin.php</code></p>

        <h2>Description</h2>
        <p>This API endpoint handles user login, validates credentials, and generates a new authentication token for successful logins.</p>

        <h2>Request</h2>
        <h3>Headers</h3>
        <ul>
            <li><code>Content-Type: application/json</code></li>
        </ul>

        <h3>Body</h3>
        <pre>{
    "email": "user@example.com",
    "password": "userpassword"
}</pre>

        <h2>Response</h2>
        <h3>Success (200)</h3>
        <pre>{
    "id": 123,
    "email": "user@example.com",
    "is_admin": false,
    "login_key": "abcdef1234567890abcdef1234567890"
}</pre>

        <h3>Error Responses</h3>
        <ul>
            <li><code>400 Bad Request</code>: Missing <code>email</code> or <code>password</code>.</li>
            <li><code>401 Unauthorized</code>: Wrong password.</li>
            <li><code>404 Not Found</code>: User does not exist.</li>
            <li><code>405 Method Not Allowed</code>: Only POST requests are allowed.</li>
            <li><code>500 Internal Server Error</code>: Database connection or other server error.</li>
        </ul>

        <h2>Examples</h2>
        <h3>Request</h3>
        <pre>{
    "email": "admin@example.com",
    "password": "securepassword"
}</pre>

        <h3>Success Response</h3>
        <div class="example">
            <pre>{
    "id": 1,
    "email": "admin@example.com",
    "is_admin": true,
    "login_key": "abc123def456ghi789"
}</pre>
        </div>

        <h3>Error Response</h3>
        <div class="example">
            <pre>{
    "error": "User does not exist"
}</pre>
        </div>
    </div>
</body>
</html>
