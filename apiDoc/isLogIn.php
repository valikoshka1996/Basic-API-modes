<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Check User Login Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background: #007BFF;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1, h2 {
            color: #007BFF;
        }
        code {
            background-color: #f4f4f4;
            padding: 5px 10px;
            border-radius: 5px;
            font-family: monospace;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            overflow-x: auto;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header>
        <h1>API Documentation</h1>
        <p>Check User Login Status Endpoint</p>
    </header>

    <div class="container">
        <h2>Overview</h2>
        <p>This API endpoint allows you to check whether a user is logged in by validating a <code>login_key</code> parameter.</p>

        <h2>Endpoint</h2>
        <p><strong>URL:</strong> <code>/api/isLogIn.php</code></p>
        <p><strong>Method:</strong> <code>GET</code></p>

        <h2>Request Parameters</h2>
        <table>
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><code>login_key</code></td>
                <td>string</td>
                <td>Yes</td>
                <td>A unique key representing the user's login session.</td>
            </tr>
        </table>

        <h2>Response</h2>
        <p>The response is returned in JSON format with the following fields:</p>

        <table>
            <tr>
                <th>Field</th>
                <th>Type</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><code>is_loged_in</code></td>
                <td>boolean</td>
                <td>Returns <code>true</code> if the user is logged in, otherwise <code>false</code>.</td>
            </tr>
            <tr>
                <td><code>error</code></td>
                <td>string</td>
                <td>An error message if the request fails.</td>
            </tr>
        </table>

        <h2>Examples</h2>

        <h3>Successful Request</h3>
        <p><strong>Request:</strong></p>
        <pre>GET /api/isLogIn.php?login_key=example_key</pre>
        <p><strong>Response:</strong></p>
        <pre>{
    "is_loged_in": true
}</pre>

        <h3>Failed Request (Invalid Key)</h3>
        <p><strong>Request:</strong></p>
        <pre>GET /api/isLogIn.php?login_key=invalid_key</pre>
        <p><strong>Response:</strong></p>
        <pre>{
    "is_loged_in": false
}</pre>

        <h3>Missing Parameter</h3>
        <p><strong>Request:</strong></p>
        <pre>GET /your_endpoint.php</pre>
        <p><strong>Response:</strong></p>
        <pre>{
    "error": "Missing 'login_key' parameter"
}</pre>

        <h2>Error Codes</h2>
        <table>
            <tr>
                <th>Code</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>400</td>
                <td>Bad Request - Missing or invalid parameters.</td>
            </tr>
            <tr>
                <td>405</td>
                <td>Method Not Allowed - Only GET method is allowed.</td>
            </tr>
            <tr>
                <td>500</td>
                <td>Internal Server Error - Database or server issues.</td>
            </tr>
        </table>

        <footer>
            <p>&copy; 2024 API Documentation | Designed for User Login Verification</p>
        </footer>
    </div>
</body>
</html>
