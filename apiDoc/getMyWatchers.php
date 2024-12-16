<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getMyWatchers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">API Documentation: <code>/api/getMyWatchers.php</code></h1>
        <p>This API endpoint retrieves a list of watcher IDs for a specific user.</p>

        <h2>Request</h2>
        <h3>Method</h3>
        <p><code>GET</code></p>

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
                    <td><code>login_key</code></td>
                    <td>String</td>
                    <td>Yes</td>
                    <td>The login key of the user.</td>
                </tr>
            </tbody>
        </table>

        <h3>Response</h3>
        <h4>Success</h4>
        <pre><code>[
    {"watcher_id": 1},
    {"watcher_id": 2},
    ...
]</code></pre>

        <h4>Errors</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status Code</th>
                    <th>Error</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>400</td>
                    <td><code>{"error": "Missing login_key parameter."}</code></td>
                    <td>The login_key parameter is missing.</td>
                </tr>
                <tr>
                    <td>401</td>
                    <td><code>{"error": "User not logged in."}</code></td>
                    <td>The login_key does not match any user.</td>
                </tr>
                <tr>
                    <td>404</td>
                    <td><code>{"error": "User doesn't have watchers."}</code></td>
                    <td>No watchers found for the user.</td>
                </tr>
                <tr>
                    <td>404</td>
                    <td><code>{"error": "User hasn't shared a token."}</code></td>
                    <td>No share token found for the user.</td>
                </tr>
                <tr>
                    <td>405</td>
                    <td><code>{"error": "Only GET requests are allowed."}</code></td>
                    <td>The request method is not GET.</td>
                </tr>
            </tbody>
        </table>

        <h2>Example Request</h2>
        <pre><code>GET /api/getMyWatchers.php?login_key=your_login_key</code></pre>

        <h2>Headers</h2>
        <ul>
            <li><code>Content-Type: application/json</code></li>
        </ul>
    </div>
</body>
</html>
