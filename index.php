<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop eCommerce HTML CSS Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
</head>

<body>

    <?php 
    require_once("functions.php"); // Funkcie načítame ako prvé
    require_once("parts/header.php"); // Bez @, ak chýba, zobrazí chybu
    ?>

    <main>
        <?php echo loadBanner("data.json"); ?> 
        <?php echo loadFAQ("data.json"); ?>

        <section>
            <h1>Vitaj</h1>
            <p>TEST SLOva ajtaJAJJJ.</p>
        </section>
    </main>

    <?php 
    require_once("parts/footer.php"); 
    ?>

</body>
</html>
