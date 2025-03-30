<?php
function loadBanner($jsonFile) {
    if (!file_exists($jsonFile)) {
        return "<p>Banner neexistuje.</p>";
    }

    $data = json_decode(file_get_contents($jsonFile), true);

    if (!$data) {
        return "<p>Tak to ti nepojde</p>";
    }

    $imageData = $data["image"];
    $imageSrc = htmlspecialchars($imageData["src"]);
    $imageWidth = htmlspecialchars($imageData["width"]);
    $imageHeight = htmlspecialchars($imageData["height"]);
    $title = htmlspecialchars($data["title"]);
    $subtitle = htmlspecialchars($data["subtitle"]);
    $url = htmlspecialchars($data["url"]);

    return '
    <div class="banner">
        <a href="' . $url . '" target="_blank">
            <img src="' . $imageSrc . '" width="' . $imageWidth . '" height="' . $imageHeight . '" alt="Banner">
        </a>
        <h1>' . $title . '</h1>
        <p>' . $subtitle . '</p>
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
