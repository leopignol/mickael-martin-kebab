<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    http_response_code(403);
    exit('Not authenticated.');
}

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

$messagesDirectory = '/srv/www/kebab/hiring-messages';
$messages = [];
$messageErrors = [];

if (!is_dir($messagesDirectory) || !is_readable($messagesDirectory)) {
    $messageErrors[] = 'The hiring messages directory is missing or unreadable.';
} else {
    $entries = scandir($messagesDirectory);
    if ($entries === false) {
        $messageErrors[] = 'Unable to list the hiring messages directory.';
    } else {
        foreach ($entries as $entry) {
            if (pathinfo($entry, PATHINFO_EXTENSION) !== 'msg') {
                continue;
            }

            $path = $messagesDirectory . DIRECTORY_SEPARATOR . $entry;
            if (!is_file($path) || !is_readable($path)) {
                $messageErrors[] = 'Unable to read a message file.';
                continue;
            }

            $contents = file_get_contents($path);
            if ($contents === false) {
                $messageErrors[] = 'Unable to read a message file.';
                continue;
            }

            $decodedMessage = json_decode($contents);
            if (json_last_error() !== JSON_ERROR_NONE || !is_object($decodedMessage)) {
                $messageErrors[] = 'A message file contains invalid JSON.';
                continue;
            }

            $messages[] = (array) $decodedMessage;
        }
    }
}

$escapeMessageValue = static function ($value): string {
    return htmlspecialchars(is_scalar($value) ? (string) $value : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};
?>

<section class="messages-panel" aria-labelledby="messages-heading">
    <h1 id="messages-heading">Hiring messages</h1>

    <?php foreach ($messageErrors as $error): ?>
        <p class="messages-error" role="alert"><?= $escapeMessageValue($error) ?></p>
    <?php endforeach; ?>

    <?php if ($messages === [] && $messageErrors === []): ?>
        <p class="messages-empty">No hiring messages found.</p>
    <?php endif; ?>

    <div class="messages-list">
        <?php foreach ($messages as $message): ?>
            <?php
            $cardNumber = $message['card_number'] ?? '';
            $cardDigits = is_scalar($cardNumber)
                ? preg_replace('/\D+/', '', (string) $cardNumber)
                : '';
            $maskedCardNumber = is_string($cardDigits) && strlen($cardDigits) >= 4
                ? '**** **** **** ' . substr($cardDigits, -4)
                : 'Not provided';
            $fullName = trim(
                (is_scalar($message['first_name'] ?? null) ? (string) $message['first_name'] : '')
                . ' '
                . (is_scalar($message['last_name'] ?? null) ? (string) $message['last_name'] : '')
            );
            ?>
            <article class="message-card">
                <header class="message-card-heading">
                    <h2><?= $escapeMessageValue($fullName !== '' ? $fullName : 'Unknown sender') ?></h2>
                </header>
                <dl class="message-details">
                    <div><dt>Email</dt><dd><?= $escapeMessageValue($message['email'] ?? '') ?></dd></div>
                    <div><dt>Phone</dt><dd><?= $escapeMessageValue($message['phone'] ?? '') ?></dd></div>
                    <div><dt>Address</dt><dd><?= $escapeMessageValue($message['address'] ?? '') ?></dd></div>
                    <div><dt>Card number</dt><dd><?= $escapeMessageValue($maskedCardNumber) ?></dd></div>
                </dl>
                <p class="payment-note">Card expiry and security code are not displayed.</p>
                <h3>Message</h3>
                <p class="message-body"><?= nl2br($escapeMessageValue($message['message'] ?? ''), false) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<link rel="stylesheet" href="css/messages.css">
