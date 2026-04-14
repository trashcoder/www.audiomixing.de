<?php declare(strict_types=1);

$DOWNLOADS_BASE = __DIR__ . '/downloads';
$COUNTS_FILE    = __DIR__ . '/data/download_counts.json';

$file = $_GET['file'] ?? '';

// Only allow safe path characters — no traversal
if (!preg_match('/^[a-zA-Z0-9_\-\.\/]+$/', $file)) {
    http_response_code(400);
    exit('Ungültiger Dateipfad.');
}

// Resolve and verify the path stays inside the downloads directory
$realBase = realpath($DOWNLOADS_BASE);
$fullPath  = realpath($DOWNLOADS_BASE . '/' . $file);

if ($fullPath === false || !str_starts_with($fullPath, $realBase . '/')) {
    http_response_code(403);
    exit('Zugriff verweigert.');
}

if (!is_file($fullPath)) {
    http_response_code(404);
    exit('Datei nicht gefunden.');
}

// --- increment counter (file-locked JSON) ---
$dataDir = dirname($COUNTS_FILE);
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$fp = fopen($COUNTS_FILE, 'c+');
if ($fp !== false && flock($fp, LOCK_EX)) {
    $content = stream_get_contents($fp);
    $counts  = ($content !== '' && $content !== false) ? json_decode($content, true) : [];
    if (!is_array($counts)) $counts = [];
    $counts[$file] = ($counts[$file] ?? 0) + 1;
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($counts, JSON_PRETTY_PRINT));
    flock($fp, LOCK_UN);
    fclose($fp);
}

// --- serve the file ---
$filename = basename($fullPath);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . (string) filesize($fullPath));
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
readfile($fullPath);
exit;
