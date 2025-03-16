<?php
function loadBanner($jsonFile) {
    if (!file_exists($jsonFile)) {
        return "<p>Banner data not found.</p>";
    }

    $data = json_decode(file_get_contents($jsonFile), true);

    if (!$data) {
        return "<p>Invalid banner data.</p>";
    }

    return '
    <div class="banner">
        <img src="' . htmlspecialchars($data["image"]) . '" alt="Banner">
        <h1>' . htmlspecialchars($data["title"]) . '</h1>
        <p>' . htmlspecialchars($data["subtitle"]) . '</p>
        <strong>' . htmlspecialchars($data["message"]) . '</strong> <!-- Nový nápis -->
    </div>';
}
?>


<?php
function loadFAQ($jsonFile) {
    if (!file_exists($jsonFile)) {
        return "<p>Nenje</p>";
    }

    $data = json_decode(file_get_contents($jsonFile), true);

    if (!$data || !isset($data["questions"])) {
        return "<p>To ti nepojde</p>";
    }

    $output = '<div class="faq-section"><h2>Často kladené otázky</h2><ul>';

    foreach ($data["questions"] as $qa) {
        $output .= '<li><strong>' . htmlspecialchars($qa["question"]) . '</strong><br>' . 
                    htmlspecialchars($qa["answer"]) . '</li>';
    }

    $output .= '</ul></div>';
    return $output;
}
?>
