<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title><?= $title ?? 'Mi sitio web' ?></title>
</head>
<body>

    <div class="mb-4">
        <?php require __DIR__ . '/navbar.php'; ?>
    </div>

    <div class="container mx-auto px-4 py-8">