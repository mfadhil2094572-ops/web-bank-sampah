<?php
// Simple notification/email helper for the project.
// Attempts to send email via mail() if available, otherwise logs to storage/logs/notifications.log

function bs_notify_user(string $toEmail, string $subject, string $message): bool {
    // basic mail attempt
    $sent = false;
    if (!empty($toEmail) && filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
        // try mail(), but suppress warnings
        $headers = "From: no-reply@banksampah.local" . "\r\n" .
                   "Content-Type: text/plain; charset=utf-8" . "\r\n";
        try {
            $sent = @mail($toEmail, $subject, $message, $headers);
        } catch (Throwable $e) {
            $sent = false;
        }
    }

    // Always log the notification so admins can inspect it
    $logDir = __DIR__ . '/../storage/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/notifications.log';
    $line = sprintf("%s | to=%s | sent=%s | subj=%s | msg=%s\n", date('c'), $toEmail, $sent ? '1' : '0', str_replace(["\r","\n"], ['',' '], $subject), str_replace(["\r","\n"], [' ',' '], $message));
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

    return (bool)$sent;
}

?>
