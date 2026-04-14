# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Running locally

```bash
php -S localhost:8080
```

Then open `http://localhost:8080`.

## Architecture

This is a database-free PHP website. No framework, no build step, no package manager.

**Article system** (`index.php`):
- Articles live in `./articles/` as PHP files named `NNNN_slug.php` (zero-padded numeric prefix).
- `index.php` scans the directory with `SCANDIR_SORT_DESCENDING` and `require_once`s every article file to render the index page.
- A specific article is loaded when `?article=NNNN` is passed: `index.php` matches the numeric prefix, then `require_once`s just that file and calls `exit()`.

**Adding a new article**: create `articles/NNNN_slug.php` with the next sequential number. The file must contain its own `<h3><a href="?article=NNNN">Title</a></h3>` link so it works both on the index and as a standalone view. Include `<?php declare(strict_types=1); ?>` at the top.

**`js/importer.js`**: an unused client-side approach (fetches `articles.json`) — superseded by the server-side PHP rendering in `index.php`.

**Styles**: single stylesheet at `styles/mainstyle.css`. Max content width is 800px.
