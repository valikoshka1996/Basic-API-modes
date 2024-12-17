<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getMyWatch</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">API Documentation: <code>/api/getMyWatch.php</code></h1>

    <section class="mb-5">
        <h2>Endpoint</h2>
        <p><strong>URL:</strong> <code>/api/getMyWatch.php</code></p>
        <p><strong>Method:</strong> GET</p>
        <p><strong>Content-Type:</strong> application/json</p>
    </section>

    <section class="mb-5">
        <h2>Request Parameters</h2>
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
                    <td>The authorization key of the user.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="mb-5">
        <h2>Response</h2>
        <p>The response will be in JSON format with the following structure:</p>
        <pre><code>{
    {"user_id": 1, "share_token": "examplesharetoken1"},
    {"user_id": 2, "share_token": "examplesharetoken2"},
    {"missing_users": ["missingtoken1", "missingtoken2"]}
}</code></pre>
        <p><strong>Notes:</strong>
        <ul>
            <li>The <code>missing_users</code> field is optional and will only appear if there are missing tokens.</li>
        </ul>
        </p>
    </section>

    <section class="mb-5">
        <h2>Error Responses</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status Code</th>
                    <th>Message</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>400</td>
                    <td>"Missing required parameter: login_key"</td>
                    <td>The <code>login_key</code> parameter is not provided in the request.</td>
                </tr>
                <tr>
                    <td>401</td>
                    <td>"Invalid login_key"</td>
                    <td>The provided <code>login_key</code> is invalid or not found.</td>
                </tr>
                <tr>
                    <td>405</td>
                    <td>"Only GET requests are allowed"</td>
                    <td>The request method is not GET.</td>
                </tr>
                <tr>
                    <td>500</td>
                    <td>"Database error: [details]"</td>
                    <td>Internal server error due to database issues.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer class="mt-5">
        <p>© 2024 API Documentation for <code>getMyWatch</code>. All rights reserved.</p>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
