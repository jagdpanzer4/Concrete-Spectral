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
| 2 — Native blocks | 🔜 | Custom templates for 15 native CMS blocks |
| 3 — Simple custom blocks | 🔜 | spectral_hero, card_grid, cta, stats, typography |
| 4 — Complex custom blocks | 🔜 | slider, accordion, gallery, nav_mega |
| 5 — Effects & atoms | 🔜 | Effects blocks, per-block atom pickers |
| 6 — QA & docs | 🔜 | spectral-light QA, WCAG, full docs |
