<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add My Watch API Documentation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Add My Watch API Documentation</h1>

        <section class="mb-5">
            <h2>Endpoint</h2>
            <p><strong>URL:</strong> <code>/api/addMyWatch.php</code></p>
            <p><strong>Method:</strong> POST</p>
            <p><strong>Content-Type:</strong> application/json</p>
        </section>

        <section class="mb-5">
            <h2>Request</h2>
            <p>The API accepts the following parameters in the request body:</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Type</th>
                        <th>Required</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>login_key</code></td>
                        <td>string</td>
                        <td>Yes</td>
                        <td>User's login session key.</td>
                    </tr>
                    <tr>
                        <td><code>share_token</code></td>
                        <td>string</td>
                        <td>Yes</td>
                        <td>The share token to identify the wish list.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="mb-5">
            <h2>Response</h2>
            <p>The API responds with the following JSON structure:</p>
            <pre><code>{
    "status": "success"
}</code></pre>
            <p>If an error occurs, the response will contain:</p>
            <pre><code>{
    "error": "Error message"
}</code></pre>
        </section>

        <section class="mb-5">
            <h2>Error Messages</h2>
            <ul>
                <li><code>"Required fields login_key and share_token"</code> - Missing required fields in the request.</li>
                <li><code>"User isn\'t logged in"</code> - Invalid or expired <code>login_key</code>.</li>
                <li><code>"The token {share_token} share_token doesn\'t exist"</code> - The provided share token does not exist.</li>
                <li><code>"You cannot watch own wish list"</code> - The user cannot watch their own wish list.</li>
                <li><code>"You\'ve already watch this user"</code> - The user is already watching the specified wish list.</li>
                <li><code>Database-related error messages</code> - Issues with saving the record.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2>Example Request</h2>
            <pre><code>{
    "login_key": "user123key",
    "share_token": "sharedtoken456"
}</code></pre>
        </section>

        <section class="mb-5">
            <h2>Example Response</h2>
            <pre><code>{
    "status": "success"
}</code></pre>
        </section>
    </div>
</body>
</html>
