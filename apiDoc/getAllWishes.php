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
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #007BFF;
        }
        code {
            background: #f4f4f4;
            padding: 5px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-left: 3px solid #007BFF;
            overflow-x: auto;
        }
        .endpoint {
            margin-top: 20px;
        }
        .param-table {
            width: 100%;
            border-collapse: collapse;
        }
        .param-table th, .param-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .param-table th {
            background-color: #007BFF;
            color: white;
        }
        .response-example {
            background: #eef7ff;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API Documentation</h1>
        <p>This document provides details about the <strong>GET API Endpoint</strong> that retrieves data from the <code>wishes</code> database table.</p>

        <div class="endpoint">
            <h2>Endpoint</h2>
            <p><strong>URL:</strong> <code>http://your-domain.com/api/endpoint.php</code></p>
            <p><strong>Method:</strong> <code>GET</code></p>
        </div>

        <div class="parameters">
            <h2>Request Parameters</h2>
            <table class="param-table">
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
                        <td>api_key</td>
                        <td>string</td>
                        <td>Yes</td>
                        <td>Your unique API key for authentication.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="responses">
            <h2>Responses</h2>

            <h3>Success (200)</h3>
            <p>Returns all records from the <code>wishes</code> table.</p>
            <div class="response-example">
                <pre>
[  
    {
        "id": 1,
        "wish": "I want a new car",
        "user_id": 2
    },
    {
        "id": 2,
        "wish": "Travel around the world",
        "user_id": 5
    }
]</pre>
            </div>

            <h3>Unauthorized (403)</h3>
            <p>Returned when the provided API key is invalid or missing.</p>
            <div class="response-example">
                <pre>{ "error": "Access denied. Invalid API key." }</pre>
            </div>

            <h3>Bad Request (400)</h3>
            <p>Returned when the <code>api_key</code> parameter is missing.</p>
            <div class="response-example">
                <pre>{ "error": "Missing required parameter: api_key" }</pre>
            </div>

            <h3>Method Not Allowed (405)</h3>
            <p>Returned when using a method other than <code>GET</code>.</p>
            <div class="response-example">
                <pre>{ "error": "Only GET requests are allowed" }</pre>
            </div>

            <h3>Internal Server Error (500)</h3>
            <p>Returned when there is a server or database connection issue.</p>
            <div class="response-example">
                <pre>{ "error": "Database connection error: [error details]" }</pre>
            </div>
        </div>

        <div class="examples">
            <h2>Example Request</h2>
            <p><strong>Request:</strong></p>
            <pre>GET http://your-domain.com/api/endpoint.php?api_key=YOUR_API_KEY</pre>
        </div>

        <footer>
            <p>&copy; 2024 API Documentation. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
