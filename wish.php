<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
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
        .wish-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .wish {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .wish:last-child {
            border-bottom: none;
        }
        .wish h2 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        .wish p {
            margin: 5px 0;
            color: #555;
        }
        .wish img {
            max-width: 100px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
        }
        .pagination button {
            margin: 0 5px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .pagination button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            if (!sessionStorage.getItem('user_id') || !sessionStorage.getItem('email') || !sessionStorage.getItem('login_key')) {
               window.location.href = 'index.php';
                return;
            }

            const loginKey = sessionStorage.getItem('login_key');
            const apiUrl = `/api/getMyWish.php?login_key=${loginKey}`;
            const itemsPerPage = 5;
            let currentPage = 1;
            let wishes = [];

            function fetchWishes() {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        wishes = data.filter(wish => wish.visibility !== false);
                        renderWishes();
                    })
                    .catch(error => console.error('Error fetching wishes:', error));
            }

            async function fetchLinkPreview(link) {
                try {
                    const response = await fetch(`https://api.linkpreview.net/?key=cbb5529a69f2f4ad950b8a1e416ec326&q=${link}`);
                    if (!response.ok) return null;
                    return await response.json();
                } catch {
                    return null;
                }
            }

            function renderWishes() {
                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageWishes = wishes.slice(start, end);

                const container = document.querySelector('.wish-container');
                container.innerHTML = '';

                pageWishes.forEach(async wish => {
                    const wishElement = document.createElement('div');
                    wishElement.classList.add('wish');

                    const linkPreview = wish.link ? await fetchLinkPreview(wish.link) : null;

                    wishElement.innerHTML = `
                        ${linkPreview?.image ? `<img src="${linkPreview.image}" alt="${linkPreview.title}" />` : ''}
                        <h2>${wish.name}</h2>
                        <p>${wish.desc}</p>
                        <p>Price: ${wish.price}</p>
                        ${wish.link ? `<p><a href="${wish.link}" target="_blank">View Product</a></p>` : ''}
                        ${wish.jar ? `<p><a href="https://${wish.jar}" target="_blank">Contribute to Jar</a></p>` : ''}
                        <p>Priority: ${wish.priority}</p>
                        <p>Created At: ${wish.created_at}</p>
                    `;

                    container.appendChild(wishElement);
                });

                renderPagination();
            }

            function renderPagination() {
                const totalPages = Math.ceil(wishes.length / itemsPerPage);
                const paginationContainer = document.querySelector('.pagination');
                paginationContainer.innerHTML = '';

                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    currentPage--;
                    renderWishes();
                });
                paginationContainer.appendChild(prevButton);

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    currentPage++;
                    renderWishes();
                });
                paginationContainer.appendChild(nextButton);
            }

            fetchWishes();
        });
    </script>
</head>
<body>
    <header>
        <a href="index.php">Home</a>
    </header>
    <div class="wish-container">
        <!-- Wishes will be loaded here -->
    </div>
    <div class="pagination">
        <!-- Pagination controls will be loaded here -->
    </div>
</body>
</html>