<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Sidebar | Bootstrap</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #1e1e2f;
            transition: width 0.3s ease;
        }

        .sidebar .nav-link {
            color: #b0b0b0;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #3a3a5a;
            color: #ffffff;
        }

        .sidebar .nav-header {
            color: #a0a0a0;
            text-transform: uppercase;
            font-size: 14px;
            margin: 20px 0 10px 15px;
        }

        .toggle-menu {
            position: absolute;
            top: 20px;
            right: -30px;
            background-color: #1e1e2f;
            border: 1px solid #3a3a5a;
            color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .toggle-menu:hover {
            background: #3a3a5a;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .sidebar.active {
                width: 200px;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .sidebar.active .nav-link span {
                display: inline;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar" id="sidebar">
            <div class="text-center my-4">
                <i class="bx bx-cube-alt" style="font-size: 2.5rem;"></i>
            </div>
            <div class="nav flex-column">
                <h6 class="nav-header">Menu</h6>
                <a class="nav-link active" href="#">
                    <i class="bx bx-home-smile"></i>
                    <span>Home</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-bar-chart-alt-2"></i>
                    <span>Products</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-message-square-dots"></i>
                    <span>Reports</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-bookmarks"></i>
                    <span>Orders</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-bell"></i>
                    <span>Notification</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-cog"></i>
                    <span>Setting</span>
                </a>

                <h6 class="nav-header">Shortcuts</h6>
                <a class="nav-link" href="#">
                    <i class="bx bx-add-to-queue"></i>
                    <span>Add</span>
                </a>
                <a class="nav-link" href="#">
                    <i class="bx bx-message-square-minus"></i>
                    <span>Remove</span>
                </a>
            </div>
            <div class="nav-link logout" style="cursor: pointer;">
                <i class="bx bx-log-out"></i>
                <span>Logout</span>
            </div>
            <div class="toggle-menu" id="toggle-button">
                <i class="bx bxs-right-arrow"></i>
                <i class="bx bxs-left-arrow" style="display: none;"></i>
            </div>
        </nav>

        <div class="content p-4">
            <h1>Main Content Area</h1>
            <p>This is where your main content will go. You can add any additional elements or components here as needed.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const toggleButton = document.getElementById("toggle-button");
        const sidebar = document.getElementById("sidebar");

        const openIcon = toggleButton.querySelector(".bxs-right-arrow");
        const closeIcon = toggleButton.querySelector(".bxs-left-arrow");

        toggleButton.addEventListener("click", () => {
            sidebar.classList.toggle("active");

            if (sidebar.classList.contains("active")) {
                openIcon.style.display = "none";
                closeIcon.style.display = "block";
            } else {
                openIcon.style.display = "block";
                closeIcon.style.display = "none";
            }
        });
    </script>
</body>
</html>