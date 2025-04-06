<?php

require_once("parts/header.php"); 
class QnA {
    private $pdo;

    // Konštruktor - pripojenie k databáze
    public function __construct($host, $dbname, $username, $password) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }

    // Pridanie mena, priezviska, emailu a komentára
    public function addComment($firstName, $lastName, $email, $comment) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO comments (first_name, last_name, email, comment) VALUES (:first_name, :last_name, :email, :comment)");
            $stmt->execute([
                ":first_name" => $firstName,
                ":last_name" => $lastName,
                ":email" => $email,
                ":comment" => $comment
            ]);
            echo "Komentár bol úspešne pridaný.";
        } catch (PDOException $e) {
            die("Chyba pri vkladaní komentára: " . $e->getMessage());
        }
    }

    // Načítanie komentárov z databázy
    public function getComments() {
        try {
            $stmt = $this->pdo->query("SELECT first_name, last_name, email, comment, created_at FROM comments ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Chyba pri získavaní komentárov: " . $e->getMessage());
        }
    }
}

// Pripojenie k databáze
$qna = new QnA("localhost", "comments_db", "root", "");

// Spracovanie formulára na pridanie komentára
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $qna->addComment($firstName, $lastName, $email, $comment);
}

// Načítanie komentárov
$comments = $qna->getComments();
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentáre</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Komentáre</h1>
    
    <!-- Formulár -->
    <form method="POST">
        <label for="first_name">Meno:</label>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Priezvisko:</label>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="comment">Komentár:</label>
        <textarea id="comment" name="comment" required></textarea><br>

        <button type="submit">Odoslať</button>
    </form>

    <!-- Zobrazenie komentárov -->
    <div class="comments-container">
        <?php foreach ($comments as $c): ?>
            <div>
                <p><strong>Meno:</strong> <?= htmlspecialchars($c["first_name"]) ?> <?= htmlspecialchars($c["last_name"]) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($c["email"]) ?></p>
                <p><strong>Komentár:</strong> <?= htmlspecialchars($c["comment"]) ?></p>
                <p><em>Pridané:</em> <?= $c["created_at"] ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>



    <?php 
    require_once("parts/footer.php"); 
    ?>
</body>
</html>