# damarowen-test — WordPress Site

WordPress site lokal yang dikelola via [Local by Flywheel](https://localwp.com/). Site ini menggunakan **Elementor** sebagai page builder dengan tema **Hello Elementor**.

---

## Mental Model: WordPress untuk Backend Developer

Jika Anda familiar dengan backend framework seperti Laravel, Express, atau Rails, berikut padanannya:

| Konsep | WordPress | Analogi Backend |
|---|---|---|
| **Entry point & routing** | `index.php` → `wp-settings.php` → hooks system | Semua request masuk lewat `index.php`. WordPress membaca URL, lalu menjalankan hooks yang terdaftar (mirip middleware chain). |
| **Middleware / Hooks** | Actions (`do_action`) & Filters (`apply_filters`) | **Actions** seperti event dispatcher: "user just logged in", jalankan fungsi A, B, C. **Filters** seperti middleware pipeline: data lewat, bisa diubah sebelum sampai ke response. |
| **Controller** | `wp-content/themes/<theme>/` | Template files (PHP). Mirip Blade/ERB views tapi juga mengandung logic routing ke database. |
| **ORM / Database** | `WP_Query`, `wpdb` | `WP_Query` seperti Query Builder dengan caching built-in. `$wpdb` adalah raw PDO wrapper. |
| **Models** | Custom Post Types (CPT), `WP_Post`, `WP_User` | Bukan ORM classic — data disimpan di tabel `wp_posts` dengan `post_type` sebagai discriminator. |
| **Migrations** | Tidak ada migration versioning | Schema berubah via plugin activation hooks. Untuk production, dump SQL dan commit ke repo. |
| **Auth & Roles** | `wp_authenticate`, `current_user_can()`, roles/caps | Mirip Gate/Policy system. User punya role (admin, editor, subscriber), role punya capabilities. |
| **Package Manager** | Plugin directory (manual) | Tidak ada Composer default. Plugin di-download/di-copy ke `plugins/`. |
| **Task Scheduler** | `wp-cron.php` | Cron berbasis HTTP request (di-trigger oleh traffic, bukan cron daemon). |
| **REST API** | `/wp-json/wp/v2/` | REST API built-in. Bisa di-extend via `register_rest_route()`. Juga ada WP-CLI untuk operasi server-side. |

### Cara Kerja Request

```
Browser → Nginx → PHP-FPM → index.php
                               ↓
                            wp-config.php   ← DB credential & constants
                               ↓
                            wp-settings.php  ← Load semua plugin & theme
                               ↓
                            WP_Hooks chain   ← Actions & Filters jalan
                               ↓
                            Template engine  ← PHP file dari theme
                               ↓
                            Response HTML
```

---

## Struktur Repo

```
damarowen-test/                     ← Root repo (Local site root)
├── app/
│   ├── public/                     ← WordPress root (document root)
│   │   ├── wp-admin/               ← Dashboard admin (JANGAN DIEDIT)
│   │   ├── wp-content/
│   │   │   ├── mu-plugins/         ← [EDIT] Must-use plugins (auto-activate)
│   │   │   ├── plugins/            ← [EDIT] Installed plugins
│   │   │   │   └── elementor/      ← Elementor 4.1.1 page builder
│   │   │   ├── themes/             ← [EDIT] Tema (PHP template + CSS/JS)
│   │   │   │   └── hello-elementor/← Tema aktif (pair dengan Elementor)
│   │   │   ├── uploads/            ← [IGNORE] File media (gambar, pdf, dll)
│   │   │   └── upgrade/            ← Temporer saat update WordPress
│   │   ├── wp-includes/            ← [JANGAN DIEDIT] Core library WordPress
│   │   ├── wp-config.php           ← [EDIT] Konfigurasi utama
│   │   ├── index.php               ← Entry point (JANGAN DIEDIT)
│   │   └── .htaccess               ← [AUTO] Aturan rewrite Apache
│   └── sql/
│       └── local.sql               ← Snapshot database (backup manual)
├── conf/                           ← [JANGAN DIEDIT LANGSUNG]
│   ├── nginx/                      ← Template konfigurasi Nginx (.hbs)
│   ├── mysql/                      ← Template konfigurasi MySQL (.hbs)
│   └── php/                        ← Template konfigurasi PHP (.hbs)
├── logs/                           ← [IGNORE] Log server (auto-generated)
└── .opencode/                      ← Konfigurasi AI assistant
```

---

## Zona Edit / No-Edit

### ✅ Boleh / Perlu Diedit

| Path | Keterangan |
|---|---|
| `app/public/wp-content/plugins/` | Plugin kustom yang Anda buat. **Plugin third-party (seperti Elementor) jangan diedit** — update akan overwrite. |
| `app/public/wp-content/themes/` | Semua file tema. Tema hello-elementor boleh dimodifikasi (child theme disarankan). |
| `app/public/wp-content/mu-plugins/` | Must-use plugin — cocok untuk fungsi global yang harus selalu jalan. |
| `app/public/wp-config.php` | Konstanta WordPress, debug mode, environment config. **Jangan commit DB credential ke GitHub public.** |
| `app/sql/local.sql` | Snapshot database. Export ulang via `wp db export --path=app/public` setelah perubahan data. |
| `.opencode/` | Konfigurasi AI assistant untuk tim. |

### ❌ JANGAN Diedit

| Path | Alasan |
|---|---|
| `app/public/wp-admin/` | Core WordPress — update akan overwrite. |
| `app/public/wp-includes/` | Core WordPress — update akan overwrite. |
| `app/public/index.php`, `wp-*.php`, `xmlrpc.php` | Core WordPress entry points. |
| `app/public/wp-content/plugins/elementor/` | Plugin third-party — update akan overwrite. Gunakan child theme atau custom plugin untuk modifikasi. |
| `conf/nginx/*.hbs`, `conf/php/*.hbs`, `conf/mysql/*.hbs` | Template Handlebars yang di-render Local. Ubah via UI Local, bukan langsung. |

### ⚠️ Perhatian Khusus

- **wp-config.php** — Jangan pernah commit DB credential (DB_NAME, DB_USER, DB_PASSWORD) ke GitHub publik. Untuk deployment gunakan environment variables.
- **.htaccess** — Dihasilkan otomatis oleh WordPress (permalink settings). Jangan di-track Git jika ada.
- **uploads/** — File media tidak perlu di-track Git. Gunakan backup/file server terpisah.

---

## Panduan GitHub

### 🔴 Jangan di-push

- `app/sql/local.sql` — jika berisi data lokal yang tidak perlu di production
- `logs/` — auto-generated, bisa gigabytes
- `app/public/wp-content/uploads/` — file media
- `conf/nginx/*.hbs`, `conf/php/*.hbs`, `conf/mysql/*.hbs` — template spesifik Local
- `.opencode/node_modules/` — dependency lokal
- `app/public/wp-config.php` — jika credential berbeda dengan production

### 🟢 Boleh di-push

- `app/public/wp-content/plugins/<plugin-kustom>/` — plugin yang Anda buat sendiri
- `app/public/wp-content/themes/<theme-kustom>/` — tema/child theme kustom
- `app/public/wp-content/mu-plugins/` — mu-plugins
- `app/sql/local.sql` — **hanya jika** disepakati sebagai baseline database tim (tidak berisi credential rahasia)
- `.opencode/` (kecuali `node_modules/`) — konfigurasi tim
- `AGENTS.md`, `README.md`
- `app/public/wp-config.php` — **hanya jika** credential-nya pakai environment variables, bukan hardcoded

### Best Practice untuk Team

1. **Gunakan `.gitignore`** untuk `logs/`, `uploads/`, `node_modules/`, `*.sql` (kecuali hasil export tim)
2. **Environment variables** di wp-config: `define('DB_NAME', getenv('DB_NAME'));` agar credential aman di semua environment
3. **Database sync** — export DB via `wp db export --path=app/public`, simpan di `app/sql/`, dan push snapshot yang disepakati tim
4. **Update plugin/core** — lakukan di Local, test, lalu push perubahan yang relevan (bukan seluruh `wp-content/`)

---

## Command Penting

```bash
# Jalankan dari repo root:

# WP-CLI (path ke WordPress)
wp --path=app/public <command>

# Export database ke app/sql/local.sql
wp --path=app/public db export app/sql/local.sql

# Import database dari app/sql/local.sql
wp --path=app/public db import app/sql/local.sql

# Clear cache
wp --path=app/public cache flush
```

---

## Teknologi

| Komponen | Versi |
|---|---|
| WordPress | Latest stable |
| Elementor | 4.1.1 |
| Hello Elementor | 3.4.9 |
| PHP | Via Local (konfigurasi di `conf/php/`) |
| Database | MySQL/MariaDB via Local |
| Web Server | Nginx (konfigurasi di `conf/nginx/`) |
| Environment | `WP_ENVIRONMENT_TYPE=local`, `WP_DEBUG=false` |
