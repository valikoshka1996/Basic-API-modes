<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #333;
        }
        code {
            background: #f4f4f4;
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 1.1em;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        .endpoint {
            margin-top: 20px;
            padding: 10px;
            background: #e8f5e9;
            border-left: 4px solid #66bb6a;
        }
        .error {
            color: #e53935;
        }
        .success {
            color: #43a047;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>API Documentation</h1>
    <p>This API provides functionality to clean up unnecessary records from the <code>api_keys_table</code> in the <code>api_keys</code> database.</p>

    <h2>Endpoint: Delete Extra Records</h2>
    <div class="endpoint">
        <strong>URL:</strong> <code>/api/flushApiKeys.php</code><br>
        <strong>Method:</strong> DELETE
    </div>

    <h3>Request</h3>
    <p>The request must contain the following JSON payload:</p>
    <pre>{
    "admin_token": "<your_admin_token>"
}</pre>

    <h4>Headers</h4>
    <ul>
        <li><strong>Content-Type:</strong> application/json</li>
    </ul>

    <h3>Response</h3>
    <p>The API will return a JSON response with the status of the operation and the number of records deleted.</p>

    <h4>Success Response</h4>
    <pre class="success">{
    "status": "success",
    "deleted_records": 5
}</pre>

    <h4>Error Responses</h4>
    <ul>
        <li><code class="error">405 Method Not Allowed</code>: The request method is not DELETE.</li>
        <li><code class="error">400 Bad Request</code>: The <code>admin_token</code> is missing in the request payload.</li>
        <li><code class="error">404 Not Found</code>: The provided <code>admin_token</code> does not exist in the database.</li>
        <li><code class="error">403 Forbidden</code>: The user is not an admin.</li>
        <li><code class="error">500 Internal Server Error</code>: There was an issue connecting to the database or fetching records.</li>
    </ul>

    <h3>Workflow</h3>
    <ol>
        <li>Verify that the request method is DELETE.</li>
        <li>Check if the request payload contains <code>admin_token</code>.</li>
        <li>Validate <code>admin_token</code> against the <code>api_keys_table</code>.</li>
        <li>Verify admin privileges by querying <code>isAdmin.php</code>.</li>
        <li>Identify and delete unnecessary records from the <code>api_keys_table</code> based on the presence of user IDs in the <code>users</code> table.</li>
        <li>Respond with the status and the number of deleted records.</li>
    </ol>

    <h3>Notes</h3>
    <ul>
        <li>The <code>isAdmin.php</code> endpoint must return a JSON response with the <code>is_admin</code> field.</li>
        <li>Ensure the database credentials are correctly configured for both <code>api_keys</code> and <code>user_system</code> databases.</li>
    </ul>
</div>
</body>
</html>
