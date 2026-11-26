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
		<script src="/js/layout.js" defer></script>
		<title>Mickaël Martin Kebab – Message Envoyé</title>
		<meta charset="utf-8">
		<meta name="description" content="Mickaël Martin Kebab – Envoi">
		<meta name="keywords"
		      content="mickael, martin, kebab, mickael-martin, formation, kebabier, maitre"
		>
		<meta name="application-name" content="Mickaël Martin Kebab">
		<meta name="subject"
		      content="Mickaël Martin Kebab – Formations maître kebabiers – Envoi"
		>
		<meta name="language" content="FR">
		<meta name="summary"
		      content="Mickaël Martin Kebab – Formations maître kebabiers"
		>
		<meta name="classification" content="Business">
		<meta name="author" content="LIAUTAUD Loevan, PIGNOL Léo, VINAS Lian">
		<meta name="designer" content="VINAS Lian">
		<meta name="reply-to" content="mickael-martin-kebab@mailo.com">
		<meta name="owner" content="Mickaël Martin">
		<meta name="url" content="https://mickael-martin-kebab.site">
		<meta name="distribution" content="Global">
		<meta name="rating" content="General">
		<meta name="subtitle" content="Formations maître kebabier">
		<meta name="target" content="all">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/css/global.css">
		<link rel="stylesheet" href="/css/fonts.css">
		<link rel="stylesheet" href="/css/send.css">
		<link rel="icon" href="/img/icons/favicon.svg" type="image/svg+xml">
		<link rel="apple-touch-icon" href="/img/icons/apple-touch-icon.png">
	</head>
	<body>
		<site-header></site-header>
		<main id="content">
			<h1>Message envoyé&nbsp;!</h1>
			<a class="ok-link" href="/">Ok</a>
		</main>
		<site-footer></site-footer>
		<script src="/js/theme-changer.js"></script>
	</body>
</html>
