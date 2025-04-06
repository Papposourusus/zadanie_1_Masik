<?php
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

    // Pridanie otázky a odpovede s kontrolou duplikátov
    public function addQuestionAnswer($question, $answer) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM questions_answers WHERE question = :question AND answer = :answer");
            $stmt->execute([
                ":question" => $question,
                ":answer" => $answer
            ]);
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                // Ak záznam neexistuje, vložte ho do databázy
                $stmt = $this->pdo->prepare("INSERT INTO questions_answers (question, answer) VALUES (:question, :answer)");
                $stmt->execute([
                    ":question" => $question,
                    ":answer" => $answer
                ]);
                echo "Otázka a odpoveď boli úspešne pridané.";
            } else {
                echo "Táto otázka a odpoveď už existujú v databáze.";
            }
        } catch (PDOException $e) {
            die("Chyba pri vkladaní otázky a odpovede: " . $e->getMessage());
        }
    }

    // Načítanie otázok a odpovedí z databázy
    public function getQuestionsAndAnswers() {
        try {
            $stmt = $this->pdo->query("SELECT question, answer FROM questions_answers");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Chyba pri získavaní otázok a odpovedí: " . $e->getMessage());
        }
    }
}

// Pripojenie k databáze
$qna = new QnA("localhost", "qna_db", "root", "");

// Spracovanie formulára na pridanie otázky a odpovede
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $qna->addQuestionAnswer($question, $answer);
}

// Načítanie otázok a odpovedí
$questionsAndAnswers = $qna->getQuestionsAndAnswers();
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otázky a odpovede</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Otázky a odpovede</h1>
    
    <!-- Formulár -->
    <form method="POST">
        <label for="question">Otázka:</label>
        <textarea id="question" name="question" required></textarea><br>
        <label for="answer">Odpoveď:</label>
        <textarea id="answer" name="answer" required></textarea><br>
        <button type="submit">Pridať</button>
    </form>

    <!-- Zobrazenie otázok a odpovedí -->
    <div class="questions-container">
        <?php foreach ($questionsAndAnswers as $qa): ?>
            <div>
                <p><strong>Otázka:</strong> <?= htmlspecialchars($qa['question']) ?></p>
                <p><strong>Odpoveď:</strong> <?= htmlspecialchars($qa['answer']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
?>