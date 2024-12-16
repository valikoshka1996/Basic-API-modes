<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Get Product Description</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #28a745;
            color: white;
            padding: 20px 10px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #28a745;
        }
        code {
            background-color: #f4f4f4;
            padding: 2px 5px;
            border-radius: 3px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .example {
            background: #e9f7df;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>API Documentation - Get Product Description</h1>
    </header>
    <div class="container">
        <h2>Endpoint</h2>
        <p><strong>URL:</strong> <code>/parseEngine/getDescription.php</code></p>
        <p><strong>Method:</strong> <code>POST</code></p>

        <h2>Description</h2>
        <p>This endpoint accepts a URL of a product page and returns the description of the product. It analyzes the HTML content of the page without using third-party APIs.</p>

        <h2>Request</h2>
        <h3>Headers</h3>
        <ul>
            <li><strong>Content-Type:</strong> <code>application/json</code></li>
        </ul>
        <h3>Body Parameters</h3>
        <table border="1" cellpadding="5" cellspacing="0">
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
                    <td><code>url</code></td>
                    <td>string</td>
                    <td>Yes</td>
                    <td>The URL of the product page to analyze.</td>
                </tr>
            </tbody>
        </table>

        <h3>Example Request</h3>
        <pre><code>{
    "url": "https://example.com/product-page"
}</code></pre>

        <h2>Response</h2>
        <h3>Success</h3>
        <p>On success, the endpoint returns a JSON object containing the product description.</p>
        <pre class="example"><code>{
    "description": "This is an amazing product that provides great value."
}</code></pre>

        <h3>Errors</h3>
        <p>Possible error responses:</p>
        <ul>
            <li><strong>405 Method Not Allowed:</strong> Returned when the request method is not POST.</li>
            <li><strong>400 Bad Request:</strong> Returned when the <code>url</code> parameter is missing or invalid.</li>
            <li><strong>404 Not Found:</strong> Returned when the page cannot be fetched or no suitable description is found.</li>
        </ul>
        <pre class="error"><code>{
    "error": "Invalid or missing URL."
}</code></pre>
        <pre class="error"><code>{
    "error": "No description found on the page."
}</code></pre>

        <h2>Notes</h2>
        <ul>
            <li>The URL must be a valid and reachable web address.</li>
            <li>If the page uses dynamic content (e.g., JavaScript-rendered descriptions), this endpoint may not work as expected.</li>
        </ul>
    </div>
</body>
</html>
