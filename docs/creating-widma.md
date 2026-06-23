# Creating a New Widmo (Visual Personality)

A widmo is a complete visual personality for Spectral UI — colors, typography, shadows, animation parameters. Creating one takes < 10 minutes.

## Steps

### 1. Copy the template

```bash
cp -r spectral-ui/docs/widmo-template spectral-ui/src/themes/my-widmo
```

### 2. Fix import paths

In `_tokens.scss`, change the `@use` paths from `../../src/tokens/*` to `../../tokens/*`:

```scss
// Change this:
@use '../../src/tokens/colors' as *;
// To this:
@use '../../tokens/colors' as *;
```

### 3. Fill `_tokens.scss`

Fill all empty CSS custom property values. Required:

| Group | Variables |
|-------|-----------|
| Backgrounds (4) | `--color-bg`, `--color-bg-surface`, `--color-bg-elevated`, `--color-bg-overlay` |
| Text (4) | `--color-text`, `--color-text-muted`, `--color-text-subtle`, `--color-text-inverse` |
| Brand (4) | `--color-brand`, `--color-brand-hover`, `--color-brand-glow`, `--color-brand-rgb` |
| Accent (2) | `--color-accent`, `--color-accent-hover` |
| Borders (3) | `--color-border`, `--color-border-focus`, `--color-border-hover` |
| Semantic (8) | `--color-success/bg`, `--color-warning/bg`, `--color-error/bg`, `--color-info/bg` |
| RGB variants (4) | `--color-info-rgb`, `--color-success-rgb`, `--color-warning-rgb`, `--color-error-rgb` |
| Elevation (6) | `--shadow-elevation-0` … `--shadow-elevation-5` |
| Glow (4) | `--glow-sm/md/lg/xl-size` |
| Effects | `--ff-*`, `--pt-*`, `--vrt-*`, `--mg-*` |

WCAG checklist:
- Text on background: min contrast 4.5:1 → https://webaim.org/resources/contrastchecker/
- UI elements on background: min contrast 3:1
- `--color-brand-rgb` must be the R, G, B values of `--color-brand`

### 4. Edit `_fonts.scss`

```scss
@import url('https://fonts.googleapis.com/css2?family=YourFont:wght@400;700&display=swap');
```

Update `--font-family-display`, `--font-family-body`, `--font-family-mono` in `_tokens.scss`.

### 5. Edit `meta.json`

```json
{
  "name": "My Widmo",
  "slug": "my-widmo",
  "description": "Short description.",
  "mode": "dark",
  "accent": "#hexcolor"
}
```

### 6. Build

From the Concrete-Spectral repo root:

```bash
./build/build-themes.sh my-widmo
```

Output: `themes/spectral/css/my-widmo/main.css` and `main.js`

### 7. Deploy

Upload `themes/spectral/css/my-widmo/` to your server at:
```
[cms-root]/application/themes/spectral/css/my-widmo/
```

### 8. Activate in CMS

Dashboard → System & Settings → Sites → Attributes → Set **Spectral Theme (Widmo)** to `my-widmo`.

## Animation Configuration

Animations are **on by default**. Control per-widmo:

| Token | Effect |
|-------|--------|
| `--ff-speed` | Fireflies speed multiplier (1 = normal) |
| `--pt-speed` | Particles speed multiplier |
| `--vrt-speed` | Vertigo speed multiplier |
| `--mg-speed` | Gradient mesh animation duration |
| `--mg-opacity` | Gradient mesh opacity (0–1) |
| `--ff-count` | Number of fireflies |
| `--pt-count` | Number of particles |

To disable all effects site-wide: Dashboard → System & Settings → Sites → Attributes → Set **spectral_reduce_motion** to `1` (requires Phase 5 implementation).
