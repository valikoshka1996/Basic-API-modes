<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getUserData</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; line-height: 1.6; }
        h1, h2 { color: #333; }
        pre { background-color: #f4f4f4; padding: 1rem; border: 1px solid #ddd; }
        code { color: #d63384; }
        .section { margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <h1>API Documentation: getUserData</h1>

    <div class="section">
        <h2>Endpoint</h2>
        <p><strong>URL:</strong> <code>/api/userdata/getUserData</code></p>
        <p><strong>Method:</strong> <code>GET</code></p>
        <p><strong>Response Format:</strong> <code>application/json</code></p>
    </div>

    <div class="section">
        <h2>Request Parameters</h2>
        <ul>
            <li><strong>login_key</strong> (string, required) - Authorization key for the user.</li>
            <li><strong>data</strong> (string, optional) - Comma-separated fields to retrieve. Allowed values:
                <code>name, surname, birth_date, sex, about, adress</code>.
            </li>
        </ul>
    </div>

    <div class="section">
        <h2>Response Examples</h2>

        <h3>Success - All Data</h3>
        <pre><code>{
    "name": "John",
    "surname": "Doe",
    "birth_date": "1990-01-01",
    "sex": "male",
    "about": "Car enthusiast.",
    "adress": "123 Main St."
}</code></pre>

        <h3>Success - Specific Fields</h3>
        <pre><code>{
    "name": "John",
    "surname": "Doe"
}</code></pre>

        <h3>Error - Missing login_key</h3>
        <pre><code>{
    "error": "login_key is required"
}</code></pre>

        <h3>Error - Unauthorized</h3>
        <pre><code>{
    "error": "User does not authorized"
}</code></pre>

        <h3>Error - Invalid Data Parameter</h3>
        <pre><code>{
    "error": "no parameter 'invalid_param' for data"
}</code></pre>

        <h3>Success - No Data</h3>
        <pre><code>{
    "message": "no data"
}</code></pre>
    </div>

    <div class="section">
        <h2>Example Request</h2>
        <p><strong>URL:</strong></p>
        <pre><code>/api/userdata/getUserData?login_key=12345ABCDE&data=name,surname</code></pre>
    </div>
</body>
</html>
