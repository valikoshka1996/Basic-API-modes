<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background: #333;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        code {
            background: #f4f4f9;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            color: #c7254e;
        }
        pre {
            background: #f4f4f9;
            padding: 1rem;
            border-left: 3px solid #333;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 0.8rem;
            text-align: left;
        }
        th {
            background: #333;
            color: #fff;
        }
        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Registration API Documentation</h1>
    </header>
    <div class="container">
        <h2>Endpoint</h2>
        <p><strong>POST</strong> <code>/user/register</code></p>

        <h2>Request</h2>
        <h3>Headers</h3>
        <table>
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Content-Type</td>
                    <td>application/json</td>
                </tr>
            </tbody>
        </table>

        <h3>Body</h3>
        <p>The request body must be in JSON format and include the following fields:</p>
        <table>
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>email</td>
                    <td>string</td>
                    <td>Yes</td>
                    <td>A valid email address</td>
                </tr>
                <tr>
                    <td>password</td>
                    <td>string</td>
                    <td>Yes</td>
                    <td>At least 6 characters long</td>
                </tr>
            </tbody>
        </table>

        <h2>Response</h2>
        <h3>Success</h3>
        <pre>{"message": "success"}</pre>

        <h3>Errors</h3>
        <table>
            <thead>
                <tr>
                    <th>Status Code</th>
                    <th>Error</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>405</td>
                    <td>Only POST requests are allowed</td>
                    <td>The request method is not POST</td>
                </tr>
                <tr>
                    <td>400</td>
                    <td>Both 'email' and 'password' fields are required</td>
                    <td>Missing required fields</td>
                </tr>
                <tr>
                    <td>400</td>
                    <td>This is not a mail</td>
                    <td>The provided email is not valid</td>
                </tr>
                <tr>
                    <td>400</td>
                    <td>At least 6 symbols required</td>
                    <td>Password is too short</td>
                </tr>
                <tr>
                    <td>500</td>
                    <td>Failed to create user</td>
                    <td>Database error</td>
                </tr>
            </tbody>
        </table>

        <h2>Example</h2>
        <h3>Request</h3>
        <pre>{
    "email": "example@mail.com",
    "password": "securepassword"
}</pre>

        <h3>Response</h3>
        <pre>{"message": "success"}</pre>
    </div>
    <footer>
        <p>&copy; 2024 User Registration API</p>
    </footer>
</body>
</html>