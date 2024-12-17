<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Wish Creation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            margin-top: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        code {
            background-color: #f5f5f5;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 1.1em;
        }
        .section {
            margin-bottom: 30px;
        }
        .response {
            background-color: #e9ecef;
            border-radius: 4px;
            padding: 10px;
            font-family: monospace;
            overflow-x: auto;
        }
        .response code {
            color: #007bff;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>API Documentation</h1>
    <p>Wish Creation API</p>
</header>

<div class="container">
    <section class="section">
        <h2>Overview</h2>
        <p>This API allows you to create a new "wish" by sending a POST request with the necessary data. The wish is then stored in the database, associated with a logged-in user.</p>
    </section>

    <section class="section">
        <h2>Endpoint</h2>
        <p><strong>POST /api/createWish.php</strong></p>
        <p>Send a POST request to this endpoint to create a new wish.</p>
    </section>

    <section class="section">
        <h2>Request Body</h2>
        <p>The request body must be in JSON format. The following fields are required:</p>
        <ul>
            <li><strong>login_key</strong>: The authentication token for the user (string).</li>
            <li><strong>name</strong>: The name of the wish (string).</li>
            <li><strong>visibility</strong>: Whether the wish is visible (boolean).</li>
        </ul>
        <p>Optional fields:</p>
        <ul>
            <li><strong>price</strong>: The price of the wish (float, optional).</li>
            <li><strong>link</strong>: A URL link related to the wish (string, optional).</li>
            <li><strong>jar</strong>: A jar-related identifier (string, optional).</li>
            <li><strong>priority</strong>: Priority level of the wish. Can be one of: 'low', 'medium', or 'high' (string, optional).</li>
            <li><strong>desc</strong>: Description of the wish (string, optional).</li>
            <li><strong>img</strong>: Image URL of the wish (string, optional).</li>
        </ul>
        <p>Example of request body:</p>
        <pre class="response">
{
    "login_key": "user-auth-token",
    "name": "My Wish",
    "visibility": true,
    "price": 100,
    "link": "http://example.com",
    "jar": "send.monobank.ua/jar/example",
    "priority": "high",
    "desc": "This is my wish description.",
    "img": "Image URL"
}
        </pre>
    </section>

    <section class="section">
        <h2>Response</h2>
        <p>The response will be returned in JSON format.</p>
        <p>Success Response:</p>
        <pre class="response">
{
    "success": "Wish successfully created."
}
        </pre>
        <p>Error Responses:</p>
        <ul>
            <li><strong>400 Bad Request</strong>: Missing required fields or invalid data format.</li>
            <li><strong>401 Unauthorized</strong>: Invalid login key or user not logged in.</li>
            <li><strong>405 Method Not Allowed</strong>: Only POST requests are allowed.</li>
            <li><strong>500 Internal Server Error</strong>: Failed to create the wish in the database.</li>
        </ul>
        <p>Error Response Example:</p>
        <pre class="response">
{
    "error": "Invalid URL format for field link."
}
        </pre>
    </section>

    <section class="section">
        <h2>Field Validation</h2>
        <ul>
            <li><strong>login_key</strong>: The key should be valid and correspond to an authenticated user.</li>
            <li><strong>link</strong>: If provided, must be a valid URL format.</li>
            <li><strong>jar</strong>: If provided, must follow the format: "send.monobank.ua/jar/example".</li>
            <li><strong>priority</strong>: If provided, must be one of: 'low', 'medium', or 'high'. Default is 'medium'.</li>
            <li><strong>visibility</strong>: Must be a boolean value (true or false).</li>
        </ul>
    </section>

    <footer>
        <p>API Documentation by Your Company &copy; 2024</p>
    </footer>
</div>

</body>
</html>
