<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getUserEmail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>API Documentation</h1>
        <h2>Endpoint: <code>/api/getUserEmail.php</code></h2>
        <p>This API endpoint retrieves the email address of a user based on their user ID.</p>

        <h3>Request Method</h3>
        <p><strong>GET</strong></p>

        <h3>Parameters</h3>
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
                    <td><code>user_id</code></td>
                    <td>integer</td>
                    <td>Yes</td>
                    <td>The ID of the user whose email address you want to retrieve.</td>
                </tr>
            </tbody>
        </table>

        <h3>Responses</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status Code</th>
                    <th>Description</th>
                    <th>Example</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>200</td>
                    <td>Email address successfully retrieved.</td>
                    <td><code>{\"email\": \"user@example.com\"}</code></td>
                </tr>
                <tr>
                    <td>400</td>
                    <td>Missing or invalid <code>user_id</code> parameter.</td>
                    <td><code>{\"error\": \"user_id is required\"}</code></td>
                </tr>
                <tr>
                    <td>404</td>
                    <td>User not found.</td>
                    <td><code>{\"error\": \"user does not exist\"}</code></td>
                </tr>
                <tr>
                    <td>405</td>
                    <td>Request method not allowed.</td>
                    <td><code>{\"error\": \"Only GET requests are allowed\"}</code></td>
                </tr>
                <tr>
                    <td>500</td>
                    <td>Server error.</td>
                    <td><code>{\"error\": \"Database error: ...\"}</code></td>
                </tr>
            </tbody>
        </table>

        <h3>Example Usage</h3>
        <pre><code>GET /api/getUserEmail.php?user_id=123</code></pre>

        <h3>Notes</h3>
        <ul>
            <li>Ensure the <code>user_id</code> parameter is a valid integer.</li>
            <li>All responses are in JSON format with a <code>Content-Type</code> header of <code>application/json</code>.</li>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
