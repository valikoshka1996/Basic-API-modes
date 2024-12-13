<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Billy Herrington Fan Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        nav {
            background-color: #6200ea;
        }
        nav a {
            color: #fff;
            font-weight: bold;
        }
        .hero {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #e3f2fd;
            border-radius: 8px;
        }
        .hero img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 2.5rem;
            color: #6200ea;
        }
        .hero p {
            font-size: 1.2rem;
            color: #555;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            background-color: #6200ea;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.getElementById('logoutButton');

            if (logoutButton) {
                logoutButton.addEventListener('click', async () => {
                    const response = await fetch('/api/userLogout.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            user_id: sessionStorage.getItem('user_id'),
                            login_key: sessionStorage.getItem('login_key')
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('You have successfully logged out.');
                        sessionStorage.clear();
                        window.location.reload();
                    } else {
                        alert(`Logout failed: ${result.message}`);
                    }
                });
            }
        });
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Fan Page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" id="loginMenu">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item" id="registerMenu">
                        <a class="nav-link" href="register.html">Register</a>
                    </li>
                    <li class="nav-item" id="dashboardMenu" style="display: none;">
                        <a class="nav-link" href="createWish.php">Create Wish</a>
                    </li>
                    <li class="nav-item" id="wishboardMenu" style="display: none;">
                        <a class="nav-link" href="manageWish.php">Wishboard</a>
                    </li>
                    <li class="nav-item" id="userEmailMenu" style="display: none;">
                        <span class="nav-link" id="userEmail"></span>
                    </li>
                    <li class="nav-item" id="logoutMenu" style="display: none;">
                        <button class="btn btn-outline-light" id="logoutButton">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container hero">
        <img src="bill1.jpg" alt="Billy Herrington">
        <h1>Welcome to Billy Herrington's Fan Page!</h1>
        <p>This site is dedicated to the legendary actor Billy Herrington for his outstanding achievements in acting.</p>
        <p>Just kidding! Actually, this is a simple implementation of a microservice API model website.</p>
        <p>Under the hood, this site hosts several API endpoints allowing interactions with this service, such as registration, login, and user authentication. Some methods require an API key, which can be obtained by contacting the site administrator!</p>
        <p>I implemented a small website using a microservice architecture where you can create your own wish list. The number of wishes is unlimited; for now, you can create</p>
        <p>and delete records, but nothing more. Everything was written manually without frameworks— I think it’s noticeable, as the styles look a bit different.</p>
        <p>API documentation is available at <a href="/apiDoc">this page</a>.</p>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Fan Page for Billy Herrington</p>
    </footer>

    <script>
        // Simulating session check
        const isLoggedIn = sessionStorage.getItem('email'); // Example for demonstration

        if (isLoggedIn) {
            document.getElementById('loginMenu').style.display = 'none';
            document.getElementById('registerMenu').style.display = 'none';
            document.getElementById('dashboardMenu').style.display = 'block';
            document.getElementById('wishboardMenu').style.display = 'block';
            document.getElementById('userEmailMenu').style.display = 'block';
            document.getElementById('logoutMenu').style.display = 'block';
            document.getElementById('userEmail').innerText = sessionStorage.getItem('email');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
