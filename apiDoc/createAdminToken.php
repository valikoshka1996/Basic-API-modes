<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Admin API Key Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #6200ea;
            font-size: 2rem;
        }
        .code {
            background-color: #f4f4f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
            overflow-x: auto;
        }
        a {
            color: #6200ea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin API Key Generator - API Documentation</h1>
        <p>This endpoint allows administrators to generate an API key for accessing restricted services.</p>

        <h2>Endpoint</h2>
        <p><strong>URL:</strong> <code>/api/createAdminToken.php</code></p>
        <p><strong>Method:</strong> <code>POST</code></p>
        <p><strong>Content-Type:</strong> <code>application/json</code></p>

        <h2>Request Parameters</h2>
        <p>The request body must be a JSON object with the following fields:</p>
        <ul>
            <li><code>email</code> (string, required): The email of the administrator.</li>
            <li><code>password</code> (string, required): The password of the administrator.</li>
        </ul>
        <p><strong>Example Request:</strong></p>
        <pre class="code">{
    "email": "admin@example.com",
    "password": "yourpassword"
}</pre>

        <h2>Response</h2>
        <p>The response will be a JSON object. Possible responses include:</p>

        <h3>Success</h3>
        <p><strong>HTTP Status Code:</strong> <code>200 OK</code></p>
        <p><strong>Response Body:</strong></p>
        <pre class="code">{
    "api_key": "generated_api_key",
    "email": "admin@example.com"
}</pre>

        <h3>Errors</h3>
        <ul>
            <li><strong>400 Bad Request:</strong> If <code>email</code> or <code>password</code> is missing.
                <pre class="code">{
    "error": "Email and password fields cannot be empty."
}</pre>
            </li>
            <li><strong>404 Not Found:</strong> If the user with the provided email does not exist.
                <pre class="code">{
    "error": "User not found."
}</pre>
            </li>
            <li><strong>403 Forbidden:</strong> If the password is incorrect or the user is not an administrator.
                <pre class="code">{
    "error": "Invalid password."
}</pre>
                <pre class="code">{
    "error": "User is not an administrator."
}</pre>
            </li>
            <li><strong>500 Internal Server Error:</strong> If there is a database connection error or the API key could not be saved.
                <pre class="code">{
    "error": "Database connection failed."
}</pre>
                <pre class="code">{
    "error": "Failed to save API key."
}</pre>
            </li>
        </ul>

        <h2>Notes</h2>
        <ul>
            <li>The API key is a 32-character hexadecimal string generated using secure random bytes.</li>
            <li>The <code>api_keys</code> table must have at least the following fields: <code>api_key</code>, <code>user_id</code>.</li>
            <li>Ensure that your database is properly configured to store and retrieve hashed passwords.</li>
        </ul>
    </div>
</body>
</html>
