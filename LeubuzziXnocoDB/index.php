<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Parsedown
require 'vendor/autoload.php'; // If you installed using Composer
// Or manually include Parsedown if you downloaded it
// require 'path/to/Parsedown.php';

// Initialize Parsedown
$Parsedown = new Parsedown();

// Connection to the SQLite database
try {
    $db = new PDO('sqlite:database.db'); // Adjust the path as needed
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Fetch posts from the database
try {
    $query = $db->query("SELECT * FROM posts WHERE Publikacja = 1");
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if data is available
    if (empty($posts)) {
        echo "No data available.";
        exit;
    }
} catch (PDOException $e) {
    echo "Database query failed: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posty List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Posty List</h1>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Tytuł</th>
                <th>Treść</th>
                <th>Obrazek</th>
                <th>Kategoria</th>
                <th>Publikacja</th>
                <th>Data utworzenia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['Id']); ?></td>
                    <td><?php echo htmlspecialchars($post['Tytul'] ?? ''); ?></td>
                    <td><?php echo $Parsedown->text($post['Tresc'] ?? ''); ?></td>
                    <td>
                        <?php if (!empty($post['Obrazek'])): ?>
                            <img src="<?php echo htmlspecialchars($post['Obrazek']); ?>" alt="Image" style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($post['Kategoria'] ?? ''); ?></td>
                    <td><?php echo $post['Publikacja'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo htmlspecialchars($post['Data_utworzenia'] ?? ''); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
