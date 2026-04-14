<?php declare(strict_types=1);

function scanDownloads(string $basePath): array
{
    $result = [];
    $projects = scandir($basePath, SCANDIR_SORT_ASCENDING);
    foreach ($projects as $project) {
        if ($project === "." || $project === "..") continue;
        $projectPath = $basePath . "/" . $project;
        if (!is_dir($projectPath)) continue;

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($projectPath, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($files as $file) {
            $relativePath = substr($file->getPathname(), strlen($basePath) + 1);
            $result[$project][] = [
                "path"  => $relativePath,
                "name"  => $file->getFilename(),
                "size"  => $file->getSize(),
            ];
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
?>
<!doctype html>
<html>

<head>
    <title>audiomixing.de - Downloads</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="styles/mainstyle.css">
</head>

<body>
    <nav>
        <a href="index.php">← Zurück zur Startseite</a>
    </nav>

    <h1>Downloads</h1>

    <?php if (empty($downloads)): ?>
        <p>Keine Dateien vorhanden.</p>
    <?php else: ?>
        <?php foreach ($downloads as $project => $files): ?>
            <section>
                <h2><?php echo htmlspecialchars($project); ?></h2>
                <ul>
                    <?php foreach ($files as $file): ?>
                        <li>
                            <a href="downloads/<?php echo htmlspecialchars($file["path"]); ?>" download>
                                <?php echo htmlspecialchars($file["name"]); ?>
                            </a>
                            <span>(<?php echo formatFileSize($file["size"]); ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php require_once("./footer.php"); ?>
</body>

</html>
