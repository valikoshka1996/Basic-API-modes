<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Wish</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .navbar {
            background-color: #6C63FF;
        }
        .navbar a, .navbar span {
            color: #fff;
            font-weight: 500;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .btn-primary {
            background-color: #6C63FF;
            border: none;
        }
        .btn-primary:hover {
            background-color: #574bff;
        }
        textarea {
            resize: none;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Create Wish</a>
            <div class="ms-auto">
                <span id="user-email"></span>
                <a href="index.php" class="btn btn-light btn-sm ms-3">Home</a>
            </div>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="container">
        <div class="form-container">
            <h3 class="mb-4">Create Your Wish</h3>
            <form id="wishForm">
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter the item name" required>
                </div>
                <!-- Price -->
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" placeholder="Enter the price">
                </div>
                <!-- Link -->
                <div class="mb-3">
                    <label for="link" class="form-label">Link</label>
                    <input type="url" class="form-control" id="link" placeholder="Enter product link">
                    <div class="error-message" id="link-error"></div>
                </div>
                <!-- Jar -->
                <div class="mb-3">
                    <label for="jar" class="form-label">Monobank Jar</label>
                    <input type="url" class="form-control" id="jar" placeholder="send.monobank.ua/jar/...">
                    <div class="error-message" id="jar-error"></div>
                </div>
                <!-- Priority -->
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" id="priority">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <!-- Visibility -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="visibility" checked>
                    <label for="visibility" class="form-check-label">Visibility</label>
                </div>
                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter description"></textarea>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Create Wish</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Check if user is logged in
        const session = {
            email: sessionStorage.getItem('email'),
            login_key: sessionStorage.getItem('login_key'),
            user_id: sessionStorage.getItem('user_id')
        };

        async function checkLogin() {
            if (!session.login_key) {
                window.location.href = 'index.php';
            } else {
                const response = await fetch(`/api/isLogIn.php?login_key=${session.login_key}`);
                const data = await response.json();
                if (!data.is_loged_in) {
                    window.location.href = 'index.php';
                } else {
                    document.getElementById('user-email').innerText = session.email;
                }
            }
        }
        checkLogin();

        // Link Parsing
        document.getElementById('link').addEventListener('blur', async function () {
            const link = this.value;
            const urlRegex = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
            if (link && urlRegex.test(link)) {
                document.getElementById('link-error').innerText = '';
                // Simulated parsing
                document.getElementById('description').value = 'Parsed description for ' + link;
            } else {
                document.getElementById('link-error').innerText = 'Invalid URL format';
            }
        });

        // Form Submission
        document.getElementById('wishForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = {
                login_key: session.login_key,
                name: document.getElementById('name').value,
                price: document.getElementById('price').value || null,
                link: document.getElementById('link').value || null,
                jar: document.getElementById('jar').value || null,
                priority: document.getElementById('priority').value,
                visibility: document.getElementById('visibility').checked ? true : false,
                desc: document.getElementById('description').value || null
            };
            const response = await fetch('/api/createWish.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            const result = await response.json();
            if (result.success) {
                window.location.href = 'wish.php';
            } else {
                alert('Error: ' + result.error);
            }
        });
    </script>
</body>
</html>
