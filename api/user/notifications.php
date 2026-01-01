<?php
// Simple notifications reader for UI. Reads storage/logs/notifications.log
require_once __DIR__ . '/../../app/middleware/auth.php';
require_login();

header('Content-Type: application/json');
$log = __DIR__ . '/../../storage/logs/notifications.log';
$out = [];
if (is_file($log)) {
    $lines = @file($log, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines !== false) {
        $lines = array_reverse($lines);
        $max = 50; $count = 0;
        foreach ($lines as $ln) {
            if ($count++ >= $max) break;
            // format: ISO | to=email | sent=0|1 | subj=... | msg=...
            $parts = explode(' | ', $ln, 5);
            $row = ['raw'=>$ln];
            $row['time'] = $parts[0] ?? '';
            // parse key=val segments
            for ($i=1;$i<count($parts);$i++) {
                $kv = $parts[$i];
                $p = explode('=', $kv, 2);
                if (count($p)===2) $row[trim($p[0])] = trim($p[1]);
            }
            $out[] = $row;
        }
    }
}

echo json_encode(['success'=>true,'data'=>$out]);
exit;

?>
