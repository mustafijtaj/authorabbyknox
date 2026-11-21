# authorabbyknox

Modern, fully responsive redesign of [authorabbyknox.com](https://www.authorabbyknox.com) — plain HTML, CSS and JavaScript, no build step needed.

## Pages
| File | Page |
|---|---|
| `index.html` | Home — new releases, Darling Creek series, book library, about teaser |
| `reading-list.html` | The Complete Reading List — every title by universe & series, with search |
| `bonus.html` | Bonus epilogues, bonus scenes and the free book |
| `subscribe.html` | Newsletter sign-up (Mailchimp) + Books2Read follow |
| `signed-books.html` | Signed paperbacks, bundles and mystery packs |
| `abby-bites.html` | Monster & paranormal reads sold direct via PayPal → BookFunnel |
| `content-notes.html` | Trigger warnings / content notes (spoiler-safe accordion) |
| `about.html` | About Abby |

Shared files: `styles.css`, `script.js` (all pages), `reading-list.js` (reading list data).

## Deploy
Works on any static host. For GitHub Pages: **Settings → Pages → Source: `main` / root**.

## WordPress version (admin panel + shop)
The `wordpress-theme/` folder has a WordPress + WooCommerce version of this same design, with an admin panel where the author can add books, set prices, sell ebooks and signed paperbacks, and take PayPal payments.
- `wordpress-theme/abbyknox-theme.zip` — upload under *Appearance → Themes → Add New → Upload*
- `wordpress-theme/abbyknox-books-import.csv` — every book, for *Books → Import*
- `wordpress-theme/SETUP-GUIDE.md` — step-by-step setup, PayPal connection and author how-to
