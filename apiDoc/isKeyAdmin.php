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
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        header h1 {
            font-size: 2.5em;
        }
        section {
            margin-bottom: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        section h2 {
            font-size: 1.5em;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        code {
            background-color: #f4f4f4;
            padding: 2px 5px;
            border-radius: 4px;
            font-family: Consolas, monospace;
        }
        pre {
            background: #272822;
            color: #f8f8f2;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<header>
    <h1>API Documentation</h1>
    <p>Instructions for using the admin API endpoint</p>
</header>

<section>
    <h2>Endpoint</h2>
    <p><code>GET /api/isKeyAdmin.php</code></p>
</section>

<section>
    <h2>Parameters</h2>
    <ul>
        <li><code>api_key</code> (required): The API key of the user to check.</li>
    </ul>
</section>

<section>
    <h2>Responses</h2>
    <h3>Success</h3>
    <pre>{"is_admin": true}</pre>
    <pre>{"is_admin": false}</pre>

    <h3>Errors</h3>
    <ul>
        <li><code>400</code> - Missing or empty <code>api_key</code> parameter</li>
        <li><code>404</code> - <code>Key doesnt exist</code></li>
        <li><code>404</code> - <code>User doesnt exist</code></li>
        <li><code>500</code> - <code>internal format error</code></li>
        <li><code>500</code> - <code>Database connection failed</code></li>
    </ul>
</section>

<section>
    <h2>Example Request</h2>
    <pre>GET /api/check_admin?api_key=example_key123</pre>
</section>

<section>
    <h2>Example Responses</h2>
    <h3>Admin User</h3>
    <pre>{"is_admin": true}</pre>

    <h3>Non-admin User</h3>
    <pre>{"is_admin": false}</pre>

    <h3>Invalid Key</h3>
    <pre>{"error": "Key doesnt exist"}</pre>

    <h3>Invalid User</h3>
    <pre>{"error": "User doesnt exist"}</pre>
</section>

</body>
</html>
