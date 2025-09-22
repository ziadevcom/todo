<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.violet.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Doto:wght@100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --pico-font-family: 'Doto', monospace;
        }

        @media (min-width: 1536px) {
            .container {
                max-width: 1200px;
            }
        }

        header {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        header nav {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        main {
            min-height: 500px;
        }
    </style>
    <title><?= $title ?? 'Tasks' ?></title>
</head>

<body>

    <body class="container">
        <header>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li> <a href="/tasks">Tasks</a></li>
                        <li> <a href="/create-task">Create Task</a></li>
                        <li>
                            <span></spanp>Logged in: <?= $_SESSION['user']['email'] ?></span>
                        </li>
                        <li> <a href="/logout">Logout</a></li>
                    <?php else: ?>
                        <li> <a href="/sign-up">Sign up</a></li>
                        <li> <a href="/login">Log in</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </header>

        <main class="body">