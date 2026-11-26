<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

function readCpuCounters(): ?array
{
	$stat = @file_get_contents('/proc/stat');
	if ($stat === false || !preg_match('/^cpu\s+(.+)$/m', $stat, $matches)) {
		return null;
	}

	$counters = preg_split('/\s+/', trim($matches[1]));
	if (count($counters) < 4) {
		return null;
	}

	$counters = array_map('intval', $counters);
	return [
		'total' => array_sum($counters),
		'idle' => $counters[3] + ($counters[4] ?? 0),
	];
}

function readMemoryUsage(): ?array
{
	$memory = @file_get_contents('/proc/meminfo');
	if ($memory === false
		|| !preg_match('/^MemTotal:\s+(\d+)\s+kB$/m', $memory, $totalMatch)
		|| !preg_match('/^MemAvailable:\s+(\d+)\s+kB$/m', $memory, $availableMatch)
	) {
		return null;
	}

	$total = (int) $totalMatch[1] * 1024;
	$available = (int) $availableMatch[1] * 1024;
	$used = max(0, $total - $available);

	return [
		'usedGb' => $used / 1073741824,
		'totalGb' => $total / 1073741824,
		'percent' => $total > 0 ? $used / $total * 100 : null,
	];
}

function readNetworkCounters(): ?array
{
	$network = @file_get_contents('/proc/net/dev');
	if ($network === false) {
		return null;
	}

	$received = 0;
	$transmitted = 0;
	$foundInterface = false;

	foreach (array_slice(explode("\n", $network), 2) as $line) {
		if (!preg_match('/^\s*([^:]+):\s*(.+)$/', $line, $matches)) {
			continue;
		}

		if (trim($matches[1]) === 'lo') {
			continue;
		}

		$counters = preg_split('/\s+/', trim($matches[2]));
		if (count($counters) < 9 || !ctype_digit($counters[0]) || !ctype_digit($counters[8])) {
			continue;
		}

		$received += (int) $counters[0];
		$transmitted += (int) $counters[8];
		$foundInterface = true;
	}

	return $foundInterface
		? ['received' => $received, 'transmitted' => $transmitted]
		: null;
}

function readCpuTemperature(): ?float
{
	foreach (glob('/sys/class/thermal/thermal_zone*/temp') ?: [] as $path) {
		$temperature = @file_get_contents($path);
		if ($temperature !== false && is_numeric(trim($temperature))) {
			return (float) trim($temperature) / 1000;
		}
	}

	return null;
}

function readStorageUsage(): ?array
{
	$total = @disk_total_space(__DIR__);
	$free = @disk_free_space(__DIR__);
	if ($total === false || $free === false || $total <= 0) {
		return null;
	}

	$used = max(0, $total - $free);
	return [
		'usedGb' => $used / 1073741824,
		'totalGb' => $total / 1073741824,
		'percent' => $used / $total * 100,
	];
}

if (isset($_GET['metrics']) && $_GET['metrics'] === '1') {
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-Control: no-store, no-cache, must-revalidate');

	if (!$isAuthenticated) {
		http_response_code(401);
		echo json_encode(['error' => 'Authentication required.']);
		exit;
	}

	$now = microtime(true);
	$previous = $_SESSION['overview_telemetry'] ?? [];
	$cpuCounters = readCpuCounters();
	$cpuPercent = null;
	if (is_array($cpuCounters) && isset($previous['cpu']['total'], $previous['cpu']['idle'])) {
		$totalDelta = $cpuCounters['total'] - $previous['cpu']['total'];
		$idleDelta = $cpuCounters['idle'] - $previous['cpu']['idle'];
		if ($totalDelta > 0) {
			$cpuPercent = max(0, min(100, ($totalDelta - $idleDelta) / $totalDelta * 100));
		}
	}

	$networkCounters = readNetworkCounters();
	$networkTraffic = null;
	if (is_array($networkCounters)
		&& isset($previous['network']['received'], $previous['network']['transmitted'], $previous['sampledAt'])
	) {
		$elapsed = $now - (float) $previous['sampledAt'];
		if ($elapsed > 0) {
			$networkTraffic = [
				'incoming' => max(0, ($networkCounters['received'] - $previous['network']['received']) * 8 / $elapsed / 1000000),
				'outgoing' => max(0, ($networkCounters['transmitted'] - $previous['network']['transmitted']) * 8 / $elapsed / 1000000),
			];
		}
	}

	$_SESSION['overview_telemetry'] = [
		'cpu' => $cpuCounters,
		'network' => $networkCounters,
		'sampledAt' => $now,
	];

	echo json_encode([
		'cpuPercent' => $cpuPercent,
		'memory' => readMemoryUsage(),
		'storage' => readStorageUsage(),
		'cpuTemperature' => readCpuTemperature(),
		'network' => $networkTraffic,
		'timestamp' => $now,
	]);
	exit;
}

if (!$isAuthenticated) {
	exit('Not authenticated.');
}
?>

<link rel="stylesheet" href="css/overview.css">

<main class="overview-dashboard">
	<h1 class="overview-heading">Server overview</h1>
	<p id="overview-status" class="overview-status" role="status">Connecting to server telemetry…</p>

	<section class="overview-metrics" aria-label="Server metrics">
		<article class="overview-card" data-metric="cpu">
			<div class="overview-card-top"><h3>Server CPU</h3><span class="overview-indicator" aria-hidden="true"></span></div>
			<p class="overview-value"><span data-value>--</span><span class="overview-unit">%</span></p>
			<p class="overview-status" data-status>Waiting for sample</p>
			<div class="overview-meter" role="progressbar" aria-label="Server CPU usage" aria-valuemin="0" aria-valuemax="100" aria-valuetext="Unavailable"><span data-meter></span></div>
		</article>
		<article class="overview-card" data-metric="memory">
			<div class="overview-card-top"><h3>Server RAM</h3><span class="overview-indicator" aria-hidden="true"></span></div>
			<p class="overview-value"><span data-value>--</span><span class="overview-unit"> GB</span></p>
			<p class="overview-status" data-status>Waiting for sample</p>
			<div class="overview-meter" role="progressbar" aria-label="Server RAM usage" aria-valuemin="0" aria-valuemax="100" aria-valuetext="Unavailable"><span data-meter></span></div>
		</article>
		<article class="overview-card" data-metric="storage">
			<div class="overview-card-top"><h3>Server Storage</h3><span class="overview-indicator" aria-hidden="true"></span></div>
			<p class="overview-value"><span data-value>--</span><span class="overview-unit"> GB</span></p>
			<p class="overview-status" data-status>Waiting for sample</p>
			<div class="overview-meter" role="progressbar" aria-label="Server storage usage" aria-valuemin="0" aria-valuemax="100" aria-valuetext="Unavailable"><span data-meter></span></div>
		</article>
		<article class="overview-card" data-metric="temperature">
			<div class="overview-card-top"><h3>CPU temp</h3><span class="overview-indicator" aria-hidden="true"></span></div>
			<p class="overview-value"><span data-value>--</span><span class="overview-unit"> °C</span></p>
			<p class="overview-status" data-status>Waiting for sample</p>
			<div class="overview-meter" role="progressbar" aria-label="CPU temperature" aria-valuemin="0" aria-valuemax="100" aria-valuetext="Unavailable"><span data-meter></span></div>
		</article>
	</section>

	<section class="traffic-card" aria-labelledby="traffic-title">
		<div class="traffic-heading">
			<h2 id="traffic-title">Traffic</h2>
			<span>Incoming and outgoing traffic · Mbps</span>
		</div>
		<div class="traffic-legend" aria-hidden="true">
			<span><i class="traffic-legend-incoming"></i>Incoming</span>
			<span><i class="traffic-legend-outgoing"></i>Outgoing</span>
		</div>
		<canvas
			class="traffic-chart"
			id="traffic-chart"
			width="800"
			height="280"
			role="img"
			aria-label="Incoming and outgoing network traffic over time, measured in megabits per second"
		>Traffic chart requires JavaScript.</canvas>
		<p class="traffic-note">Live network traffic, refreshed every 3 seconds.</p>
	</section>
</main>
<script src="js/overview.js"></script>
