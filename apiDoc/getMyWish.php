<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            margin-bottom: 1rem;
        }
        code {
            background-color: #eaeaea;
            padding: 2px 4px;
            border-radius: 4px;
            font-family: Consolas, monospace;
            font-size: 0.95rem;
        }
        .endpoint {
            background-color: #f1f1f1;
            padding: 1rem;
            border-left: 4px solid #007bff;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        ul {
            padding-left: 1.5rem;
        }
        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem 0;
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>API Documentation</h1>
        <p>GET Endpoint for Fetching User Wishes</p>
    </header>

    <div class="container">
        <h2>Endpoint Overview</h2>
        <div class="endpoint">
            <strong>URL:</strong> <code>/api/getMyWish.php</code><br>
            <strong>Method:</strong> <code>GET</code>
        </div>

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
                <td>String</td>
                <td>Yes</td>
                <td>User session key used for authentication.</td>
            </tr>
        </table>

        <h2>Response</h2>
        <p>The response is returned in JSON format. Below are the possible responses:</p>

        <h3>Success Response (200 OK)</h3>
        <pre><code>[ 
        {
        "id": 18,
        "created_at": "2024-12-17 12:39:17",
        "user_id": 26,
        "name": "Kinets vikiv game",
        "price": "3890.00",
        "link": "https://geekach.com.ua/kinets-dvxdvikiv-aeons-end/",
        "jar": "send.monobank.ua/jar/example",
        "priority": "medium",
        "visibility": 1,
        "desc": "Board game",
        "img": null
    },,
        {
        "id": 19,
        "created_at": "2024-12-17 12:39:17",
        "user_id": 26,
        "name": "Kinets vikiv game",
        "price": "3890.00",
        "link": "https://geekach.com.ua/kinets-dvxdvikiv-aeons-end/",
        "jar": "send.monobank.ua/jar/example",
        "priority": "medium",
        "visibility": 1,
        "desc": "Board game",
        "img": null
    },
]</code></pre>
        <p>In case there are no wishes:</p>
        <pre><code>[]</code></pre>

        <h3>Error Responses</h3>
        <ul>
            <li><strong>400 Bad Request</strong> - <code>{"error": "login_key is required"}</code></li>
            <li><strong>401 Unauthorized</strong> - <code>{"error": "User not logged in"}</code></li>
            <li><strong>405 Method Not Allowed</strong> - <code>{"error": "Only GET requests are allowed"}</code></li>
            <li><strong>500 Internal Server Error</strong> - <code>{"error": "Server error: ..."}</code></li>
        </ul>

        <h2>Example Usage</h2>
        <p>Send a GET request with a valid <code>login_key</code> parameter:</p>
        <pre><code>GET /api_endpoint.php?login_key=example_session_key</code></pre>
        <p><strong>Example Response:</strong></p>
        <pre><code>[ 
        {
        "id": 18,
        "created_at": "2024-12-17 12:39:17",
        "user_id": 26,
        "name": "Kinets vikiv game",
        "price": "3890.00",
        "link": "https://geekach.com.ua/kinets-dvxdvikiv-aeons-end/",
        "jar": "send.monobank.ua/jar/example",
        "priority": "medium",
        "visibility": 1,
        "desc": "Board game",
        "img": null
    },
]</code></pre>
    </div>

    <footer>
        <p>&copy; 2024 API Documentation</p>
    </footer>
</body>
</html>
