<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Include your CSS -->
    <style>
        /* Root Variables for Styling */
        :root {
            --primary-color: rgb(250, 250, 250);
            --accent-color: rgb(187, 5, 5);
            --text-color-light: #fff;
            --font-family: 'Poppins', Arial, sans-serif;
            --border-radius: 12px;
            --shadow-md: 0px 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Reset Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: var(--font-family);
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: var(--text-color-light);
            height: 100%;
            overflow: hidden;
        }

        /* Full-Screen Centering */
        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full screen height */
            text-align: center;
            padding: 20px;
        }

        .box {
            padding: 40px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
        }

        .box h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .box p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .box a {
            text-decoration: none;
            background: var(--accent-color);
            color: var(--text-color-light);
            padding: 0.75rem 2rem;
            font-size: 1.25rem;
            font-weight: 600;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .box a:hover {
          background: linear-gradient(135deg,rgb(0, 0, 0),rgb(128, 10, 6));
            transform: scale(1.05);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .box h1 {
                font-size: 2rem;
            }

            .box p {
                font-size: 1rem;
            }

            .box a {
                font-size: 1rem;
                padding: 0.6rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Full-Screen Hero Section -->
    <div class="content">
        <div class="box">
            <h1>Welcome to Alloy SwingArm!</h1>
            <p>Login or Register now to start your shopping.</p>
            <a href="{{ route('login') }}">Get Started</a>
        </div>
    </div>
</body>
</html>