# Concrete-Spectral

> Concrete CMS 9.x theme powered by [Spectral UI](https://github.com/jagdpanzer4/Spectral-UI) design system.

## Features

- **Swappable widma** — change visual personality from CMS admin panel
- **Spectral UI components** as native CMS block types (drag & drop)
- **Native CMS blocks** restyled to match Spectral UI (content, nav, forms, page list, etc.)
- **3 page templates** — full width, with sidebar, landing page
- **Shared hosting ready** — no runtime npm or composer required

## Requirements

- Concrete CMS 9.x
- PHP 8.1+
- Node.js 18+ + npm *(local build time only)*

## Setup

### 1. Clone with submodule

```bash
git clone https://github.com/jagdpanzer4/Concrete-Spectral.git
cd Concrete-Spectral
git submodule update --init --recursive
```

### 2. Deploy theme to CMS

Copy `themes/spectral/` into your CMS installation:
```
[cms-root]/application/themes/spectral/
```

### 3. Register site attribute

```bash
php concrete/bin/concrete5 c5:exec setup/install-attribute.php
```

### 4. Activate theme

Dashboard → Pages & Themes → Themes → Activate **Spectral**

### 5. Set widmo

Dashboard → System & Settings → Sites → Attributes → **Spectral Theme (Widmo)** = `spectral-chromatic`

## Block Templates

All 20 standard ConcreteCMS block types have Spectral UI templates:

| Block | Spectral component |
|-------|--------------------|
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

## Demo Pages

After installing, run the demo content script:

```bash
php concrete/bin/concrete5 c5:exec packages/spectral_demo/clean_rebuild.php
```

Then browse `/spectral-demo` — sub-pages showcase typography, navigation/accordion,
forms, image slider, and media blocks (testimonial, video, file).

## Available Widma

| Widmo | Mode | Description |
|-------|------|-------------|
| `spectral-chromatic` | dark | Intense colors, full spectrum glow |
| `spectral-light` | light | Clean whites, dark text, violet brand |

## Building Widma

```bash
# Build all widma
./build/build-themes.sh all

# Build one widmo
./build/build-themes.sh spectral-chromatic

# Dev watch mode
./build/watch-theme.sh spectral-chromatic
```

## Adding a New Widmo

See [docs/creating-widma.md](docs/creating-widma.md).

## Phase Roadmap

| Phase | Status | Scope |
|-------|--------|-------|
| 1 — Foundation | ✅ | Theme skeleton, build pipeline, 2 widma |
| 2 — Native blocks | ✅ | Custom templates for all 20 native CMS blocks |
| 3 — Polish & extras | 🔄 | Sidebar layout, landing page, docs, theme customizer |
| 4 — Custom blocks | 🔜 | spectral_hero, card_grid, cta, stats |
| 5 — Effects & atoms | 🔜 | Effect blocks, per-block atom pickers |
| 6 — QA & docs | 🔜 | spectral-light QA, WCAG 2.1, full docs |
