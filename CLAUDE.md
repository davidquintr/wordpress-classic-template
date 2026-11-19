@AGENTS.md

## Notes for Claude Code

- The full guide is `AGENTS.md` (imported above). If you change the structure, the ACF blocks, the CSS/TS conventions or `theme.json`, update `AGENTS.md`, not this file.
- **English first, always:** code, comments, docs, commit messages and UI strings. Reply to the user in their language, but everything written to the repository is English.
- **No inline comments:** document each file in a single header comment at the top, and keep it up to date when you edit the file.
- Before proposing any change, ask whether it adds weight to the page. Performance is the theme's priority.
- New sections are **ACF dynamic blocks**: a template in `template-parts/blocks/` and its CSS in `styles/blocks/`, imported in `styles/main.css`.
- Class names use single hyphens only: never `__` or `--`.
- The local site's database can be queried with WP-CLI using Local's PHP and MySQL socket (site `lfSELiAA1`). `wp-cli.phar` lives in `/opt/Local/resources/extraResources/bin/wp-cli/`.
