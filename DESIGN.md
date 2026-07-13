---
name: Ohene Adjei Effah — Portfolio
description: A stark, minimalist portfolio relying on typography and whitespace.
colors:
  ink: "#000000"
  softened-ink: "#1a1a1a"
  linen: "#ffffff"
  deep-linen: "#f5f5f5"
  gray-500: "#6b7280"
typography:
  display:
    fontFamily: "Outfit, sans-serif"
    fontSize: "clamp(2.25rem, 5vw, 3rem)"
    fontWeight: 600
    lineHeight: 1.1
    letterSpacing: "-0.01em"
  headline:
    fontFamily: "Outfit, sans-serif"
    fontSize: "1.875rem"
    fontWeight: 600
    lineHeight: 1.15
  title:
    fontFamily: "Outfit, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 600
    lineHeight: 1.25
  body:
    fontFamily: "Outfit, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.6
  label:
    fontFamily: "Outfit, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 500
    letterSpacing: "0.05em"
rounded:
  md: "8px"
  lg: "12px"
  xl: "16px"
  2xl: "24px"
  full: "9999px"
spacing:
  gutter: "28px"
  card: "24px"
  section: "80px"
---

# Design System: Ohene Adjei Effah — Portfolio

## 1. Overview

**Creative North Star: "High-Contrast Minimalism"**

This portfolio adopts a high-contrast minimalist aesthetic. All decorative elements (background patterns, circuit lines, colored accents, heavy shadows) have been removed.

The system relies entirely on:
- High-contrast black and white sections (e.g. pitch-black hero sections, stark white content).
- The **Outfit** font family across all typographic hierarchies.
- Generous whitespace combined with sharp, distinct hairlines (`border-black/10` or `border-white/10`) for brutalist component separation.

## 2. Colors

The palette is strictly high-contrast grayscale.
- **Ink / Black:** Primary text on light sections, background for Hero/Footer/CTAs to create impact.
- **White:** Primary background for content areas, text on dark sections.
- **Grays:** Used for subtle borders (`border-black/10`), secondary meta text (`text-gray-500` or `text-gray-400`), and subtle hover states.

There are no decorative accent colors (no gold, forest, or rust).

## 3. Typography

**Exclusive Font:** Outfit (with `sans-serif` fallback)

We use the geometric and highly legible Outfit font across every level of typography:
- Display headings and Hero text
- Body paragraphs
- Monospaced elements and labels

## 4. Elevation

The design is completely flat. 
- There are **no drop shadows** or glows anywhere. 
- Component separation is achieved strictly through thin borders (`border-black/5` or `border-black/10`) and negative space.
- Hover interactions are simple scale/translate transforms or subtle background color changes (e.g., solid black button softening to dark gray on hover).

## 5. Components

### Buttons
- **Shape:** Full pill (`9999px`).
- **Primary:** Black background, white text. Softens slightly on hover (`hover:bg-gray-800`).
- **Ghost / Outline:** Transparent with a thin black border, inverts to black on hover.

### Cards / Containers
- **Corner Style:** 16px (`rounded-xl`).
- **Background:** Clean white.
- **Border:** 1px `black/10`.
- **Shadows:** None.

### Navigation
- **Style:** Clean white with a hairline bottom border.
- **Links:** Black text, relying on standard typographic hierarchy.

## 6. Do's and Don'ts

### Do:
- **Do** let whitespace define the layout.
- **Do** stick exclusively to the Outfit font.
- **Do** use simple geometric borders.

### Don't:
- **Don't** add shadows or 3D effects.
- **Don't** introduce complex color palettes or gradients.
- **Don't** add background textures or decorative SVG dividers.
