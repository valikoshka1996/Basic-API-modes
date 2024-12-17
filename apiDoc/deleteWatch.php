<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Instructions - Delete Watch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>API Instructions: Delete Watch</h1>
    <p>This API endpoint allows deleting records for a specific user based on their login token and share token.</p>

    <h2>Endpoint</h2>
    <p><code>DELETE /api/deleteWatch.php</code></p>

    <h2>Request</h2>
    <h3>Method</h3>
    <p><strong>DELETE</strong> (other methods are not allowed)</p>

    <h3>Headers</h3>
    <ul>
        <li><strong>Content-Type</strong>: application/json</li>
    </ul>

    <h3>Body</h3>
    <pre>{
    "login_key": "string",  // Required, user login token
    "share_token": "string"   // Required, share token to delete
}</pre>

    <h2>Responses</h2>
    <h3>Success (200)</h3>
    <pre>{
    "status": "success",
    "watcher_id": "integer",  // ID of the user
    "share_token": "string"   // Deleted share token
}</pre>

    <h3>Errors</h3>
    <ul>
        <li><strong>400</strong>: <code>{"error": "The field is required"}</code> - Missing required fields</li>
        <li><strong>401</strong>: <code>{"error": "User doesn’t authorised"}</code> - Invalid login token</li>
        <li><strong>404</strong>: <code>{"error": "This token does not exist for this user"}</code> - No matching share token for this user</li>
        <li><strong>405</strong>: <code>{"error": "Only DELETE method is allowed"}</code> - Invalid HTTP method</li>
        <li><strong>500</strong>: <code>{"error": "Database error: [details]"}</code> - Internal server error</li>
    </ul>

    <h2>Example Usage</h2>
    <h3>Request</h3>
    <pre>
DELETE /api/deleteWatch.php HTTP/1.1
Host: example.com
Content-Type: application/json

{
    "login_key": "example_login_key",
    "share_token": "example_share_token"
}
    </pre>

    <h3>Response</h3>
    <pre>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "status": "success",
    "watcher_id": 123,
    "share_token": "example_share_token"
}
    </pre>
</div>
</body>
</html>
