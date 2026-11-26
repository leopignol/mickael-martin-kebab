<?php
    if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
        http_response_code(405);
        exit("method not allowed");
    }
    
    try {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $phone = $_POST["address"];
        $message = $_POST["card_number"];
        $message = $_POST["card_expiry"];
        $message = $_POST["card_cvc"];
        $message = $_POST["message"];
    } catch (Throwable $th) {
        exit("missing form informations");
    }
    

    $directory = "/home/kebab/hiring-messages";

    if (!is_dir($directory)) mkdir($directory, 0755, true);

    $filename = $directory . "/message-" . date("Y-m-d-H") . "-" . uniqid() . ".msg";
    
    $content = json_encode($_POST);

    file_put_contents($filename, $content);
    
?>

<html>
    <head>
        <script src="/js/layout.js" defer></script>
        <link rel="stylesheet" href="/css/send.css">
        <link rel="stylesheet" href="/css/global.css">
    </head>
    <body>
        <site-header></site-header>
        <main id="content">
            <h1> Méssage envoyé ! </h1>
            <a href="/" class="ok-link"> Ok </a>
        </main>
        <site-footer></site-footer>
        <script src="/js/theme-changer.js"></script>
    </body>
</html>