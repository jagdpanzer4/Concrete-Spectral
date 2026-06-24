# Concrete-Spectral

> ConcreteCMS 9.x theme powered by the [Spectral UI](https://github.com/jagdpanzer4/Spectral-UI) design system.  
> Every standard CMS block is restyled to match Spectral UI tokens. Seven bespoke blocks add functionality unavailable in core CMS.

## Features

- **Swappable widma** — switch between dark (*Spectral Chromatic*) and light (*Spectral Light*) visual personalities from the CMS admin panel
- **20 native block templates** — every standard ConcreteCMS block styled with Spectral UI BEM classes
- **7 custom Spectral blocks** — tabs, gallery/lightbox, feature strip, alert, social links, orbital, background effects
- **3 page templates** — `full_width`, `full` (with sidebar), `landing`
- **Alpine.js** — bundled in theme, zero external JS runtime required
- **Shared hosting ready** — no runtime npm or Composer required; static CSS + vanilla PHP

---

## Requirements

| Requirement | Version |
|-------------|---------|
| ConcreteCMS | 9.x |
| PHP | 8.1+ |
| Node.js + npm | 18+ *(build-time only)* |

---

## Quick Start (Docker)

```bash
git clone https://github.com/jagdpanzer4/Concrete-Spectral.git
cd Concrete-Spectral
git submodule update --init --recursive
docker compose up -d
# CMS → http://localhost:8080   admin / Spectral2024!
```

---

## Manual Deploy to Existing CMS

### 1. Clone with submodule

```bash
git clone --recurse-submodules https://github.com/jagdpanzer4/Concrete-Spectral.git
```

### 2. Copy files

```
[cms-root]/application/themes/spectral/          ← theme
[cms-root]/packages/spectral_blocks/             ← custom blocks
```

### 3. Activate theme

Dashboard → Pages & Themes → Themes → Activate **Spectral**

### 4. Install Spectral Blocks package

Dashboard → Extend ConcreteCMS → find **Spectral UI Blocks** → Install

### 5. (Optional) Load demo content

```bash
php concrete/bin/concrete5 c5:exec packages/spectral_demo/clean_rebuild.php
```

Browse `/spectral-demo` — sub-pages showcase all blocks.

---

## Available Widma

| Widmo handle | Mode | Description |
|--------------|------|-------------|
| `spectral-chromatic` | **Dark** | Intense violet/cyan palette, glow shadows, full spectrum |
| `spectral-light` | **Light** | Clean whites, soft shadows, violet brand accent |

Switch widmo: Dashboard → Pages & Themes → **Spectral** → Customize → choose widmo.

---

## Native Block Templates (20)

All standard ConcreteCMS block types have Spectral UI templates in `themes/spectral/blocks/`:

| Block handle | Spectral component |
|--------------|--------------------|
| `accordion` | `sui-accordion` + Alpine.js |
| `autonav` | `sui-site-nav` + Alpine.js dropdowns |
| `breadcrumbs` | `sui-breadcrumb` |
| `content` | `sui-body` prose wrapper |
| `feature` | `sui-card` icon + title + text |
| `file` | `sui-file-block` smart icon by extension |
| `form` | `sui-form` inputs, selects, textarea |
| `hero_image` | `sui-hero` full-bleed image + CTA |
| `horizontal_rule` | Spectral border token HR |
| `image` | `sui-figure` with caption |
| `image_slider` | `sui-slider` + Alpine.js carousel |
| `next_previous` | `sui-btn--ghost` / `sui-btn--primary` |
| `page_list` | `sui-card` grid with thumbnails |
| `page_title` | `sui-h` heading with format selector |
| `search` | `sui-input-group` search form |
| `social_links` | `sui-btn--icon` icon links |
| `tags` | `sui-tag` / `sui-chip` |
| `testimonial` | `sui-testimonial` blockquote + avatar |
| `video` | `sui-video-wrapper` HTML5 `<video>` |
| `youtube` | `sui-embed` responsive iframe |

---

## Custom Spectral Blocks (7)

Install via the **Spectral UI Blocks** package (`packages/spectral_blocks/`):

| Block handle | Description |
|--------------|-------------|
| `spectral_tabs` | Tabbed content — `line` and `pills` variants, per-tab HTML, Alpine.js |
| `spectral_gallery` | Image grid / masonry + Alpine.js lightbox with keyboard nav |
| `spectral_feature_strip` | Horizontal icon + title + subtitle strip, optional links |
| `spectral_alert` | Info / success / warning / error banner, dismissible option |
| `spectral_social_links` | 10 platforms (GitHub, X, LinkedIn, Instagram, YouTube, Facebook, TikTok, Discord, Mastodon, Bluesky) with inline SVG |
| `spectral_orbital` | CSS-only 3D rotating orbital showcase — center focus + orbiting items, 3 variants (glow/glass/flat) |
| `spectral_bg_effects` | Section wrapper with animated background — gradient mesh, aurora, radial glow, grid pattern, noise texture, fireflies |

---

## Building Widma

```bash
# Build all widma
./build/build-themes.sh all

# Build one widmo
./build/build-themes.sh spectral-chromatic

# Dev watch mode
./build/watch-theme.sh spectral-chromatic
```

---

## Adding a New Widmo

See [docs/creating-widma.md](docs/creating-widma.md).

---

## Phase Status

| Phase | Status | Scope |
|-------|--------|-------|
| 1 — Foundation | ✅ | Theme skeleton, build pipeline, 2 widma |
| 2 — Native blocks | ✅ | Custom templates for all 20 native CMS blocks |
| 3 — Customizer | ✅ | SkinCustomizerType, CSS skin switching, landing page template |
| 4 — Stabilization | ✅ | Hero button fix, page_list NULL link fix, form BEM aliases |
| 5 — Custom blocks | ✅ | 6 custom Spectral blocks (tabs, gallery, feature strip, alert, social links, orbital) |
| 6 — Background effects | ✅ | `spectral_bg_effects` block, 6 effect types |
