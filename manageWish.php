<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Wish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .wish-card {
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .wish-card:hover {
            transform: translateY(-5px);
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            text-align: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .link-preview img {
            max-width: 100%;
            border-radius: 8px;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>

</head>
    <header>
        <a href="index.php">Home</a>
    </header>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">My Wishes</h1>
        <div id="wish-container" class="row gy-4">
            <!-- Wishes will be rendered here -->
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4" id="pagination">
                <!-- Pagination buttons dynamically rendered here -->
            </ul>
        </nav>
    </div>

    <script>
        const loginKey = sessionStorage.getItem('login_key');
        const wishesPerPage = 6;
        let currentPage = 1;
        let wishes = [];

        async function checkLoginStatus() {
            const email = sessionStorage.getItem('email');
            const userId = sessionStorage.getItem('user_id');
            if (!email || !loginKey || !userId) {
                redirectToIndex();
                return;
            }
            const response = await fetch(`/api/isLogIn.php?login_key=${loginKey}`);
            const data = await response.json();
            if (!data.is_loged_in) redirectToIndex();
        }

        function redirectToIndex() {
            window.location.href = 'index.php';
        }

        async function fetchWishes() {
            const response = await fetch(`/api/getMyWish.php?login_key=${loginKey}`);
            const data = await response.json();
            wishes = data.sort((a, b) => b.id - a.id);
            renderWishes();
        }

        function renderWishes() {
            const start = (currentPage - 1) * wishesPerPage;
            const end = start + wishesPerPage;
            const paginatedWishes = wishes.slice(start, end);
            
            const container = document.getElementById('wish-container');
            container.innerHTML = '';

            paginatedWishes.forEach(wish => {
                const card = document.createElement('div');
                card.className = 'col-md-6 col-lg-4';
                card.innerHTML = `
                    <div class="card wish-card p-3">
                        <h5 class="card-title text-primary">${wish.name}</h5>
                        <p class="card-text text-muted">${wish.desc || 'No description'}</p>    
                        <p><strong>Price:</strong> $${wish.price}</p>
                        <p><strong>Priority:</strong>${wish.priority}</p>
                        <a href=${wish.link} target="_blank">Link</a>
                        <a href=https://${wish.jar} target="_blank">Jar</a>
                        <div class="link-preview" id="preview-${wish.id}"></div>
                        <button class="btn btn-danger mt-2" onclick="deleteWish(${wish.id})">Delete Wish</button>
                    </div>
                `;
                container.appendChild(card);
                fetchLinkPreview(wish.link, `preview-${wish.id}`);
            });
            renderPagination();
        }

        async function fetchLinkPreview(link, previewElementId) {
            try {
                const response = await fetch(`https://api.linkpreview.net/?key=558ffa06c4a3d9c9ccba040c6c7bbea3&q=${link}`);
                if (!response.ok) return;
                const data = await response.json();
                const preview = document.getElementById(previewElementId);
                if (data.image) {
                    preview.innerHTML = `<img src="${data.image}" alt="Link preview">`;
                }
            } catch (error) {
                console.error('Error fetching link preview', error);
            }
        }

        async function deleteWish(wishId) {
            try {
                const response = await fetch('/api/deleteMyWish.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        login_key: loginKey,
                        wish_id: wishId
                    })
                });
                if (response.ok) {
                    alert('Wish deleted successfully');
                    fetchWishes();
                } else {
                    const error = await response.json();
                    alert('Error deleting wish: ' + error.message);
                }
            } catch (error) {
                console.error('Error deleting wish:', error);
            }
        }

        function renderPagination() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const pageCount = Math.ceil(wishes.length / wishesPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const pageItem = document.createElement('li');
                pageItem.className = `page-item ${i === currentPage ? 'active' : ''}`;
                pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageItem.addEventListener('click', () => {
                    currentPage = i;
                    renderWishes();
                });
                pagination.appendChild(pageItem);
            }
        }

        window.onload = async () => {
            await checkLoginStatus();
            await fetchWishes();
        };
    </script>
</body>
</html>
