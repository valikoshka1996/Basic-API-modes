<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation: Admin Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007BFF;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-x: auto;
        }
        code {
            color: #d6336c;
            background: #f8f9fa;
            padding: 2px 4px;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>API Documentation: Admin Check</h1>
        <p>This API allows users to verify whether a specific user is an administrator by their ID.</p>
        
        <h2>Endpoint</h2>
        <pre>GET /api/check_admin.php</pre>

        <h2>Request Parameters</h2>
        <table>
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
                    <td><code>id</code></td>
                    <td>integer</td>
                    <td>Yes</td>
                    <td>The ID of the user to check.</td>
                </tr>
            </tbody>
        </table>

        <h2>Response</h2>
        <p>The response will be in JSON format.</p>
        
        <h3>Successful Response</h3>
        <pre>
{
    "is_admin": true
}
        </pre>
        <p>If the user is not an administrator:</p>
        <pre>
{
    "is_admin": false
}
        </pre>

        <h3>Error Responses</h3>
        <table>
            <thead>
                <tr>
                    <th>Status Code</th>
                    <th>Error Message</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>400</td>
                    <td><code>ID parameter is required</code></td>
                    <td>The <code>id</code> parameter is missing or empty.</td>
                </tr>
                <tr>
                    <td>405</td>
                    <td><code>Only GET requests are allowed</code></td>
                    <td>The API only supports GET requests.</td>
                </tr>
                <tr>
                    <td>200</td>
                    <td><code>User does not exist</code></td>
                    <td>No user found with the given ID.</td>
                </tr>
                <tr>
                    <td>500</td>
                    <td><code>Database connection failed</code></td>
                    <td>An error occurred while connecting to the database.</td>
                </tr>
                <tr>
                    <td>500</td>
                    <td><code>Database query failed</code></td>
                    <td>An error occurred while executing the query.</td>
                </tr>
            </tbody>
        </table>

        <h2>Example Usage</h2>
        <h3>Request</h3>
        <pre>GET /api/check_admin.php?id=1</pre>

        <h3>Response</h3>
        <pre>
{
    "is_admin": true
}
        </pre>
    </div>
</body>
</html>
