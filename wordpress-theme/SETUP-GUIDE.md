# Abby Knox — WordPress Site Setup Guide

This folder contains everything needed to turn the Abby Knox website design into a full WordPress + WooCommerce site with an admin panel where the author (or site owner) can add books, set prices, sell ebooks and signed paperbacks, and take payments through PayPal.

| File | What it is |
|---|---|
| `abbyknox/` (or `abbyknox-theme.zip`) | The custom WordPress theme |
| `abbyknox-books-import.csv` | All of Abby's books, ready to import (156 items) |
| `SETUP-GUIDE.md` | This guide |

---

## 1. Requirements

- A WordPress hosting account (any normal host: Hostinger, SiteGround, Bluehost, Namecheap, etc.)
- WordPress 6.4 or newer, PHP 7.4 or newer
- WooCommerce 9.6 or newer (required by the PayPal plugin)
- A **PayPal Business** account for receiving payments

---

## 2. Install (one-time, about 15 minutes)

1. **Install WordPress** on the domain (most hosts have a one-click installer).
2. **Install WooCommerce:** *Plugins → Add New* → search "WooCommerce" → *Install* → *Activate*. You can skip the WooCommerce setup wizard or fill in the store address and currency (USD).
3. **Upload the theme:** *Appearance → Themes → Add New → Upload Theme* → choose `abbyknox-theme.zip` → *Install* → *Activate*.

   When the theme is activated it **automatically creates**:
   - Pages: Home, The Complete Reading List, Content Notes, Subscribe, About
   - Book categories: Signed Books, Abby Bites, Bonus, Ebooks
   - The main menu, with the homepage set as the front page

4. **Permalinks:** *Settings → Permalinks* → choose **Post name** → *Save*.

---

## 3. Import all the books

1. Go to *Books → All Books* → click **Import** at the top.
2. Choose `abbyknox-books-import.csv` → *Continue*.
3. On the column-mapping screen, leave everything as it is. Every column maps automatically, including the "Meta:" columns. Click **Run the importer**.
4. Wait until it finishes. Covers are downloaded from Abby's current site, so this can take a few minutes.

What gets imported:

| Group | Type in WooCommerce | Notes |
|---|---|---|
| 140 books (all series) | External / Affiliate | Buy button goes to Books2Read / Amazon. The series and universes for the Reading List are created automatically. |
| 9 Signed Books | Simple (physical) | Prices are already set. These are sold and paid for on the site. |
| 3 Abby Bites | Simple, Virtual + Downloadable | **Price and ebook file must be added** (see step 4) |
| 4 Bonus items | External / Affiliate | Free BookHip / BookFunnel downloads |

> Books with no known store link point to an Amazon search for the title. Replace these with the exact links when you have them.

---

## 4. After the import — finish these

- [ ] **Abby Bites:** open each of the 3 books → set the *Regular price* → under *Downloadable files* click *Add File* → upload the EPUB/PDF → *Update*.
- [ ] **Shipping for signed books:** *WooCommerce → Settings → Shipping* → *Add zone* (e.g. "United States") → add **Flat rate** (or Free shipping) with the price Abby charges.
- [ ] **About page photo:** *Pages → About* → *Featured image* → upload Abby's photo or logo.
- [ ] **Logo (optional):** *Appearance → Customize → Site Identity → Logo*. If no logo is set, the "AK" circle is shown.
- [ ] **Check the homepage text:** *Appearance → Customize → Abby Knox site settings*.
- [ ] **Store emails:** *WooCommerce → Settings → Emails* → set the "From" name to Abby Knox and the from-address to her email.
- [ ] Remove the old Squarespace links from book descriptions once the new store is live.

---

## 5. Connect PayPal (payment gateway)

1. *Plugins → Add New* → search **"WooCommerce PayPal Payments"** (the official plugin by WooCommerce) → *Install* → *Activate*.
2. Go to *WooCommerce → Settings → Payments* → next to **PayPal** click *Enable* / *Complete setup*.
3. Click **Activate PayPal Payments** and follow the wizard. Log in with Abby's PayPal **Business** account and click *Connect to PayPal*.
4. **Test first (recommended):** in the wizard, open *See advanced options* and enable **Sandbox** mode. Connect a PayPal sandbox account (created at developer.paypal.com) and place a test order. Then disconnect it and connect the live account.
5. Once connected, buyers can pay by PayPal, Pay Later and cards. Paid ebook orders are completed automatically, and the buyer gets the download link by email and under *My account → Downloads*.

> Other gateways (Stripe and others) can be added the same way later. The theme doesn't need any changes for them.

---

## 6. How the author adds a new book

*Books → Add New Book.* There's a **"How to add a book"** help box on the right of that screen.

| I want to… | Product type | Fill in |
|---|---|---|
| **Sell an ebook on the site** | Simple product → tick **Virtual** and **Downloadable** | Price · upload EPUB/PDF under *Downloadable files* · category *Abby Bites* or *Ebooks* |
| **Sell a signed paperback** | Simple product (no ticks) | Price · stock in *Inventory* · weight in *Shipping* · category *Signed Books* |
| **List a book sold on Amazon/Books2Read** | External/Affiliate product | *Product URL* (store link) · *Button text* (e.g. "Buy on Amazon") · category *Books* |

Always:
- **Product image** → the cover.
- **Series** box (right side) → tick the series. The book then appears on the Reading List automatically.
- **Book subtitle**, **Book # in series** and **Content notes** are under *Product data → General*. If content notes are filled in, the book appears on the Content Notes page and gets a "Content notes" tab.
- **Short description** → the blurb shown on cards and next to the buy button.
- To put a book in the homepage **Spotlight**, click the ☆ star next to it in *Books → All Books*.
- The newest books (by publish date) automatically appear first in **Latest Releases** and in the hero.

**Prices:** change any time in *Books → All Books → Edit*. A *Sale price* shows a sale badge automatically.

**Orders:** *WooCommerce → Orders*. Ebook orders complete themselves. Signed-book orders show as *Processing*. Ship the book, then change the status to *Completed* (the buyer gets an email).

---

## 7. Where things are managed

| Site section | Managed in |
|---|---|
| Homepage hero, tropes ticker, series spotlight, short bio | Appearance → Customize → Abby Knox site settings → Homepage |
| Newsletter link (Mailchimp) | … → Newsletter |
| Email + social links | … → Contact & social links |
| Reading List (universes, series, order) | Books → Series & Universes (top level = universe, child = series, "Display order" sets order) |
| Signed Books / Abby Bites / Bonus pages | Book categories — any book in that category appears there |
| Content Notes page | The "Content notes" field on each book |
| About page | Pages → About (block editor; excerpt = intro line, featured image = photo) |
| Menu | Appearance → Menus |

---

## 8. Good to know

- **Backups & security:** install a backup plugin (e.g. UpdraftPlus) and keep WordPress, WooCommerce and plugins updated.
- **Speed:** a caching plugin (e.g. LiteSpeed Cache or WP Super Cache) is recommended. The theme itself is lightweight, with no page builder.
- The theme is translation-ready (text domain `abbyknox`).
