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
    

    $directory = __DIR__ . "/hiring-list";

    if (!is_dir($directory)) mkdir($directory, 0755, true);

    $filename = $directory . "/message-" . date("Y-m-d-H") . "-" . uniqid() . ".msg";
    
    $content = json_encode($_POST);

    file_put_contents($filename, $content);
    
?>

<html>
    <head>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/send.css">
    </head>
    <body>
        <main>
            <h1> Méssage envoyé ! </h1>
            <a href="/"> Ok </a>
        </main>
    </body>
</html>