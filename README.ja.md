<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: モダンなPHPディレクトリリストスクリプト v1.5.36

FileLister は、強力で軽量かつモダンな **PHP ディレクトリリストスクリプト** で、サーバーファイルを美しいモバイルフレンドリーな **Web ファイルエクスプローラー** に変換します。`h5ai` や `Apache Index` の完璧な代替品で、単一ファイル展開オプションと組み込みのファイルプレビュー機能を提供します。

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 目次
- [✨ 機能](#-機能)
- [📦 インストール](#-インストール)
- [⚙️ 設定](#-設定)
- [🎨 テーマ](#-テーマ)
- [🧩 カスタムHTMLフック](#-カスタムhtmlフック)
- [🌍 マルチ言語サポート](#-マルチ言語サポート)
- [👁️ ファイルプレビュー](#-ファイルプレビュー--viewer)
- [🔗 共有 & ダウンロード](#-共有--ダウンロード)
- [⌨️ キーボードショートカット](#-キーボードショートカット)
- [🛡️ セキュリティ詳細](#-セキュリティ詳細)
- [📋 要件](#-要件)

---

## ✨ 機能

### 🚀 **本番環境対応 & 高速**
- **スタンドアローン版**: すべてのリソースを埋め込んだ単一ファイル展開 (`Standalone.php`)。生成するには `php build.php` を実行。
- **Docker サポート**: すぐに使える `Dockerfile` と `docker-compose.yml`。
- **インデックス提供**: ディレクトリに存在する場合、オプションで `index.html` を提供。

### 🎨 **モダンなユーザーインターフェース**
- **クリーン & レスポンシブ**: モバイルファーストレイアウト、すべてのデバイスで動作。
- **9 テーマ**: `light`、`dark`、`auto`、`ocean`、`forest`、`dracula`、`nord`、`high-contrast`、`cute` (アニメガラスモーフィズム)。
- **グリッド & リストビュー**: カードグリッドビューと詳細リストビューを切り替え。
- **README レンダリング**: ディレクトリリストの下部で `README.md` ファイルを自動的にレンダリング。
- **ローカライズ済み**: 18+ のサポートされたロケールを持つ言語セレクター。

### 🛡️ **セキュリティ強化**
- **CSP と Nonces**: すべてのインラインスクリプトにリクエストごとの暗号化 nonce。`unsafe-inline` なし。
- **レート制限**: 統合されたアンチ DDoS リクエストスロットリング (デフォルトで 60 req/60s)。
- **信頼できるプロキシ**: 安全な `X-Forwarded-For` 処理 — 信頼できるプロキシ IP からのリクエストの場合のみ適用。
- **パストラバーサル保護**: すべての `?dir=` 入力が `realpath()` で解決され `$lister_root` に制限。
- **機密ファイル隠蔽**: `.env`、`.git`、`.htaccess`、PHP ファイルを自動的に無視。
- **セキュリティヘッダー**: `X-Frame-Options`、`X-Content-Type-Options`、`X-XSS-Protection`、`Referrer-Policy`、`Permissions-Policy`、`Strict-Transport-Security` (HTTPS のみ)。
- **MD5/SHA-1 なし**: デフォルトハッシュセットは `CRC32,XXH128,SHA-256,SHA3-256` に設定。MD5 と SHA-1 はデフォルトで除外。

### 🔍 **ファイル整合性 (情報 & ハッシュ)**
- SHA-3、WHIRLPOOL、XXH128、CRC32 を含むファイルごとに 40+ のハッシュアルゴリズムを検証。
- ハッシュ用の設定可能な最大ファイルサイズ。
- 結果は情報モーダルでインライン表示。

### 📤 **エクスポート & 共有**
- **JSON、CSV、TSV、NDJSON** 形式でファイルリストをコピー/ダウンロード。
- QR コードと直接リンクでファイルを共有。

---

## 📦 インストール & 展開モード

FileLister は 4 つの展開モードをサポート。あなたのセットアップに合ったものを選択:

---

### モード 1: スタンドアロン (単一 PHP ファイル) — 本番推奨

すべてのリソースが自己完結型ファイルにコンパイル。`_/` フォルダ不要。

```bash
# ステップ 1: スタンドアロンファイルをビルド
php build.php

# ステップ 2: Standalone.php をサーバーにアップロード
# ステップ 3: index.php に名前変更 (または好みの名前)
```

> **設定**: 自動的に `'use_embedded' => true` を設定。他の設定不要。

---

### モード 2: 通常 (ソースファイル)

クラシックなマルチファイルセットアップ。開発で最速。

```
your-web-root/
├── index.php        ← エントリーポイント (require_once 'core.php')
├── core.php         ← コアロジック & 設定
└── _/               ← CSS、JS、アイコン、翻訳ファイル
```

**ステップ:**
1. `index.php`、`core.php`、`_/` を Web ディレクトリにコピー。
2. ブラウザでアクセス: `http://yoursite.com/`
3. 追加設定不要。

---

### モード 3: サブディレクトリ展開

自分のコンテンツをインデックスするサブフォルダで FileLister を実行。

```
your-web-root/
├── files/           ← インデックスしたいディレクトリ
│   ├── index.php    ← FileLister エントリーポイント
│   └── core.php
└── _/               ← 共有アセット (親スキャンで自動検出)
```

`detect_assets_path()` 関数は `_/` アセットフォルダを特定するため、自動的に **最大 5 つの親ディレクトリ** をスキャン。ほとんどの場合、手動 `assets_path` 設定不要。

アセットが自動検出されない場合:
```php
'assets_path' => '../_',   // または '/var/www/html/_' のようなフルパス
```

---

### モード 4: グローバル展開 (サーバー上の任意のディレクトリをインデックス)

スクリプト位置から切り離されたサーバー上の任意のパスをブラウズするために **単一の FileLister インストール** を使用。

```
/var/www/html/
├── filelister/      ← FileLister はここに住む
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← 実際にインデックスしたいディレクトリ
```

**`core.php` での設定:**
```php
'base_path' => '/var/data',   // ← リストしたいディレクトリを設定
```

> `base_path` は PHP プロセスが読み取れる任意の **絶対ファイルシステムパス** を受け入れる。スクリプトは `realpath()` を使用してすべての `?dir=` ナビゲーションがこのルート内に留まることを強制し、パストラバーサルを防ぐ。

**Web サーバー設定** (FileLister をディレクトリインデックスとして使用):

**Nginx:**
```nginx
server {
    root /var/data;
    index index.php FileLister.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME /var/www/html/filelister/index.php;
    }
}
```

**Apache (ターゲットディレクトリ内の `.htaccess`):**
```apache
DirectoryIndex index.php FileLister.php index.html

# すべてのディレクトリリクエストを FileLister にルート:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### モード 5: Docker

```bash
docker-compose up -d
```

`http://localhost:8080` でアクセス。`docker-compose.yml` を編集してターゲットディレクトリをマウント。

---

### 展開モード比較

| モード | 必要なファイル | 最適 |
|------|---------------|----------|
| **スタンドアロン** | `Standalone.php` のみ | クイック展開、共有ホスティング |
| **通常** | `index.php` + `core.php` + `_/` | 開発、フルコントロール |
| **サブディレクトリ** | 通常と同じ、サブフォルダに配置 | 特定のサブフォルダのインデックス |
| **グローバル** | 通常 + `base_path` 設定 | サーバーパスをインデックスする単一インスタンス |
| **Docker** | `Dockerfile` + `docker-compose.yml` | コンテナ化環境 |

---

## ⚙️ 設定

すべての設定は `core.php` (または `Standalone.php`) の `$config` 配列内。

### 一般

| キー | デフォルト | 説明 |
|-----|---------|-------------|
| `title` | `''` | カスタムページタイトル。空の場合、パスから自動生成。 |
| `title_prefix` | `'Index of'` | 自動生成タイトルのプレフィックス。 |
| `title_suffix` | `' - FileLister'` | 自動生成タイトルのサフィックス。 |
| `language` | `''` | ロケールを強制 (`en`、`vi`、`zh`、`ja`…) 。空の場合自動検出。 |
| `allowed_langs` | (18 言語) | セレクタードロップダウンで利用可能な言語。 |
| `theme` | `'ocean'` | デフォルトテーマ。オプション: `light`、`dark`、`auto`、`ocean`、`forest`、`dracula`、`nord`、`high-contrast`、`cute`。 |
| `view_mode` | `'list'` | デフォルトビュー。オプション: `grid`、`list`。 |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP タイムゾーン文字列。 |
| `date_format` | `'Y-m-d H:i:s'` | PHP 日付フォーマット文字列。 |
| `base_path` | `''` | グローバル/サブディレクトリ展開のルートディレクトリ。 |
| `favicon_path` | `''` | カスタム favicon へのパス。 |

### 表示オプション

| キー | デフォルト | 説明 |
|-----|---------|-------------|
| `show_hidden` | `false` | 隠しファイルを表示 (`.` で始まる)。 |
| `show_size` | `true` | ファイルサイズ列を表示。 |
| `show_date` | `true` | 最終変更日列を表示。 |
| `show_type` | `true` | ファイルタイプ列を表示 (リストビュー)。 |
| `show_folder_size` | `true` | フォルダサイズを計算 (再帰的 — 大きなフォルダで遅い可能性)。 |
| `show_breadcrumb` | `true` | ナビゲーションブレッドクラムを表示。 |
| `show_footer` | `true` | フッターバーを表示。 |
| `show_copyright` | `true` | フッターに著作権情報を表示。 |
| `show_language_selector` | `true` | 言語スイッチャーコントロールを表示。 |
| `show_theme_selector` | `true` | テーマスイッチャーボタンを表示。 |

### 機能

| キー | デフォルト | 説明 |
|-----|---------|-------------|
| `enable_search` | `true` | ライブファイル検索を有効化。 |
| `enable_preview` | `true` | ファイルプレビューモーダルを有効化 (画像、ビデオ、オーディオ、PDF、コード)。 |
| `enable_download` | `true` | ファイルにダウンロードボタンを表示。 |
| `enable_share` | `true` | QR コード付きファイル共有モーダルを有効化。 |
| `enable_qrcode` | `true` | 共有モーダルで QR コードを生成。 |
| `enable_shortcuts` | `true` | キーボードショートカットを有効化。 |
| `enable_export` | `true` | ファイルリストのエクスポート/コピーを有効化 (JSON、CSV、TSV、NDJSON)。 |
| `enable_readme` | `true` | ディレクトリリストの下部で `README.md` ファイルをレンダリング。 |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | ハッシュアルゴリズムのコンマ区切りリスト。サポート: `MD5`、`SHA-1`、`SHA-256`、`SHA-512`、`SHA-512/224`、`SHA-512/256`、`SHA3-256`、`WHIRLPOOL`、`CRC32`、`XXH128`、および 30+ 以上。 |
| `hash_uppercase` | `true` | ハッシュ値を大文字で表示。 |
| `max_hash_size` | `1000` | ハッシュに許可される最大ファイルサイズ (MB)。 |

### セキュリティ

| キー | デフォルト | 説明 |
|-----|---------|-------------|
| `ignore_files` | (下記参照) | 隠すファイル。デフォルトで `index.php`、`.htaccess`、`.htpasswd`、`.git`、`.env` を含む。 |
| `ignore_extensions` | `['php']` | 隠す拡張子。 |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | 隠すフォルダ。 |
| `allowed_extensions` | `[]` | 拡張子のホワイトリスト (空 = すべて許可)。 |
| `protected_paths` | `['/etc', '/var/www/.git']` | 常にブロックされる絶対パス。 |
| `enable_rate_limit` | `true` | IP ベースのレート制限を有効化。 |
| `rate_limit_requests` | `60` | ウィンドウあたりの最大リクエスト。 |
| `rate_limit_period` | `60` | レート制限時間ウィンドウ (秒)。 |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | レート制限から除外された IP。 |
| `trusted_proxies` | `[]` | `X-Forwarded-For` を設定できる IP。空 = 誰も信頼しない。 |
| `enable_dev` | `true` | **⚠️ 本番で `false` に設定。** PHP エラー表示を有効化し、キャッシュを無効化。 |

> [!CAUTION]
> 本番展開前に常に `'enable_dev' => false` を設定。本番モードでは、訪問者にファイルパス、設定詳細、スタックトレースを公開する可能性のある PHP エラーが表示されます。

### 詳細

| キー | デフォルト | 説明 |
|-----|---------|-------------|
| `assets_path` | `''` | `_/` アセットフォルダへのパス。空の場合自動検出。 |
| `use_embedded` | `false` | 埋め込みアセットモードを強制 (`Standalone.php` で使用)。 |
| `thumbnail_directory` | `''` | サムネイルキャッシュのカスタムパス。空の場合自動的に `_/thumbs` に設定。 |
| `thumbnail_width` | `200` | 最大サムネイル幅 (px)。 |
| `thumbnail_height` | `200` | 最大サムネイル高 (px)。 |
| `thumbnail_cache_expiry` | `30` | キャッシュされたサムネイルがパージされる前の日数。`0` = 常にクリーン。`-1` = 決してクリーンしない。 |
| `readme_files` | (リスト) | README レンダリング用にスキャンするファイル名。 |
| `custom_css` | `'_/css/custom.css'` | カスタム CSS ファイルへのパス (存在する場合読み込み)。 |
| `custom_js` | `'_/js/custom.js'` | カスタム JS ファイルへのパス (存在する場合読み込み)。 |
| `serve_index_files` | `false` | 存在する場合 `index.html` を直接提供。⚠️ 信頼できないファイルが存在する場合潜在的な XSS リスク。 |
| `index_files` | `['index.html', …]` | 検索するインデックスファイル名。 |

### サーバーをディレクトリインデックスとして設定

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache (`.htaccess`)
```apache
DirectoryIndex index.php FileLister.php index.html
```

### 外部ホストを許可 (CSP)
FileLister は厳格な **Content Security Policy** を使用。外部ドメインからリソースをロードするには、`core.php` で `Content-Security-Policy` ヘッダーを編集:

```php
// 適切なディレクティブにドメインを追加:
// img-src: 外部画像用
// script-src: 外部スクリプト用 (注意して使用)
// style-src: 外部 CSS 用
```

---

## 🎨 テーマカスタマイズ

### 利用可能なテーマ
| テーマ | 説明 |
|-------|-------------|
| `light` | クリーンな白テーマ |
| `dark` | ダークモード |
| `auto` | システム設定に従う |
| `ocean` | 青いオーシャントーン |
| `forest` | 緑の地球トーン |
| `dracula` | Dracula ダークパープル |
| `nord` | 北欧アークティックパレット |
| `high-contrast` | アクセシビリティフォーカス |
| `cute` | 背景画像付きアニメガラスモーフィズム |

### カスタムテーマを作成

1. **テーマをコピー**: `_/css/themes/ocean.css` を複製 → `_/css/themes/mytheme.css`。

2. **CSS 変数を編集**:
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... その他の変数 */
}
```

3. **JS で登録**: `_/js/app.js` の `toggleTheme()` 配列にテーマ名を追加。

4. **設定で有効化**:
```php
'theme' => 'mytheme',
```

5. **設定でホワイトリスト** (テーマセレクターが機能): `index.php` で `$allowed_themes` を検索し、`'mytheme'` を配列に追加。

---

## 🧩 カスタムHTMLフック

コアファイルを編集せずに特定のページ位置にカスタム HTML、CSS、または JavaScript を注入。`core.php` で `html_hooks` 配列を設定:

```php
'html_hooks' => array(
    'head_end'      => '',  // </head> の前
    'body_start'    => '',  // <body> の後
    'header_start'  => '',  // <header> が開く後
    'header_end'    => '',  // </header> の前
    'main_before'   => '',  // <main> の前
    'main_start'    => '',  // <main> 内、アイテムの前
    'main_end'      => '',  // <main> 内、アイテムの後
    'main_after'    => '',  // </main> の後
    'footer_before' => '',  // <footer> の前
    'footer_start'  => '',  // <footer> が開く後
    'footer_end'    => '',  // </footer> の前
    'footer_after'  => '',  // </footer> の後
    'body_end'      => '',  // </body> の前
    'html_end'      => '',  // </html> の前
),
```

### 例: Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 マルチ言語サポート
FileLister はブラウザ言語を自動検出し、**18+ 言語** をサポート:

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

`'language' => 'vi'` で固定言語を設定、または自動検出のために空のまま。

---

## 👁️ ファイルプレビュー & ビューア
さまざまなファイルタイプ用の統合ハイパフォーマンスビューア:
- **画像**: jpg, png, gif, webp, svg (グリッドビューでリアルタイムサムネイル)
- **ビデオ**: mp4, webm, avi, mov, mkv
- **オーディオ**: mp3, ogg, flac, wav, m4a
- **ドキュメント**: 統合 PDF ビューアと Markdown レンダリング
- **コード**: Prism.js を使用した 100+ 言語の構文ハイライト

---

## 🔗 共有 & ダウンロード
- モバイルファイル転送用の即時 **QR コード** を生成。
- すべてのファイルの直接ダウンロードリンク。
- ユニーク URL 経由の安全なファイル共有。
- **完全 Unicode サポート**: ベトナム語、中国語、日本語、アラビア語、その他の非 ASCII スクリプトのファイル名は、共有リンクと QR コードで正しくパーセントエンコードされます。

---

## ⌨️ キーボードショートカット
| キー | アクション |
|-----|--------|
| `/` または `Ctrl+F` | 検索ボックスにフォーカス |
| `Esc` | モーダルを閉じる / 検索をクリア |
| `↑` / `↓` | アイテムをナビゲート |
| `Enter` | 選択されたアイテムを開く |
| `g` そして `h` | ホームへ行く (ルート) |
| `g` そして `u` | ディレクトリレベルを 1 つ上へ |
| `?` | キーボードショートカットヘルプを表示 |

---

## 🛡️ セキュリティ詳細

FileLister は複数の強化セキュリティレイヤーを含む:

| レイヤー | 詳細 |
|-------|--------|
| **パストラバーサル** | `?dir=` 入力は `realpath()` で検証され `$lister_root` に制限。 |
| **CSP Nonce** | すべてのインラインスクリプトにリクエストごとのランダム 128 ビット Nonce。`unsafe-inline` なし。 |
| **レート制限** | 一時ファイルに保存された IP ベースのスロットリング。デフォルト: 60 req/60s。 |
| **信頼できるプロキシ** | `X-Forwarded-For` は明示的に設定されたプロキシ IP からのみ信頼。 |
| **機密ファイル** | `.env`、`.git`、`.htaccess`、PHP ファイルは自動的に隠蔽。 |
| **セキュリティヘッダー** | `X-Frame-Options: SAMEORIGIN`、`X-Content-Type-Options: nosniff`、`Permissions-Policy` でカメラ/マイク/地理を無効化。 |
| **HSTS** | HTTPS 上の場合自動的に `Strict-Transport-Security` を送信。 |
| **CORS** | エクスポートエンドポイントは same-origin リクエストのみ許可。任意の origin 反射なし。 |
| **古いハッシュなし** | MD5 と SHA-1 はデフォルトハッシュタイプから除外。 |
| **Symlink 保護** | フォルダトラバーサル中に Symlink をスキップしてループとリークを防ぐ。 |
| **Dev モード** | 本番で `enable_dev: false` がエラー表示を無効化。 |

> [!IMPORTANT]
> セットアップ後、すぐに `'enable_dev' => false` を設定して、エラーメッセージがサーバー内部を公開しないように。

---

## 📋 要件
- **PHP**: 5.2 以上 (PHP 8.4+ までテスト)
- **拡張**: `json` (必須), `gd` (オプション — サムネイル用), `zip` (オプション)

---

## 📜 変更ログ

### v1.5.36 — セキュリティ & バグ修正バージョン

**セキュリティ修正:**
- 🔒 **[クリティカル] `?export=` エンドポイントの CORS 反射脆弱性を修正** — 任意の `Origin` ヘッダーを反映しない
- 🔒 **[クリティカル] ファイルプレビューでの XSS を修正** — "サポートされていないタイプ" プレビューでファイル名が DOM 挿入前にエスケープされなかった
- 🔒 **[クリティカル] `enable_dev` がデフォルトで `false`** — 本番での偶発的な PHP エラー開示を防ぐ
- 🔒 **[高] `dir_theme` Cookie を使用前に検証** 予期しない動作を防ぐ

**バグ修正:**
- 🐛 **Unicode 名のファイルの QR コード生成失敗を修正** (ベトナム語、中国語、日本語など)
- 🐛 **Unicode/非 ASCII ファイル名の共有リンク破損を修正**
- 🐛 **Unicode ファイル名の画像プレビュー読み込みを修正**
- 🐛 **フッター HTML の重複 `</div>` タグを修正** (一部のブラウザでレイアウト問題を引き起こす)
- 🐛 **`style.css` が 2 回読み込まれるを修正** (帯域浪費、二重解析)
- 🐛 **`Standalone.php` ビルドで欠落した `custom.js` / `custom.css` を修正**
- 🐛 **テーマ復元を修正** — `dracula`、`nord`、`high-contrast`、`cute` テーマがページリロード時にリセットされない
- 🐛 **グリッドビューでサムネイルと共に注入された重複 SVG アイコンを修正**
- 🐛 **AJAX ナビゲーション設定解析を修正** — 脆弱なインデックスベースの抽出の代わりに堅牢な正規表現
- 🐛 **`previewText()` が 404 HTML を表示するを修正** ファイルがアクセス不能な場合のファイル内容として
- 🐛 **存在しない `langToggle` 要素を参照するデッドコード `changeLanguage()` を修正**
- 🐛 **SHA-512/224 と SHA-512/256 を追加** ハッシュアルゴリズムマップへ (ドキュメントにリストされているがコードに欠落)
- 🐛 **クリップボードコピーでの `alert()` 呼び出しを置き換え** 非ブロックトースト通知で
- 🐛 **画像ギャラリーナビゲーションを修正** — フィルター/検索で隠された画像が prev/next トラバーサルから除外される
- 🐛 **`audio`/`video` プレビューを修正** — メディアが読み込みに失敗した場合のエラーハンドラを追加

---

## ☕ 私の仕事をサポート
このオープンソース PHP スクリプトを楽しんでいますか?
- [🍻 を買ってください](https://buymeacoffee.com/trong)
- ❤️ [PayPal](https://paypal.me/DaoVanTrong) 経由で寄付

---

## 📝 ライセンス
MIT ライセンス — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
