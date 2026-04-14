<?php declare(strict_types=1);

$articleId = $_GET["article"] ?? null;
$article_to_load = "";

$files = scandir("./articles", SCANDIR_SORT_DESCENDING);
foreach ($files as $file) {
    $parts = explode("_", $file);
    if ($parts[0] === $articleId) {
        $article_to_load = $file;
        break;
    }
}

function fetchArticles(): array
{
    $files = scandir("./articles", SCANDIR_SORT_DESCENDING);
    $articles = [];
    foreach ($files as $file) {
        $fullpath = "./articles/" . $file;
        if (is_file($fullpath) && str_ends_with($file, ".php")) {
            $articles[] = $fullpath;
        }
    }
    return $articles;
}
?>
<!doctype html>
<html>

<head>
    <title>audiomixing.de</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/mainstyle.css">
</head>

<body>
    <?php require_once("./header.php"); ?>
    <?php if ($article_to_load !== ""): ?>
        <?php require_once("./articles/" . $article_to_load); ?>
    <?php else: ?>
        <h2>Hi, ich bin Dennis und auf dieser Website möchte ich euch auf eine Reise mitnehmen zur Entwicklung einiger Ideen
            zu Audiosoftware.
        </h2>
        <div id="articles" class="articles">
            <?php foreach (fetchArticles() as $article): ?>
                <?php require_once($article); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php require_once("./footer.php"); ?>
</body>

</html>
