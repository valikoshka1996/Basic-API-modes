<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Delete User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .code {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">API Documentation</h1>
        <h2>Delete User</h2>
        <p>This API allows administrators to delete a user from the system.</p>

        <h3>Endpoint</h3>
        <p><code>DELETE /api/deleteUser.php</code></p>

        <h3>Request Format</h3>
        <p>The request must be sent in JSON format and contain the following fields:</p>
        <ul>
            <li><strong>admin_token</strong> (string): The administrator's API token.</li>
            <li><strong>delete_email</strong> (string): The email of the user to be deleted.</li>
        </ul>

        <h3>Response Format</h3>
        <p>The response will be in JSON format and may contain the following fields:</p>
        <ul>
            <li><strong>message</strong> (string): Success message (if the request is successful).</li>
            <li><span class="error">error</span> (string): Error message (if the request fails).</li>
        </ul>

        <h3>Example Request</h3>
        <div class="code">
<pre>{
    "admin_token": "abcd1234efgh5678ijkl",
    "delete_email": "user@example.com"
}</pre>
        </div>

        <h3>Example Response</h3>
        <h4>Successful Response</h4>
        <div class="code">
<pre>{
    "message": "User deleted successfully"
}</pre>
        </div>
        <h4>Error Response</h4>
        <div class="code">
<pre>{
    "error": "User not found"
}</pre>
        </div>

        <h3>Error Handling</h3>
        <ul>
            <li>If the <code>admin_token</code> is not found, the response will be: <code>{"error": "API key not found"}</code>.</li>
            <li>If the user associated with <code>admin_token</code> is not an admin, the response will be: <code>{"error": "User isn't admin"}</code>.</li>
            <li>If the user associated with <code>delete_email</code> is not found, the response will be: <code>{"error": "User not found"}</code>.</li>
        </ul>

        <h3>Database Information</h3>
        <p>The script uses the following databases:</p>
        <ul>
            <li><strong>api_keys</strong>: Contains the <code>api_keys_table</code> with fields:</li>
            <ul>
                <li><code>api_key</code>: Administrator API key.</li>
                <li><code>user_id</code>: ID of the user associated with the API key.</li>
            </ul>
            <li><strong>user_system</strong>: Contains the <code>users</code> table with fields:</li>
            <ul>
                <li><code>id</code>: User ID.</li>
                <li><code>email</code>: User's email.</li>
            </ul>
        </ul>

        <h3>Notes</h3>
        <ul>
            <li>Ensure the <code>isAdmin.php</code> endpoint is accessible and functioning correctly.</li>
            <li>Administrator tokens must be pre-configured in the <code>api_keys_table</code>.</li>
            <li>The <code>deleteUser.php</code> endpoint only accepts DELETE requests.</li>
        </ul>
    </div>
</body>
</html>
