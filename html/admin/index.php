<?php
	session_start();
	if ( !isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
		header("Location: login.php");
		exit;
	}

	$username = $_SESSION['username'];
	$level = $_SESSION['level'];

	$pages = [
		'overview.php' => 'overview.php',
		'logs.php' => 'logs.php',
		'messages.php' => 'messages.php',
	];
	$requestedPage = $_GET['page'] ?? 'overview.php';

	if ($requestedPage === 'logout.php') {
		session_destroy();
		header('Location: login.php');
		exit;
	}

	if (!is_string($requestedPage) || !isset($pages[$requestedPage])) {
		http_response_code(404);
		exit('Page not found.');
	}

	$page = $pages[$requestedPage];

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/admin.css">
	</head>
	<body>
		<nav class="admin-nav" aria-label="Admin navigation">
			<a href="?page=overview.php"<?= $requestedPage === 'overview.php' ? ' class="active" aria-current="page"' : '' ?>>Overview</a>
			<a href="?page=logs.php"<?= $requestedPage === 'logs.php' ? ' class="active" aria-current="page"' : '' ?>>Logs</a>
			<a href="?page=messages.php"<?= $requestedPage === 'messages.php' ? ' class="active" aria-current="page"' : '' ?>>Messages</a>
			<a href="?page=logout.php">Logout</a>
		</nav>
		<div id="main-content">
			<?php include __DIR__ . '/pages/' . $page ?>
		</div>
	</body>
</html>
