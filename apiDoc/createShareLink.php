<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - createShareLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .endpoint {
            margin-bottom: 20px;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-left: 4px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>API Documentation</h1>
    <div class="endpoint">
        <h2>Endpoint: createShareLink</h2>
        <p><strong>Path:</strong> /api/createShareLink.php</p>
        <p><strong>Method:</strong> POST</p>
        <h3>Request</h3>
        <p><strong>Headers:</strong></p>
        <pre>
Content-Type: application/json
        </pre>
        <p><strong>Body:</strong></p>
        <pre>
{
    "login_key": "user_login_key_here"
}
        </pre>
        <h3>Responses</h3>
        <p><strong>Success:</strong></p>
        <pre>
{
    "share_token": "generated_share_token",
    "is_generated_previously": false
}
        </pre>
        <p><strong>If token exists:</strong></p>
        <pre>
{
    "share_token": "existing_share_token",
    "is_generated_previously": true
}
        </pre>
        <p><strong>Errors:</strong></p>
        <pre>
{
    "error": "login_key is required"
}

{
    "error": "User is not logged in"
}

{
    "error": "There are no logged in users with login_key"
}

{
    "error": "DB error: no value for user_id"
}
        </pre>
    </div>
</body>
</html>
