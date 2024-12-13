<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .section {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .code {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', Courier, monospace;
            color: #d9534f;
        }
        .response, .error {
            background-color: #f9f9f9;
            border-left: 5px solid #4CAF50;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
        }
        .error {
            border-left-color: #d9534f;
        }
        .parameter {
            font-weight: bold;
            color: #007bff;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>API Documentation</h1>
    </header>
    
    <main>
        <section class="section">
            <h2>Delete Wish</h2>
            <p>This endpoint allows a user to delete a wish from the system.</p>
            <h3>Request</h3>
            <p><strong>Method:</strong> DELETE</p>
            <p><strong>Endpoint:</strong> /api/wishes/delete</p>

            <h3>Parameters</h3>
            <table>
                <tr>
                    <td class="parameter">login_key</td>
                    <td>Required. The unique login key for the authenticated user.</td>
                </tr>
                <tr>
                    <td class="parameter">wish_id</td>
                    <td>Required. The ID of the wish to be deleted.</td>
                </tr>
            </table>

            <h3>Request Example</h3>
            <div class="code">
                <pre>
{
    "login_key": "exampleLoginKey",
    "wish_id": 123
}
                </pre>
            </div>

            <h3>Response</h3>
            <div class="response">
                <pre>
{
    "status": "success",
    "id": 123
}
                </pre>
            </div>

            <h3>Error Responses</h3>
            <ul>
                <li><strong>405 Method Not Allowed:</strong> The method is not allowed. Only DELETE is accepted.</li>
                <li><strong>400 Bad Request:</strong> Missing parameters <code>login_key</code> or <code>wish_id</code>.</li>
                <li><strong>401 Unauthorized:</strong> The login key is invalid or the user is not logged in.</li>
                <li><strong>403 Forbidden:</strong> The wish does not belong to the user.</li>
                <li><strong>500 Internal Server Error:</strong> There was an error with the server.</li>
            </ul>
        </section>

        <section class="section">
            <h2>Example Error Response</h2>
            <div class="error">
                <pre>
{
    "error": "Method Not Allowed"
}
                </pre>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Your API Documentation</p>
    </footer>
</body>
</html>
