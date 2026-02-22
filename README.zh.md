<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_)__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 FileLister by TRONG.PRO
-->

# 📂 FileLister: 现代 PHP 目录列表脚本 v1.5.36

FileLister 是一个强大、轻量级且现代的 **PHP 目录列表脚本**，将您的服务器文件转换为美观、移动友好的 **Web 文件浏览器**。它是 `h5ai` 或 `Apache Index` 的完美替代品，提供单文件部署选项和内置文件预览功能。

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Version](https://img.shields.io/badge/version-1.5.36-orange)
[![GitHub](https://img.shields.io/badge/GitHub-Repo-181717?logo=github)](https://github.com/daovantrong/filelister)

[🇬🇧 English](README.md) | [🇻🇳 Tiếng Việt](README.vi.md) | [🇨🇳 简体中文](README.zh.md) | [🇪🇸 Español](README.es.md) | [🇫🇷 Français](README.fr.md) | [🇩🇪 Deutsch](README.de.md) | [🇯🇵 日本語](README.ja.md) | [🇰🇷 한국어](README.kr.md) | [🇮🇹 Italiano](README.it.md) | [🇳🇱 Nederlands](README.nl.md) | [🇸🇪 Svenska](README.sv.md) | [🇳🇴 Norsk](README.no.md) | [🇩🇰 Dansk](README.da.md) | [🇫🇮 Suomi](README.fi.md) | [🇮🇱 עברית](README.he.md) | [🇦🇪 العربية](README.ar.md) | [🇷🇺 Русский](README.ru.md)

---

## 📖 目录
- [✨ 功能](#-功能)
- [📦 安装](#-安装)
- [⚙️ 配置](#-配置)
- [🎨 主题](#-主题)
- [🧩 自定义 HTML 钩子](#-自定义-html-钩子)
- [🌍 多语言支持](#-多语言支持)
- [👁️ 文件预览](#-文件预览--viewer)
- [🔗 分享 & 下载](#-分享--下载)
- [⌨️ 键盘快捷键](#-键盘快捷键)
- [🛡️ 安全细节](#-安全细节)
- [📋 要求](#-要求)

---

## ✨ 功能

### 🚀 **生产就绪 & 快速**
- **独立版本**：单文件部署（`Standalone.php`），所有资源已嵌入。运行 `php build.php` 生成。
- **Docker 支持**：现成的 `Dockerfile` 和 `docker-compose.yml`。
- **服务索引**：可选服务 `index.html`（如果目录中存在）。

### 🎨 **现代用户界面**
- **干净 & 响应式**：移动优先布局，在任何设备上工作。
- **9 个主题**：`light`、`dark`、`auto`、`ocean`、`forest`、`dracula`、`nord`、`high-contrast`、`cute`（动漫玻璃拟态）。
- **网格 & 列表视图**：在卡片网格和详细列表视图之间切换。
- **README 渲染**：自动在目录列表底部渲染 `README.md` 文件。
- **本地化**：语言选择器，支持 18+ 种语言环境。

### 🛡️ **安全性增强**
- **CSP 与 Nonces**：每个请求对所有内联脚本使用加密 nonce。没有 `unsafe-inline`。
- **速率限制**：内置反 DDoS 请求节流（默认 60 req/60s）。
- **可信代理**：安全 `X-Forwarded-For` 处理 — 仅在请求来自可信代理 IP 时应用。
- **路径遍历保护**：所有 `?dir=` 输入通过 `realpath()` 解析并约束到 `$lister_root`。
- **敏感文件隐藏**：自动忽略 `.env`、`.git`、`.htaccess` 和 PHP 文件。
- **安全头**：`X-Frame-Options`、`X-Content-Type-Options`、`X-XSS-Protection`、`Referrer-Policy`、`Permissions-Policy`、`Strict-Transport-Security`（仅 HTTPS）。
- **无 MD5/SHA-1**：默认哈希集设置为 `CRC32,XXH128,SHA-256,SHA3-256`。MD5 和 SHA-1 默认排除。

### 🔍 **文件完整性（信息 & 哈希）**
- 验证每个文件的 40+ 哈希算法，包括 SHA-3、WHIRLPOOL、XXH128、CRC32。
- 可配置的最大文件大小用于哈希。
- 结果在内联信息模态框中显示。

### 📤 **导出 & 分享**
- 以 **JSON、CSV、TSV、NDJSON** 格式复制/下载文件列表。
- 通过 QR 码和直接链接分享文件。

---

## 📦 安装 & 部署模式

FileLister 支持 4 种部署模式。选择适合您配置的那个：

---

### 模式 1：独立（单 PHP 文件） — 推荐用于生产

所有资源编译成一个自包含文件。不需要 `_/` 文件夹。

```bash
# 步骤 1：构建独立文件
php build.php

# 步骤 2：将 Standalone.php 上传到您的服务器
# 步骤 3：重命名为 index.php（或您喜欢的任何名称）
```

> **配置**：自动设置 `'use_embedded' => true`。无需其他配置。

---

### 模式 2：正常（源文件）

经典多文件配置。最快用于开发。

```
your-web-root/
├── index.php        ← 入口点（require_once 'core.php'）
├── core.php         ← 核心逻辑 & 配置
└── _/               ← CSS、JS、图标、翻译文件
```

**步骤：**
1. 将 `index.php`、`core.php` 和 `_/` 复制到您的 Web 目录。
2. 通过浏览器访问：`http://yoursite.com/`
3. 无需额外配置。

---

### 模式 3：子目录部署

在索引其自身内容的子文件夹中运行 FileLister。

```
your-web-root/
├── files/           ← 您想要索引的目录
│   ├── index.php    ← FileLister 入口点
│   └── core.php
└── _/               ← 共享资产（通过父级扫描自动检测）
```

`detect_assets_path()` 函数自动扫描 **最多 5 个父目录** 以定位 `_/` 资产文件夹。在大多数情况下无需手动 `assets_path` 配置。

如果资产未自动检测：
```php
'assets_path' => '../_',   // 或完整路径如 '/var/www/html/_'
```

---

### 模式 4：全局部署（索引服务器上的任何目录）

使用 **单个 FileLister 安装** 浏览服务器上的任何路径，与脚本位置分离。

```
/var/www/html/
├── filelister/      ← FileLister 住在这里
│   ├── index.php
│   ├── core.php
│   └── _/
└── data/            ← 您实际想要索引的目录
```

**在 `core.php` 中的配置：**
```php
'base_path' => '/var/data',   // ← 设置您想要列出的目录
```

> `base_path` 接受任何 **绝对文件系统路径**，PHP 进程可以读取。脚本将通过 `realpath()` 执行所有 `?dir=` 导航保持在此根目录内，以防止路径遍历。

**Web 服务器配置**（使用 FileLister 作为目录索引）：

**Nginx：**
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

**Apache（目标目录中的 `.htaccess`）：**
```apache
DirectoryIndex index.php FileLister.php index.html

# 将所有目录请求路由到 FileLister：
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ /filelister/index.php [QSA,L]
```

---

### 模式 5：Docker

```bash
docker-compose up -d
```

在 `http://localhost:8080` 访问。编辑 `docker-compose.yml` 以挂载您的目标目录。

---

### 部署模式比较

| 模式 | 需要文件 | 最佳用于 |
|------|---------------|----------|
| **独立** | 仅 `Standalone.php` | 快速部署，共享主机 |
| **正常** | `index.php` + `core.php` + `_/` | 开发，完整控制 |
| **子目录** | 与正常相同，放置在子文件夹中 | 索引特定子文件夹 |
| **全局** | 正常 + `base_path` 配置 | 单实例索引任何服务器路径 |
| **Docker** | `Dockerfile` + `docker-compose.yml` | 容器化环境 |

---

## ⚙️ 配置

所有设置在 `core.php`（或 `Standalone.php`）中的 `$config` 数组里。

### 通用

| 键 | 默认 | 描述 |
|-----|---------|-------------|
| `title` | `''` | 自定义页面标题。如果为空，从路径自动生成。 |
| `title_prefix` | `'Index of'` | 自动生成标题的前缀。 |
| `title_suffix` | `' - FileLister'` | 自动生成标题的后缀。 |
| `language` | `''` | 强制语言环境（`en`、`vi`、`zh`、`ja`…）。如果为空，自动检测。 |
| `allowed_langs` | (18 种语言) | 选择器下拉菜单中可用的语言。 |
| `theme` | `'ocean'` | 默认主题。选项：`light`、`dark`、`auto`、`ocean`、`forest`、`dracula`、`nord`、`high-contrast`、`cute`。 |
| `view_mode` | `'list'` | 默认视图。选项：`grid`、`list`。 |
| `timezone` | `'Asia/Ho_Chi_Minh'` | PHP 时区字符串。 |
| `date_format` | `'Y-m-d H:i:s'` | PHP 日期格式字符串。 |
| `base_path` | `''` | 全局/子目录部署的根目录。 |
| `favicon_path` | `''` | 到自定义 favicon 的路径。 |

### 显示选项

| 键 | 默认 | 描述 |
|-----|---------|-------------|
| `show_hidden` | `false` | 显示隐藏文件（以 `.` 开头）。 |
| `show_size` | `true` | 显示文件大小列。 |
| `show_date` | `true` | 显示最后修改日期列。 |
| `show_type` | `true` | 显示文件类型列（列表视图）。 |
| `show_folder_size` | `true` | 计算文件夹大小（递归 — 对于大文件夹可能慢）。 |
| `show_breadcrumb` | `true` | 显示导航 breadcrumb。 |
| `show_footer` | `true` | 显示页脚栏。 |
| `show_copyright` | `true` | 在页脚显示版权信息。 |
| `show_language_selector` | `true` | 显示语言切换器控件。 |
| `show_theme_selector` | `true` | 显示主题切换按钮。 |

### 功能

| 键 | 默认 | 描述 |
|-----|---------|-------------|
| `enable_search` | `true` | 启用实时文件搜索。 |
| `enable_preview` | `true` | 启用文件预览模态框（图像、视频、音频、PDF、代码）。 |
| `enable_download` | `true` | 在文件上显示下载按钮。 |
| `enable_share` | `true` | 启用带有 QR 码的文件共享模态框。 |
| `enable_qrcode` | `true` | 在共享模态框中生成 QR 码。 |
| `enable_shortcuts` | `true` | 启用键盘快捷键。 |
| `enable_export` | `true` | 启用导出/复制文件列表（JSON、CSV、TSV、NDJSON）。 |
| `enable_readme` | `true` | 在目录列表底部渲染 `README.md` 文件。 |
| `enable_hashtype` | `'CRC32,XXH128,SHA-256,SHA3-256'` | 哈希算法的逗号分隔列表。支持：`MD5`、`SHA-1`、`SHA-256`、`SHA-512`、`SHA-512/224`、`SHA-512/256`、`SHA3-256`、`WHIRLPOOL`、`CRC32`、`XXH128`，以及 30+ 其他。 |
| `hash_uppercase` | `true` | 以大写显示哈希值。 |
| `max_hash_size` | `1000` | 允许哈希的最大文件大小（MB）。 |

### 安全

| 键 | 默认 | 描述 |
|-----|---------|-------------|
| `ignore_files` | (见下文) | 要隐藏的文件。默认包括 `index.php`、`.htaccess`、`.htpasswd`、`.git`、`.env`。 |
| `ignore_extensions` | `['php']` | 要隐藏的扩展。 |
| `ignore_folders` | `['_', '.git', '.svn', 'node_modules', 'vendor']` | 要隐藏的文件夹。 |
| `allowed_extensions` | `[]` | 扩展白名单（空 = 允许所有）。 |
| `protected_paths` | `['/etc', '/var/www/.git']` | 始终阻塞的绝对路径。 |
| `enable_rate_limit` | `true` | 启用基于 IP 的速率限制。 |
| `rate_limit_requests` | `60` | 每个窗口的最大请求数。 |
| `rate_limit_period` | `60` | 速率限制时间窗口（秒）。 |
| `rate_limit_exclude_ips` | `['127.0.0.1', '::1']` | 免于速率限制的 IP。 |
| `trusted_proxies` | `[]` | 允许设置 `X-Forwarded-For` 的 IP。空 = 不信任任何人。 |
| `enable_dev` | `true` | **⚠️ 在生产中设置为 `false`。** 启用 PHP 错误显示和禁用缓存。 |

> [!CAUTION]
> 在部署到生产之前，始终设置 `'enable_dev' => false`。在开发模式中，PHP 错误被显示，这可以向访问者暴露文件路径、配置细节和堆栈跟踪。

### 高级

| 键 | 默认 | 描述 |
|-----|---------|-------------|
| `assets_path` | `''` | 到 `_/` 资产文件夹的路径。如果为空，自动检测。 |
| `use_embedded` | `false` | 强制嵌入资产模式（由 `Standalone.php` 使用）。 |
| `thumbnail_directory` | `''` | 缩略图缓存的自定义路径。如果为空，自动设置为 `_/thumbs`。 |
| `thumbnail_width` | `200` | 最大缩略图宽度（px）。 |
| `thumbnail_height` | `200` | 最大缩略图高度（px）。 |
| `thumbnail_cache_expiry` | `30` | 在缓存缩略图被清除前的天数。`0` = 总是清理。`-1` = 从不清理。 |
| `readme_files` | (列表) | 要扫描 README 渲染的文件名。 |
| `custom_css` | `'_/css/custom.css'` | 到自定义 CSS 文件的路径（如果存在则加载）。 |
| `custom_js` | `'_/js/custom.js'` | 到自定义 JS 文件的路径（如果存在则加载）。 |
| `serve_index_files` | `false` | 如果存在，直接服务 `index.html`。⚠️ 如果存在不可信文件，可能有 XSS 风险。 |
| `index_files` | `['index.html', …]` | 要查找的索引文件名。 |

### 将服务器配置为目录索引

#### Nginx
```nginx
index index.php FileLister.php index.html;
```

#### Apache（`.htaccess`）
```apache
DirectoryIndex index.php FileLister.php index.html
```

### 允许外部主机（CSP）
FileLister 使用严格的 **内容安全策略**。要从外部域加载资源，在 `core.php` 中编辑 `Content-Security-Policy` 头：

```php
// 将您的域添加到适当的指令中：
// img-src：外部图像
// script-src：外部脚本（谨慎使用）
// style-src：外部 CSS
```

---

## 🎨 主题定制

### 可用主题
| 主题 | 描述 |
|-------|-------------|
| `light` | 干净的白色主题 |
| `dark` | 黑暗模式 |
| `auto` | 跟随系统偏好 |
| `ocean` | 蓝色海洋色调 |
| `forest` | 绿色地球色调 |
| `dracula` | 德古拉深紫色 |
| `nord` | 北欧北极调色板 |
| `high-contrast` | 无障碍焦点 |
| `cute` | 带有背景图像的动漫玻璃拟态 |

### 创建自定义主题

1. **复制主题**：复制 `_/css/themes/ocean.css` → `_/css/themes/mytheme.css`。

2. **编辑 CSS 变量**：
```css
[data-theme="mytheme"] {
    --bg-primary: #1a1a2e;
    --accent-primary: #e94560;
    /* ... 其他变量 */
}
```

3. **在 JS 中注册**：将您的主题名称添加到 `_/js/app.js` 中 `toggleTheme()` 数组。

4. **在配置中激活**：
```php
'theme' => 'mytheme',
```

5. **在配置中白名单**（主题选择器工作）：在 `index.php` 中，搜索 `$allowed_themes` 并将 `'mytheme'` 添加到数组。

---

## 🧩 自定义 HTML 钩子

在不编辑核心文件的情况下，在特定页面位置注入自定义 HTML、CSS 或 JavaScript。在 `core.php` 中配置 `html_hooks` 数组：

```php
'html_hooks' => array(
    'head_end'      => '',  // 在 </head> 之前
    'body_start'    => '',  // 在 <body> 之后
    'header_start'  => '',  // 在 <header> 打开后
    'header_end'    => '',  // 在 </header> 之前
    'main_before'   => '',  // 在 <main> 之前
    'main_start'    => '',  // 在 <main> 内，项目之前
    'main_end'      => '',  // 在 <main> 内，项目之后
    'main_after'    => '',  // 在 </main> 之后
    'footer_before' => '',  // 在 <footer> 之前
    'footer_start'  => '',  // 在 <footer> 打开后
    'footer_end'    => '',  // 在 </footer> 之前
    'footer_after'  => '',  // 在 </footer> 之后
    'body_end'      => '',  // 在 </body> 之前
    'html_end'      => '',  // 在 </html> 之前
),
```

### 示例：Google Analytics
```php
'head_end' => '<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","G-XXXXXX");</script>',
```

---

## 🌍 多语言支持
FileLister 自动检测浏览器语言并支持 **18+ 种语言**：

`en` `vi` `zh` `ja` `ko` `es` `fr` `de` `it` `nl` `sv` `no` `da` `fi` `he` `ar` `ru`

使用 `'language' => 'vi'` 设置固定语言，或留空以自动检测。

---

## 👁️ 文件预览 & 查看器
集成高性能查看器用于各种文件类型：
- **图像**：jpg、png、gif、webp、svg（网格视图中实时缩略图）
- **视频**：mp4、webm、avi、mov、mkv
- **音频**：mp3、ogg、flac、wav、m4a
- **文档**：内置 PDF 查看器和 Markdown 渲染
- **代码**：通过 Prism.js 为 100+ 语言语法高亮

---

## 🔗 分享 & 下载
- 生成即时 **QR 码** 用于移动文件传输。
- 所有文件的直接下载链接。
- 通过唯一 URL 安全文件共享。
- **完整 Unicode 支持**：文件名在越南语、中文、日语、阿拉伯语和其他非 ASCII 脚本中正确百分比编码在分享链接和 QR 码中。

---

## ⌨️ 键盘快捷键
| 键 | 操作 |
|-----|--------|
| `/` 或 `Ctrl+F` | 聚焦搜索框 |
| `Esc` | 关闭模态框 / 清除搜索 |
| `↑` / `↓` | 通过项目导航 |
| `Enter` | 打开选定项目 |
| `g` 然后 `h` | 回家（根） |
| `g` 然后 `u` | 向上一级目录 |
| `?` | 显示键盘快捷键帮助 |

---

## 🛡️ 安全细节

FileLister 包括多个强化安全层：

| 层 | 细节 |
|-------|--------|
| **路径遍历** | `?dir=` 输入通过 `realpath()` 验证并约束到 `$lister_root`。 |
| **CSP Nonce** | 每个请求对所有内联脚本的 128 位随机 nonce。没有 `unsafe-inline`。 |
| **速率限制** | 在临时文件中存储的基于 IP 的节流。默认：60 req/60s。 |
| **可信代理** | `X-Forwarded-For` 仅信任来自明确配置的代理 IP。 |
| **敏感文件** | `.env`、`.git`、`.htaccess`、PHP 文件自动隐藏。 |
| **安全头** | `X-Frame-Options: SAMEORIGIN`、`X-Content-Type-Options: nosniff`、`Permissions-Policy` 以禁用相机/麦克风/地理。 |
| **HSTS** | `Strict-Transport-Security` 在 HTTPS 上自动发送。 |
| **CORS** | 导出端点仅允许同源请求。没有任意源反射。 |
| **无旧哈希** | MD5 和 SHA-1 从默认哈希类型中排除。 |
| **符号链接保护** | 在文件夹遍历中跳过符号链接以防止循环和泄漏。 |
| **开发模式** | 在生产中 `enable_dev: false` 禁用错误显示。 |

> [!IMPORTANT]
> 设置后，立即设置 `'enable_dev' => false` 以防止错误消息暴露服务器内部。

---

## 📋 要求
- **PHP**：5.2 或更高（测试至 PHP 8.4+）
- **扩展**：`json`（必需）、`gd`（可选 — 用于缩略图）、`zip`（可选）

---

## 📜 更新日志

### v1.5.36 — 安全 & 错误修复版本

**安全修复：**
- 🔒 **[严重] 修复 `?export=` 端点的 CORS 反射漏洞** — 不再反射任意 `Origin` 头
- 🔒 **[严重] 修复文件预览中的 XSS** — “不支持类型”预览中的文件名在插入 DOM 之前未转义
- 🔒 **[严重] `enable_dev` 现在默认为 `false`** — 防止在生产中意外 PHP 错误披露
- 🔒 **[高] 在使用前验证 `dir_theme` cookie** 以防止意外行为

**错误修复：**
- 🐛 **修复 Unicode 名称文件的 QR 码生成失败**（越南语、中文、日语等）
- 🐛 **修复 Unicode/非 ASCII 文件名的分享链接损坏**
- 🐛 **修复 Unicode 文件名的图像预览不加载**
- 🐛 **修复页脚 HTML 中的重复 `</div>` 标签**（在某些浏览器中造成布局问题）
- 🐛 **修复 `style.css` 被加载两次**（浪费带宽，双重解析）
- 🐛 **修复 `Standalone.php` 构建中缺失的 `custom.js` / `custom.css`**
- 🐛 **修复主题恢复** — `dracula`、`nord`、`high-contrast`、`cute` 主题不再在页面重新加载时重置
- 🐛 **修复网格视图中与缩略图一起注入的重复 SVG 图标**
- 🐛 **修复 AJAX 导航配置解析** — 更健壮的正则表达式而不是脆弱的基于索引的提取
- 🐛 **修复 `previewText()` 显示 404 HTML** 作为文件内容，当文件不可访问时
- 🐛 **修复引用不存在 `langToggle` 元素的死代码 `changeLanguage()`**
- 🐛 **添加 SHA-512/224 和 SHA-512/256** 到哈希算法映射（在文档中列出但在代码中缺失）
- 🐛 **用非阻塞 toast 通知替换 `alert()` 调用** 在剪贴板复制中
- 🐛 **修复图像库导航** — 被过滤器/搜索隐藏的图像现在从 prev/next 遍历中排除
- 🐛 **修复 `audio`/`video` 预览** — 添加错误处理程序，当媒体无法加载时

---

## ☕ 支持我的工作
喜欢这个开源 PHP 脚本？
- [给我买 🍻](https://buymeacoffee.com/trong)
- 通过 ❤️ [PayPal](https://paypal.me/DaoVanTrong) 捐赠

---

## 📝 许可证
MIT 许可证 — © 2026 [TRONG.PRO](https://trong.pro)

<!--
  ___ _ _     _    _    _           
 | __(_) |___| |  (_).__| |_ ___ _ _ 
 | _|| | / -_) |__| (_-<  _/ -_) '_|
 |_| |_|_\___|____|_/__/\__\___|_|  
 End FileLister README
-->
