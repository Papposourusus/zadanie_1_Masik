<?php
class QnA {
    private $pdo;

    // Constructor - Pripojenie k databáze
    public function __construct($host, $dbname, $username, $password) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }

    // Metóda na čítanie otázok a odpovedí
    public function getQuestionsAndAnswers() {
        try {
            $stmt = $this->pdo->query("SELECT question, answer FROM questions_answers");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Chyba pri získavaní otázok a odpovedí: " . $e->getMessage());
        }
    }
}

// Príklad použitia
try {
    $qna = new QnA("localhost", "qna_db", "root", ""); // Použite správne prihlasovacie údaje pre XAMPP
    $questionsAndAnswers = $qna->getQuestionsAndAnswers();

    foreach ($questionsAndAnswers as $qa) {
        echo "<strong>Otázka:</strong> " . htmlspecialchars($qa['question']) . "<br>";
        echo "<strong>Odpoveď:</strong> " . htmlspecialchars($qa['answer']) . "<br><br>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<body>
<?php 
    require_once("parts/header.php"); // Bez @, ak chýba, zobrazí chybu
    ?>
</body>    