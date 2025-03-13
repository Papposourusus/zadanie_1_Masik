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
    </div>';
}
?>
