
async function fetchHtmlAsText(url) {
    const response = await fetch(url);
    return await response.text();
}

async function fetchArticles() {
    const response = await fetch("./articles.json");
    return await JSON.parse(await response.text());
}

async function initialization() {
    const articles = await fetchArticles();
    const contentDiv = document.getElementById("articles");
    for (element of articles) {
        contentDiv.innerHTML = contentDiv.innerHTML + "<article>" + await fetchHtmlAsText(element) + "</article>";
    }
}

