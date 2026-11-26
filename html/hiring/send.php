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
  	<title>Mickaël Martin Kebab – Page Name</title>
  	<meta charset="utf-8">
  	<meta name="description" content="Mickaël Martin Kebab">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="/css/global.css">
  	<link rel="stylesheet" href="/css/<page-name>.css">
  	<link rel="icon" href="/img/icons/favicon.svg" type="image/svg+xml">
  	<link rel="apple-touch-icon" href="/img/icons/apple-touch-icon.png">
  </head>
	<body>
  	<main>
  		<h1>Message envoyé&nbsp;!</h1>
  		<a href="/">Ok</a>
  	</main>
	</body>
</html>
