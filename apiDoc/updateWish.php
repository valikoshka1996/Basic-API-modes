<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updateWish API Documentation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
        code { color: #d14; }
    </style>
</head>
<body>
    <h1>API Documentation: <code>/api/updateWish.php</code></h1>
    <p>This endpoint allows you to update a wish in the database. Only PATCH requests are supported.</p>

    <h2>Request</h2>
    <p><strong>Method:</strong> PATCH</p>
    <p><strong>URL:</strong> <code>/api/updateWish.php</code></p>
    <h3>Headers</h3>
    <pre>Content-Type: application/json</pre>
    <h3>Body Parameters</h3>
    <pre>
{
    "login_key": "string (required)",
    "wish_id": "int (required)",
    "name": "string (optional)",
    "visibility": "1 or 0 - (optional)",
    "price": "float (optional)",
    "link": "URL string (optional)",
    "jar": "monobank jar URL string (optional)",
    "priority": "enum ('low', 'medium', 'high') (optional)",
    "desc": "string (optional)"
}
    </pre>

    <h2>Response</h2>
    <h3>Success</h3>
    <pre>
HTTP/1.1 200 OK
{
    "message": "The record {wish_id} has successfully updated"
}
    </pre>
    <h3>Errors</h3>
    <pre>
HTTP/1.1 400 Bad Request
{ "error": "The field login_key and wish_id is required" }

HTTP/1.1 401 Unauthorized
{ "error": "User isn’t log in" }

HTTP/1.1 403 Forbidden
{ "error": "User ID does not match" }

HTTP/1.1 404 Not Found
{ "error": "Wish does not exist" }

HTTP/1.1 400 Bad Request
{ "error": ["Invalid jar URL format"] }

HTTP/1.1 500 Internal Server Error
{ "error": "Database error message" }
    </pre>

    <h2>Example Request</h2>
    <pre>
PATCH /api/updateWish.php
Headers:
Content-Type: application/json

Body:
{
    "login_key": "user-auth-key-123",
    "wish_id": 42,
    "name": "New Wish Name",
    "price": 123.45,
    "priority": "high"
}
    </pre>
</body>
</html>
