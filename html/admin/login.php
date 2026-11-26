<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$json_file = file_get_contents("data.json");
	$json_data = json_decode($json_file, true);
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';
	$user = is_string($username) && is_array($json_data)
		? ($json_data[$username] ?? null)
		: null;
	$expectedPassword = is_array($user) ? ($user['password'] ?? null) : null;

	$valid = is_string($username)
		&& $username !== ''
		&& is_string($password)
		&& $password !== ''
		&& is_string($expectedPassword)
		&& hash_equals($expectedPassword, $password);

	if (!$valid) {
		http_response_code(401);
		exit('Invalid username or password.');
	}

	session_regenerate_id(true);
	$_SESSION['authenticated'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['level'] = $json_data[$username]['level'];

	header('Location: /admin');
	exit;
}
elseif ($_SERVER['REQUEST_METHOD'] !== 'GET') {
	exit("Invalid REQUEST_METHOD");
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
		<form action="login.php" method="post">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" autocomplete="username" required>

			<label for="password">Password</label>
			<input type="password" id="password" name="password" autocomplete="current-password" required>

			<button type="submit">Log in</button>
		</form>
	</body>
</html>
