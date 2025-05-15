<?php declare(strict_types=1);
$articleId = $_GET["article"] ?? null;
$load_article = false;
$article_to_load = "";
$files = scandir("./articles", SCANDIR_SORT_DESCENDING);
foreach ($files as $file) {
    $parts = explode("_", $file);
    if ($parts[0] == $articleId) {
        $load_article = true;
        $article_to_load = $file;
    }
}
?>
<!doctype html>
<html>

<head>
    <title>www.audiomixing.de - <?php print $article_to_load ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>

<body>
    <?php
    if ($load_article == true) {
        require_once("./articles/" . $article_to_load);

        exit();
    }
    ?>
    <h1>audiomixing.de</h1>
    <h2>Hi, ich bin Dennis und auf dieser Website möchte ich euch auf eine Reise mitnehmen zur Entwicklung einiger Ideen
        zu Audiosoftware.
    </h2>
    <div id="articles" class="articles">
        <?php
        function fetchHtmlAsText(string $url): string
        {
            return file_get_contents($url);

        }
        function fetchArticles(): array
        {
            $files = scandir("./articles", SCANDIR_SORT_DESCENDING);
            $articles = [];
            foreach ($files as $file) {
                $fullpath = "./articles/" . $file;
                if (is_file($fullpath)) {
                    if (str_ends_with($file, ".php")) {
                        $articles[] = $fullpath;
                    }
                }
            }

            return $articles;
        }
        function initialization()
        {
            $articles = fetchArticles();
            foreach ($articles as $element) {
                require_once($element);

            }
        }
        initialization();

        ?>
    </div>
    <?php
    require_once("./footer.php"); ?>
</body>

</html>