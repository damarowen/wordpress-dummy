# AGENTS.md

## Repository type
Local by Flywheel WordPress site. WordPress core lives in `app/public/`; the repo root adalah Local site root.

## Struktur Repo

```
damarowen-test/                  ← Local site root (repo root)
├── app/
│   ├── public/                  ← WordPress root (document root server)
│   │   ├── wp-admin/            ← Dashboard admin WordPress
│   │   ├── wp-content/
│   │   │   ├── mu-plugins/      ← Must-use plugins (aktif otomatis, tanpa aktivasi manual)
│   │   │   │   └── local-by-flywheel-live-link-helper.php  ← Helper Live Link dari Local
│   │   │   ├── plugins/         ← Plugin WordPress yang diinstal
│   │   │   │   └── elementor/   ← Page builder Elementor 4.1.1
│   │   │   ├── themes/          ← Tema WordPress yang tersedia
│   │   │   │   ├── hello-elementor/   ← Tema aktif (pasangan resmi Elementor)
│   │   │   │   ├── twentytwentyfive/
│   │   │   │   ├── twentytwentyfour/
│   │   │   │   └── twentytwentythree/
│   │   │   ├── uploads/         ← File media yang diunggah (gambar, dokumen, dll.)
│   │   │   └── upgrade/         ← File sementara saat update WordPress
│   │   ├── wp-includes/         ← Core library WordPress (jangan diedit)
│   │   ├── wp-config.php        ← Konfigurasi utama WordPress (DB, konstanta, dll.)
│   │   ├── wp-config-sample.php ← Template konfigurasi bawaan WordPress
│   │   ├── .htaccess            ← Aturan URL rewrite Apache (dikelola WordPress)
│   │   ├── index.php            ← Entry point WordPress
│   │   ├── wp-login.php         ← Halaman login WordPress
│   │   ├── wp-cron.php          ← Scheduler task terjadwal WordPress
│   │   └── local-xdebuginfo.php ← Halaman info Xdebug (khusus Local)
│   └── sql/
│       └── local.sql            ← Dump database (backup/export DB dari Local)
├── conf/                        ← Konfigurasi server yang dikelola Local
│   ├── nginx/
│   │   ├── nginx.conf.hbs       ← Template konfigurasi utama Nginx
│   │   ├── site.conf.hbs        ← Template virtual host Nginx untuk site ini
│   │   └── includes/            ← Snippet konfigurasi Nginx tambahan
│   ├── mysql/
│   │   └── my.cnf.hbs           ← Template konfigurasi MySQL
│   └── php/
│       ├── php.ini.hbs          ← Template konfigurasi PHP (memory, upload limit, dll.)
│       ├── php-fpm.conf.hbs     ← Template konfigurasi PHP-FPM (process manager)
│       └── php-fpm.d/           ← Konfigurasi pool PHP-FPM tambahan
├── logs/                        ← Log server (auto-generated, jangan diedit)
│   ├── nginx/                   ← Access log & error log Nginx
│   ├── mysql/                   ← Log MySQL
│   ├── php/                     ← Error log PHP
│   └── mailpit/                 ← Log Mailpit (email catcher lokal)
├── .opencode/                   ← Konfigurasi dan skills OpenCode AI
│   ├── skills/                  ← 17 WordPress-specific skill workflows
│   ├── package.json             ← Dependensi OpenCode plugin
│   └── node_modules/            ← Dependensi Node.js untuk OpenCode
└── AGENTS.md                    ← File ini (panduan untuk AI agent)
```

### Catatan penting struktur
- File `.hbs` di `conf/` adalah template Handlebars yang di-render oleh Local saat start — **jangan diedit langsung untuk konfigurasi runtime**; edit via UI Local atau ubah template-nya.
- `logs/` di-generate otomatis oleh server; tidak perlu di-commit.
- `app/sql/local.sql` adalah snapshot DB terakhir yang di-export dari Local. Untuk import/export DB terbaru gunakan WP-CLI: `wp db export --path=app/public` dari repo root.

## Key paths
- WordPress root: `app/public/`
- wp-content: `app/public/wp-content/`
- Plugins: `app/public/wp-content/plugins/`
- Themes: `app/public/wp-content/themes/`
- Uploads: `app/public/wp-content/uploads/`
- Config: `app/public/wp-config.php`
- Server config: `conf/nginx/`, `conf/php/`, `conf/mysql/`

## Database
- Name: `local`
- User: `root`
- Password: `root`
- Host: `localhost`
- Prefix: `wp_`

## Installed software
- WordPress core (latest stable)
- Elementor 4.1.1 (`plugins/elementor/`)
- Hello Elementor 3.4.9 (`themes/hello-elementor/`) — active theme
- Twenty Twenty-Five / Twenty Twenty-Four / Twenty Twenty-Three (default WP themes)
- Live Link helper mu-plugin (`mu-plugins/local-by-flywheel-live-link-helper.php`)

## Environment
- `WP_ENVIRONMENT_TYPE` = `local`
- `WP_DEBUG` is `false` by default
- PHP Xdebug is available; info at `app/public/local-xdebuginfo.php`

## OpenCode setup
- `.opencode/` contains `@opencode-ai/plugin` and 17 WordPress-specific skills
- Skills cover: block development, block themes, plugin development, REST API, Interactivity API, Playground, WP-CLI, performance, PHPStan, abilities API, and project triage
- If creating custom plugins or themes in this site, use the relevant `.opencode/skills/` workflow

## Development notes
- No custom plugins or themes currently under active development
- No build pipeline, package scripts, or CI configured for custom code
- No existing git repositories inside `wp-content/`
- Working directory defaults to the repo root (`/Users/macbookair/Local Sites/damarowen-test`), not the WordPress root
- When running WP-CLI or other WordPress commands, either `cd app/public` first or pass `--path=app/public`
