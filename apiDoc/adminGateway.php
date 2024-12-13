<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">API Documentation</h1>
        <p class="text-center text-muted">Comprehensive guide for the POST Endpoint</p>

        <div class="card">
            <div class="card-header bg-primary text-white">Endpoint Information</div>
            <div class="card-body">
                <p><strong>URL:</strong> <code>/api/adminGateway.php</code></p>
                <p><strong>Method:</strong> POST</p>
                <p><strong>Content-Type:</strong> <code>application/json</code></p>
                <p><strong>Request Body:</strong></p>
                <pre>{ "action": "create" | "reset" }</pre>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">Action: create</div>
            <div class="card-body">
                <p>This action creates a new administrator user in the database.</p>
                <p><strong>Conditions:</strong></p>
                <ul>
                    <li>The request must come from a trusted IP address.</li>
                    <li>No existing administrator user should be present in the database.</li>
                </ul>
                <p><strong>Response:</strong></p>
                <pre>{ "email": "generated_email", "password": "generated_password" }</pre>
                <p><strong>Errors:</strong></p>
                <ul>
                    <li><code>403</code> - IP address not trusted</li>
                    <li><code>400</code> - User already exists</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-warning text-dark">Action: reset</div>
            <div class="card-body">
                <p>This action resets all administrator users in the database.</p>
                <p><strong>Conditions:</strong></p>
                <ul>
                    <li>The request must come from a trusted IP address.</li>
                </ul>
                <p><strong>Response:</strong></p>
                <pre>{ "success": true }</pre>
                <pre>{ "success": false, "message": "There are no admins" }</pre>
                <p><strong>Errors:</strong></p>
                <ul>
                    <li><code>403</code> - IP address not trusted</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white">Error Responses</div>
            <div class="card-body">
                <p>All error responses are returned in the following format:</p>
                <pre>{ "error": "error_message", "details": "optional_details" }</pre>
                <p><strong>Common Errors:</strong></p>
                <ul>
                    <li><code>405</code> - Only POST requests are allowed</li>
                    <li><code>400</code> - Invalid or missing action</li>
                    <li><code>500</code> - Server or database error</li>
                </ul>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
