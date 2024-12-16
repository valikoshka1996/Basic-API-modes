<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - getProductName</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">API Documentation</h1>
        <h2 class="mt-4">Endpoint: <code>/parseEngine/getProductName.php</code></h2>

        <section class="mt-4">
            <h3>Description</h3>
            <p>The <code>getProductName</code> endpoint extracts the product name from a given URL. It processes the page content and searches for common patterns like <code>&lt;h1&gt;</code> tags, <code>meta</code> tags, and other relevant elements.</p>
        </section>

        <section class="mt-4">
            <h3>HTTP Method</h3>
            <p><strong>POST</strong></p>
        </section>

        <section class="mt-4">
            <h3>Request Body</h3>
            <p>The request body should be in JSON format and must include the following parameter:</p>
            <pre><code>{
    "url": "string (required) - The URL of the page to parse."
}</code></pre>
        </section>

        <section class="mt-4">
            <h3>Responses</h3>
            <p>The API returns the following responses:</p>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Status Code</th>
                        <th>Description</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>200</td>
                        <td>Success. The product name was found.</td>
                        <td>
                            <pre><code>{
    "name": "Example Product Name"
}</code></pre>
                        </td>
                    </tr>
                    <tr>
                        <td>400</td>
                        <td>Bad Request. The URL parameter is missing or invalid.</td>
                        <td>
                            <pre><code>{
    "error": "Invalid or missing URL."
}</code></pre>
                        </td>
                    </tr>
                    <tr>
                        <td>404</td>
                        <td>Not Found. The product name could not be extracted from the page.</td>
                        <td>
                            <pre><code>{
    "error": "Product name not found."
}</code></pre>
                        </td>
                    </tr>
                    <tr>
                        <td>405</td>
                        <td>Method Not Allowed. The endpoint only supports POST requests.</td>
                        <td>
                            <pre><code>{
    "error": "Method not allowed. Only POST requests are supported."
}</code></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="mt-4">
            <h3>Example Request</h3>
            <pre><code>POST /parseEngine/getProductName.php HTTP/1.1
Host: example.com
Content-Type: application/json

{
    "url": "https://example.com/product-page"
}</code></pre>
        </section>

        <section class="mt-4">
            <h3>Notes</h3>
            <ul>
                <li>The URL must be publicly accessible and return valid HTML content.</li>
                <li>The endpoint attempts to filter out generic phrases like "buy", "discount", or site slogans from the product name.</li>
                <li>If no relevant content is found, the API will return a 404 status code.</li>
            </ul>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
