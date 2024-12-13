<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        header {
            background-color: #4CAF50;
            color: #fff;
            padding: 1rem 2rem;
            text-align: center;
            font-size: 1.5rem;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        h2 {
            color: #4CAF50;
            margin-top: 1.5rem;
        }
        code {
            background-color: #eee;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            color: #c7254e;
            font-size: 0.95rem;
        }
        pre {
            background-color: #272822;
            color: #f8f8f2;
            padding: 1rem;
            overflow-x: auto;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
    </style>
</head>
<body>
<header>
    Logout API Documentation
</header>
<div class="container">
    <h2>Overview</h2>
    <p>This API allows users to log out by deleting their session identified by a <code>login_key</code>. The API accepts <strong>DELETE</strong> requests with JSON body data.</p>

    <h2>Endpoint</h2>
    <p><code>DELETE /logout</code></p>

    <h2>Request Format</h2>
    <p>The API expects a JSON object with the following fields:</p>
    <table>
        <tr>
            <th>Field</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        <tr>
            <td><code>user_id</code></td>
            <td>integer</td>
            <td>The ID of the user trying to log out.</td>
        </tr>
        <tr>
            <td><code>login_key</code></td>
            <td>string</td>
            <td>The session key to be deleted.</td>
        </tr>
    </table>

    <h2>Request Example</h2>
    <pre>
{
    "user_id": 123,
    "login_key": "abc123token"
}
    </pre>

    <h2>Response Format</h2>
    <p>The API returns JSON responses. Below are the possible responses:</p>

    <h3>Success Response</h3>
    <pre>
{
    "message": "Success"
}
    </pre>

    <h3>Error Responses</h3>
    <table>
        <tr>
            <th>Status Code</th>
            <th>Message</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>400</td>
            <td>Both user_id and login_key are required</td>
            <td>Occurs when one or both fields are missing in the request body.</td>
        </tr>
        <tr>
            <td>403</td>
            <td>Not allowed to login. Wrong user_id</td>
            <td>The user_id provided does not match the login_key.</td>
        </tr>
        <tr>
            <td>404</td>
            <td>Session not found</td>
            <td>No session found for the provided login_key.</td>
        </tr>
        <tr>
            <td>405</td>
            <td>Only DELETE requests are allowed</td>
            <td>The request method is not DELETE.</td>
        </tr>
        <tr>
            <td>500</td>
            <td>Database error</td>
            <td>An internal server error occurred.</td>
        </tr>
    </table>

    <h2>Response Example</h2>
    <h3>Error Example</h3>
    <pre>
{
    "message": "Session not found"
}
    </pre>
    <h3>Success Example</h3>
    <pre>
{
    "message": "Success"
}
    </pre>

    <h2>Notes</h2>
    <ul>
        <li>This endpoint strictly requires <strong>DELETE</strong> requests.</li>
        <li>Ensure that both <code>user_id</code> and <code>login_key</code> are provided in the request body.</li>
        <li>Authentication and validation are handled by matching the <code>login_key</code> with the database records.</li>
    </ul>
</div>
</body>
</html>
