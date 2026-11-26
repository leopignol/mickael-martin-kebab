<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

if (isset($_GET['stream']) && $_GET['stream'] === '1') {
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-Control: no-store');

	if (!$isAuthenticated) {
		http_response_code(401);
		echo json_encode(['error' => 'Authentication required.']);
		exit;
	}

	$logType = $_GET['log'] ?? 'access';
	$logPaths = [
		'access' => [
			'/var/log/apache2/access.log',
			'/var/log/apache2/access_log',
			'/var/log/httpd/access_log',
			'/var/log/httpd/access.log',
			'/usr/local/var/log/httpd/access_log',
			'/opt/homebrew/var/log/httpd/access_log',
		],
		'error' => [
			'/var/log/apache2/error.log',
			'/var/log/apache2/error_log',
			'/var/log/httpd/error_log',
			'/var/log/httpd/error.log',
			'/usr/local/var/log/httpd/error_log',
			'/opt/homebrew/var/log/httpd/error_log',
		],
	];

	if (!is_string($logType) || !isset($logPaths[$logType])) {
		http_response_code(400);
		echo json_encode(['error' => 'Unknown log type.']);
		exit;
	}

	$logPath = null;
	foreach ($logPaths[$logType] as $candidate) {
		if (is_file($candidate) && is_readable($candidate)) {
			$logPath = $candidate;
			break;
		}
	}

	if ($logPath === null) {
		http_response_code(404);
		echo json_encode(['error' => 'No readable Apache ' . $logType . ' log was found.']);
		exit;
	}

	$handle = fopen($logPath, 'rb');
	if ($handle === false) {
		http_response_code(500);
		echo json_encode(['error' => 'Unable to open the Apache log file.']);
		exit;
	}

	$fileInfo = fstat($handle);
	if ($fileInfo === false) {
		fclose($handle);
		http_response_code(500);
		echo json_encode(['error' => 'Unable to read Apache log file information.']);
		exit;
	}

	$generation = hash('sha256', $fileInfo['dev'] . ':' . $fileInfo['ino']);
	$requestedGeneration = $_GET['generation'] ?? '';
	$requestedOffset = $_GET['offset'] ?? '';
	$offsetIsValid = is_string($requestedOffset) && ctype_digit($requestedOffset);

	if ($requestedOffset !== '' && !$offsetIsValid) {
		fclose($handle);
		http_response_code(400);
		echo json_encode(['error' => 'Invalid log offset.']);
		exit;
	}

	$offset = $offsetIsValid ? (int) $requestedOffset : 0;
	$isNewFile = !$offsetIsValid
		|| !is_string($requestedGeneration)
		|| !hash_equals($generation, $requestedGeneration)
		|| $offset > $fileInfo['size'];

	if ($isNewFile) {
		$readLength = min((int) $fileInfo['size'], 65536);
		$start = (int) $fileInfo['size'] - $readLength;
	} else {
		$start = $offset;
		$readLength = min((int) $fileInfo['size'] - $offset, 65536);
	}

	if (fseek($handle, $start) !== 0) {
		fclose($handle);
		http_response_code(500);
		echo json_encode(['error' => 'Unable to seek in the Apache log file.']);
		exit;
	}

	$content = $readLength > 0 ? fread($handle, $readLength) : '';
	$nextOffset = ftell($handle);
	fclose($handle);

	if ($content === false || $nextOffset === false) {
		http_response_code(500);
		echo json_encode(['error' => 'Unable to read the Apache log file.']);
		exit;
	}

	if ($isNewFile) {
		$lines = explode("\n", $content);
		$content = implode("\n", array_slice($lines, -100));
	}

	echo json_encode([
		'content' => $content,
		'offset' => $nextOffset,
		'generation' => $generation,
	], JSON_INVALID_UTF8_SUBSTITUTE);
	exit;
}

if (!$isAuthenticated) {
	http_response_code(403);
	exit('Not authenticated.');
}
?>

<section class="logs-panel" aria-labelledby="logs-heading">
	<h1 id="logs-heading">Apache logs</h1>
	<div class="logs-controls">
		<label for="apache-log-type">Log type</label>
		<select id="apache-log-type">
			<option value="access">Access log</option>
			<option value="error">Error log</option>
		</select>
		<button id="apache-log-pause" type="button" aria-pressed="false">Pause</button>
	</div>
	<p id="apache-log-status" role="status">Connecting to the log…</p>
	<pre id="apache-log-output" aria-live="polite"></pre>
</section>
<link rel="stylesheet" href="css/logs.css">
<script src="js/logs.js"></script>
