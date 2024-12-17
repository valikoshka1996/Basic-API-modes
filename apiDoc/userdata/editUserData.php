<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2 { color: #2c3e50; }
        code { background-color: #f4f4f4; padding: 2px 6px; border: 1px solid #ddd; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; }
        .endpoint { font-weight: bold; color: #27ae60; }
    </style>
</head>
<body>
    <h1>API Documentation</h1>
    <h2>Endpoint: <span class="endpoint">/api/userdata/editUserData.php</span></h2>

    <h3>Method:</h3>
    <p><strong>PATCH</strong></p>

    <h3>Request Format:</h3>
    <p>Content-Type: <code>application/json</code></p>
    <pre>
{
    "login_key": "string",        // Required
    "name": "string",             // Optional
    "surname": "string",          // Optional
    "birth_date": "YYYY-MM-DD",   // Optional
    "sex": "male | female",       // Optional, default: male
    "about": "string",            // Optional
    "adress": "string"            // Optional
}
    </pre>

    <h3>Responses:</h3>
    <h4>Success - Created</h4>
    <pre>
Status Code: 200
{
    "status": "created success",
    "name": "John",
    "surname": "Doe",
    "birth_date": "1990-01-01",
    "sex": "male",
    "about": "About me...",
    "adress": "123 Main St"
}
    </pre>

    <h4>Success - Updated</h4>
    <pre>
Status Code: 200
{
    "status": "updated success",
    "name": "John",
    "surname": "Doe"
}
    </pre>

    <h4>Errors</h4>
    <pre>
Status Code: 400
{
    "error": "Missing login_key"
}

Status Code: 405
{
    "error": "Method Not Allowed",
    "message": "Only PATCH requests are allowed"
}

Status Code: 401
{
    "error": "User does not authorized"
}

Status Code: 200
{
    "message": "No data to update"
}
    </pre>

    <h3>Notes:</h3>
    <ul>
        <li>All optional fields are validated against their formats.</li>
        <li>The <code>login_key</code> is required for authorization.</li>
        <li>Updates only the fields provided in the request body.</li>
    </ul>
</body>
</html>
