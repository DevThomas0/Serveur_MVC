<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? htmlspecialchars($title) : 'App' ?></title>
    <style>
        :root {
            --bg: #f6f7fb;
            --primary: #2563eb;
            --text: #1f2937;
            --card: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        header {
            background: var(--primary);
            color: #fff;
            padding: 1rem 1.5rem;
        }

        nav {
            background: #1e2a3a;
        }

        nav ul {
            display: flex;
            gap: 1rem;
            margin: 0;
            padding: 0.75rem 1.5rem;
            list-style: none;
        }

        nav a {
            color: #e5e7eb;
            text-decoration: none;
            font-weight: 600;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 960px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
        }

        form div {
            margin-bottom: 0.75rem;
        }

        input,
        button {
            font-size: 1rem;
        }

        input {
            width: 100%;
            padding: 0.5rem 0.6rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        button {
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        .hero {
            padding: 1rem 1.25rem;
            background: #e0e7ff;
            border: 1px solid #c7d2fe;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="/add">Ajouter un produit</a></li>
            <li><a href="/panier">Panier</a></li>
            <li><a href="/commandes">Mes commandes</a></li>
            <?php if (!empty($auth)): ?>
                <li><a href="/logout">Déconnexion (<?= htmlspecialchars($auth['email']) ?>)</a></li>
            <?php else: ?>
                <li><a href="/login">Connexion</a></li>
                <li><a href="/register">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <header class="flex-between">
        <h1 style="margin-left:1.5rem;"><?= isset($title) ? htmlspecialchars($title) : 'App' ?></h1>
    </header>
    <main class="container">
        <?= $content ?>

    </main>



</body>

</html>