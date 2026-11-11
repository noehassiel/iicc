---
name: IICC
description: Public site of the Instituto de Idioma y Cultura China en México, bright, rounded and in motion.
colors:
  patio-blue: "#1f4e8c"
  patio-blue-deep: "#163a6b"
  patio-blue-soft: "#4a78b5"
  bamboo-green: "#7ab648"
  lantern-orange: "#f0a35c"
  nav-ink: "#0f213d"
  ink: "#171717"
  ink-muted: "#525252"
  ink-subtle: "#737373"
  hairline: "#e5e5e5"
  surface-sunken: "#f5f5f5"
  surface-alt: "#fafafa"
  surface: "#ffffff"
typography:
  display:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "clamp(56px, 4.6vw, 90px)"
    fontWeight: 600
    lineHeight: 1.1
  headline:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "3rem"
    fontWeight: 600
    lineHeight: 1
  title:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 600
    lineHeight: 1.4
  body:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.5
  label:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 600
    lineHeight: 1.43
    letterSpacing: "0.05em"
rounded:
  accordion: "12px"
  xl: "12px"
  2xl: "16px"
  panel: "24px"
  full: "9999px"
spacing:
  gutter: "16px"
  card-gap: "16px"
  card-pad: "24px"
  section-sm: "48px"
  section: "64px"
  section-lg: "80px"
components:
  button-whatsapp:
    backgroundColor: "{colors.bamboo-green}"
    textColor: "{colors.surface}"
    typography: "{typography.body}"
    rounded: "{rounded.full}"
    padding: "0 24px"
    height: "40px"
  button-nav-contact:
    backgroundColor: "{colors.patio-blue}"
    textColor: "{colors.surface}"
    rounded: "{rounded.full}"
    padding: "4px 12px"
  chip-anchor:
    textColor: "{colors.surface}"
    rounded: "{rounded.full}"
    padding: "8px 16px"
  locale-toggle-active:
    backgroundColor: "{colors.patio-blue}"
    textColor: "{colors.surface}"
    rounded: "{rounded.full}"
    padding: "4px 10px"
  card-raised:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.2xl}"
    padding: "{spacing.card-pad}"
  card-outlined:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.2xl}"
    padding: "{spacing.card-pad}"
  card-tinted:
    textColor: "{colors.ink}"
    rounded: "{rounded.2xl}"
    padding: "{spacing.card-pad}"
  accordion-item:
    backgroundColor: "{colors.surface-sunken}"
    textColor: "{colors.ink}"
    rounded: "{rounded.accordion}"
    padding: "16px 24px"
---

# Design System: IICC

## Overview

**Creative North Star: "El Patio Abierto"**

The site behaves like the institute's open courtyard: bright white ground, generous air between things, rounded friendly surfaces, and motion as the life happening in it. Client photography is low quality, so the pages do not lean on images. Shape, color, large type and movement carry them instead.

Surfaces are lifted and tactile. The navigation is a translucent, blurred pill that floats above the page; cards sit a step above their ground; the WhatsApp button is a physical green capsule whose arrow slides. Layers should feel like things you could pick up, not flat regions of a grid. Today this is strongest in the header and the animated set pieces (hero, stacked service cards, review carousel, cylindrical event carousel) and lightest on the inner pages, which still use a single faint card shadow.

Chinese is always Traditional and always set in a Kai (brush-style) face, sitting beside the Latin sans rather than replacing it. Large Kai characters also appear as graphic elements.

**Key Characteristics:**
- White ground, three brand colors, neutral grays for everything else.
- One typeface in one working weight (semibold) for all headings.
- Rounded everywhere: 16px corners on surfaces, full pills on anything clickable.
- Floating layers: translucency, blur and soft shadow mark what sits above the page.
- Motion is part of the system, with reduced-motion fallbacks.
- Mobile-first.

## Colors

A cool institutional blue does the structural work, with green reserved for the action that matters and orange as a small warm accent.

### Primary
- **Patio Blue** (`patio-blue`): the brand's working color. Eyebrows, text links, the nav Contact pill, the active language, full-bleed hero and CTA bands, focus rings.
- **Deep Patio Blue** (`patio-blue-deep`): defined as the darker step of the blue; not yet used in the views.
- **Soft Patio Blue** (`patio-blue-soft`): the glow behind the cylindrical event carousel.

### Secondary
- **Bamboo Green** (`bamboo-green`): the WhatsApp call to action, and only that. Also tags the Adolescentes entry in the nav flyout.

### Tertiary
- **Lantern Orange** (`lantern-orange`): small warm accents. Review stars, accordion numerals, the radial glow in the hero fallback, the Niños flyout tile.

### Neutral
- **Ink** (`ink`): headings and body text on light surfaces.
- **Muted Ink** (`ink-muted`): supporting paragraphs and descriptions. The most used text color on the site.
- **Subtle Ink** (`ink-subtle`): inactive controls and tertiary text.
- **Nav Ink** (`nav-ink`): text inside the navigation pill, a blue-tinted near-black.
- **Hairline** (`hairline`): borders on outlined cards, carousel tracks and control surfaces.
- **Sunken Surface** (`surface-sunken`): image placeholders and accordion items.
- **Alternate Surface** (`surface-alt`): the background of every other section.
- **Surface** (`surface`): the page ground and raised cards.

### Named Rules
**The Green Means WhatsApp Rule.** Bamboo Green fills a button only when that button opens WhatsApp or is the hero's primary action. It is never a decorative fill.

**The Provisional Footer Note.** The footer currently uses its own warm paper and ink tones and oversized type. It is still being worked out. Those colors are not system tokens and must not be reused elsewhere until the footer is settled.

## Typography

**Display Font:** Instrument Sans (with ui-sans-serif, system-ui, sans-serif)
**Body Font:** Instrument Sans
**Chinese Font:** Kai, resolved from system faces as "IICC Kai" (Kaiti TC, BiauKai, DFKai-SB, 標楷體, KaiTi, STKaiti), scaled up 118% so it reads at the same size as the Latin beside it.

**Character:** One friendly geometric sans does everything in Latin script, almost always in semibold. The contrast comes from the Kai brush characters next to it, not from a second Latin face.

### Hierarchy
- **Display** (600, clamp 56px to 90px, 44px on phones, line-height 1.1): the home hero headline only.
- **Headline** (600, 1.875rem on phones to 3rem from `sm`, balanced wrapping): each inner page's h1.
- **Section heading** (600, 1.5rem to 1.875rem): h2 under an eyebrow, capped at 42rem wide.
- **Title** (600, 1.25rem; 1.125rem for event cards): card and subsection headings.
- **Body** (400, 1rem, line-height 1.5): running text in Muted Ink. Lead paragraphs step up to 1.125rem.
- **Label** (600, 0.875rem, 0.05em tracking, uppercase): the eyebrow above section headings, in Patio Blue.

### Named Rules
**The One Weight Rule.** Headings are semibold (600). Medium (500) is for small secondary emphasis. Bold, black and light are not used.

**The Traditional Kai Rule.** Chinese text is Traditional, tagged `lang="zh-Hant"`, and rendered in the Kai stack. Never Simplified, never a sans CJK face.

## Layout

Mobile-first, single column by default. Content sits in a centered container capped at 80rem with a 16px side gutter; text blocks are capped at 42rem. Sections stack full width and alternate between Surface and Alternate Surface to mark the change, with vertical padding of 48px on phones and 64px to 80px from `sm` up (96px on the blue Eventos hero).

Grids open at `md` or `lg`: two columns for hero text beside an image, two or three columns for cards, with 16px gaps between cards and 24px between media cards. Images hold a 4:3 ratio. Main content starts 80px below the top to clear the floating header; the home hero pulls up under it. Breakpoints observed in the component styles: 700px (hero), 760px and 1100px (reviews, navigation), 1024px (stacked cards).

## Elevation & Depth

Lifted and tactile. Things that sit above the page say so with translucency, blur and soft shadow, and the header is the reference: an 86% white pill with a 10px backdrop blur and a fine edge shadow, floating 16px from the top. Section changes still use tone (white against the alternate surface) rather than lines.

### Shadow Vocabulary
- **Floating shell** (`box-shadow: 0px 4px 4px 0px hsla(0, 0%, 0%, 0.039), 0px 0px 1px 0px hsla(0, 0%, 0%, 0.62)`): the navigation pill and its flyout. A hairline edge plus a short drop.
- **Raised card** (`box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)`): white cards on the alternate surface. The only shadow on inner pages today.

### Named Rules
**The Floating Layer Rule.** Anything fixed or overlaid (header, flyout, gallery lightbox) is translucent or shadowed so the page reads through or beneath it. It never sits as an opaque flat bar.

## Shapes

Soft and round. Surfaces, images and placeholders use gently curved 16px corners; accordion items use 12px; large set-piece panels use 24px. Everything clickable that is not a card is a full pill: buttons, anchor chips, the language toggle, carousel controls, avatars. The navigation shell and hero use a superellipse corner shape where the browser supports it. Borders are rare and thin (1px Hairline), used only on outlined cards and the level-map image. Circles appear as decoration and as controls.

## Components

### Buttons
- **WhatsApp button:** a 40px-tall green capsule (Bamboo Green, white 16px semibold label, 24px side padding) with a separate circular arrow tab that travels on hover. Focus shows a 2px Patio Blue outline offset 2px. Used for every WhatsApp call to action.
- **Nav Contact:** a small Patio Blue pill (14px text, 4px by 12px padding) at the right of the header; fades to 80% on hover.
- **Text link:** semibold Patio Blue with a trailing arrow ("Leer más →"); underlines on hover in event cards.

### Chips
- **Anchor chip:** on blue bands, a pill with a 40% white 1px border, 14px medium text, 8px by 16px padding; fills with 10% white on hover. Jumps to sections of the same page.
- **Language toggle:** a pill group with a 15% ink border; the active language is a Patio Blue pill with white text, the other is Subtle Ink.

### Cards / Containers
- **Corner Style:** 16px.
- **Raised card:** white on the alternate surface with the Raised card shadow, 24px padding. Course age groups and similar overviews.
- **Outlined card:** white with a 1px Hairline border, 24px padding. Paired detail blocks.
- **Tinted note:** 5% Patio Blue fill, no border, 24px padding. Side notes inside a section.
- **Media card:** a 4:3 image with 16px corners, title and two-line description beneath, no container. Events.
- **Placeholder:** a Sunken Surface block at the image's ratio where the client's photo is still missing.

### Navigation
A fixed, centered, floating pill: translucent white, 10px blur, Floating shell shadow. Logo left, links center (15px, Nav Ink), language toggle and Contact right. Four items open a flyout with large Kai glyph tiles. The shell narrows after scrolling (1240px to 1080px), collapses to a menu with accordions below 1100px, and lifts away with a blur when a gallery opens.

### Accordion
Sunken Surface items with 12px corners and an 8px gap, 17px questions, optional Lantern Orange numerals, a plus mark that rotates. Opens over 700ms with a springy ease.

### Signature set pieces
- **Hero:** full-viewport banner slider (image or video per slide) with split-text headline, thumbnail picker and a loading curtain. Falls back to Patio Blue with a Lantern Orange radial glow.
- **Stacked service cards:** three large cards that stack while scrolling, uppercase semibold titles in Patio Blue beside a photo.
- **Review carousel:** one large quote at a time with a Patio Blue progress line, initial-letter avatar and circular arrow controls.
- **Cylindrical carousel:** event covers on a rotating cylinder with a Soft Patio Blue glow.
- **Page transition:** content fades and blurs (7px) over 0.5s between pages.

## Do's and Don'ts

### Do:
- **Do** set Chinese in the Kai stack with `lang="zh-Hant"`, and keep it Traditional.
- **Do** use the green WhatsApp button for every WhatsApp call to action.
- **Do** round surfaces at 16px and make every standalone control a full pill.
- **Do** alternate sections between Surface and Alternate Surface instead of drawing divider lines.
- **Do** give floating and overlaid layers translucency, blur or the Floating shell shadow.
- **Do** design at phone width first and keep the 16px gutter.
- **Do** provide a `prefers-reduced-motion` fallback for every animation, as the navigation does.
- **Do** use the logo exactly as the client delivered it.

### Don't:
- **Don't** use Simplified Chinese or a sans CJK face.
- **Don't** use Flux or any UI component library on the public site; it is plain Tailwind v4 plus Alpine.
- **Don't** use Bamboo Green as a decorative fill.
- **Don't** reuse the footer's warm paper and ink colors elsewhere while the footer is provisional.
- **Don't** introduce heading weights other than semibold.
- **Don't** depend on client photos to carry a section; they are low quality.
