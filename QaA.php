<?php
$host = "localhost";
$dbname = "comments_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba pripojenia k databáze: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $comment = htmlspecialchars($_POST["comment"]);

    if (!empty($name) && !empty($email) && !empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comments (name, email, comment) VALUES (:name, :email, :comment)");
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":comment" => $comment
        ]);
    }
}

$comments = $pdo->query("SELECT name, email, comment, created_at FROM comments ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulár a komentáre</title>
</head>
<body>
<?php 
    require_once("parts/header.php"); 
    ?>
    <!-- Formulár -->
    <h1>Pridajte komentár</h1>
    <form method="POST" action="">
        <label for="name">Meno:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="comment">Komentár:</label>
        <textarea id="comment" name="comment" required></textarea><br>

        <button type="submit">Odoslať</button>
    </form>

    <!-- Zobrazenie komentárov -->
    <h2>Komentáre</h2>
    <?php foreach ($comments as $c): ?>
        <div>
            <p><strong>Meno:</strong> <?= htmlspecialchars($c["name"]) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($c["email"]) ?></p>
            <p><strong>Komentár:</strong> <?= htmlspecialchars($c["comment"]) ?></p>
            <p><em>Pridané:</em> <?= $c["created_at"] ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
   