<?php declare(strict_types=1);

function loadDownloadCounts(string $countsFile): array
{
    if (!is_file($countsFile)) return [];
    $content = file_get_contents($countsFile);
    if ($content === false || $content === '') return [];
    $decoded = json_decode($content, true);
    return is_array($decoded) ? $decoded : [];
}

function scanDownloads(string $basePath): array
{
    $result = [];
    $projects = scandir($basePath, SCANDIR_SORT_ASCENDING);
    foreach ($projects as $project) {
        if ($project === "." || $project === "..") continue;
        $projectPath = $basePath . "/" . $project;
        if (!is_dir($projectPath)) continue;

        $platforms = scandir($projectPath, SCANDIR_SORT_ASCENDING);
        foreach ($platforms as $platform) {
            if ($platform === "." || $platform === "..") continue;
            $platformPath = $projectPath . "/" . $platform;
            if (!is_dir($platformPath)) continue;

            $files = new FilesystemIterator($platformPath, FilesystemIterator::SKIP_DOTS);
            foreach ($files as $file) {
                if (!$file->isFile()) continue;
                $relativePath = $project . "/" . $platform . "/" . $file->getFilename();
                $result[$project][$platform][] = [
                    "path" => $relativePath,
                    "name" => $file->getFilename(),
                    "size" => $file->getSize(),
                ];
            }
        }
    }
    return $result;
}

function formatFileSize(int $bytes): string
{
    if ($bytes >= 1048576) return round($bytes / 1048576, 1) . " MB";
    if ($bytes >= 1024)    return round($bytes / 1024, 1) . " KB";
    return $bytes . " B";
}

$downloads = scanDownloads("./downloads");
$counts    = loadDownloadCounts(__DIR__ . "/data/download_counts.json");
?>
<!doctype html>
<html>

<head>
    <title>audiomixing.de - Downloads</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/mainstyle.css">
</head>

<body>
    <?php require_once("./header.php"); ?>

    <h1>Downloads</h1>

    <?php if (empty($downloads)): ?>
        <p>Keine Dateien vorhanden.</p>
    <?php else: ?>
        <?php foreach ($downloads as $project => $platforms): ?>
            <section>
                <h2><?php echo htmlspecialchars($project); ?></h2>
                <?php foreach ($platforms as $platform => $files): ?>
                    <h3><?php echo htmlspecialchars($platform); ?></h3>
                    <ul>
                        <?php foreach ($files as $file): ?>
                            <?php $dlCount = $counts[$file["path"]] ?? 0; ?>
                            <li>
                                <a href="download.php?file=<?php echo urlencode($file["path"]); ?>">
                                    <?php echo htmlspecialchars($file["name"]); ?>
                                </a>
                                <span>(<?php echo formatFileSize($file["size"]); ?>)</span>
                                <span class="download-count"><?php echo $dlCount; ?> &times; heruntergeladen</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php require_once("./footer.php"); ?>
</body>

</html>
