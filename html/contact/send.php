<?php
    if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
        http_response_code(405);
        exit("method not allowed");
    }
    
    try {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"] ?? null;
        $message = $_POST["message"];
    } catch (Throwable $th) {
        exit("missing form informations");
    }
    
    $directory = "/home/kebab/support-agent/pending"; // this folders exists

    $filename = $directory . "/message-" . date("Y-m-d-H") . "-" . uniqid() . ".msg";
    
    $content = json_encode($_POST, JSON_THROW_ON_ERROR);

    if (file_put_contents($filename, $content, LOCK_EX) === false) {
        http_response_code(500);
        exit("could not save message");
    }
    
?>

<html>
    <head>
        <link rel="stylesheet" href="/css/global.css">
        <link rel="stylesheet" href="/css/send.css">
    </head>
    <body>
        <main>
            <h1> Méssage envoyé ! </h1>
            <a href="/"> Ok </a>
        </main>
    </body>
</html>