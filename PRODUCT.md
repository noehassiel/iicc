# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

**Primary: parents of children and teenagers in Mexico** who are evaluating Chinese classes for their kids (courses start at age 6). They are comparing schools, mostly on a phone, and their job is to decide whether IICC is trustworthy and suitable enough to write to the institute on WhatsApp.

Secondary audiences, present in the client's copy but not the priority:

- Adult learners and students interested in courses, official certifications and scholarships.
- The Chinese community abroad in Mexico looking to reconnect with its roots.
- Institute staff, who maintain content through the admin panel at `/admin` without touching code.

## Product Purpose

The website of the Instituto de Idioma y Cultura China en México, A.C. (IICC), replacing the WordPress site at iicc.org.mx. It is the same site with the same menu, but with more complete content, a modern design, and a panel the institute edits itself.

It is informational. There is no online sale, enrollment or account: every call to action opens WhatsApp directly. Success is a visitor who understands what IICC offers and starts a WhatsApp conversation, and a staff that keeps the content current on its own (the old site's events had not been updated since 2023).

## Positioning

Language and culture together since 2003: "mucho más que una escuela". IICC presents itself as a human bridge through which Mexico discovers Chinese tradition, and a place where the Chinese community abroad reconnects with its roots. The length of that history and the cultural life around the classes (monthly cultural workshops, community events) are what a neighboring language school could not truthfully claim.

The Taiwan link and official certification results are true and appear in the content, but they support this position rather than lead it.

## Operating Context

- Visitors arrive to evaluate a school and leave through WhatsApp; there are no contact forms.
- Menu, fixed by the signed proposal: Inicio, Cursos, Certificaciones, Becas, Otros Servicios, Eventos, Nosotros, Contacto, plus Facebook, Instagram and YouTube icons.
- The campus is in Mexico City, a few steps from the Monumento a la Revolución; courses are offered in person and online.
- Staff edit banners, events (with photo galleries) and Google reviews in the admin panel. Reviews are entered by hand, not pulled from Google.
- Client copy arrives as one PDF per page in `pages-info/`, with layout notes from the client written into them.

## Capabilities and Constraints

- **Bilingual: Spanish and Traditional Chinese (zh_TW).** Never Simplified; the institute is linked to Taiwan and the client confirmed this in November 2026. Chinese text uses a Kai (KaiTi) typeface.
- Chinese translations are currently machine-made and pending client review.
- Copy comes from the client. Do not invent copy; read the relevant PDF before building a page.
- No e-commerce, no pre-enrollment or payment, no student or tutor accounts, no digital certificates, no news module. These may be quoted later as separate phases.
- Mobile-first.
- Hosting is cPanel shared hosting: no long-running workers, no Node on the server, no queues or websockets.
- Proposal scope lists courses and scholarships as editable from the panel later; today the panel covers banners, events and reviews.
- The institute serves minors. The old site published no privacy notice; legal texts depend on data the client still has to deliver.

**Undecided or pending**

- Final Traditional Chinese copy (client review).
- Privacy notice and other legal texts.
- Whether the current blue, green and orange palette and the informal "tú" voice of the client's copy are binding brand commitments. The user did not confirm them as such.

## Brand Commitments

- Name: Instituto de Idioma y Cultura China en México, A.C. (IICC).
- The logo is used as the client delivered it. No brand manual beyond the logo has been confirmed.

## Evidence on Hand

- Client copy per page and the signed proposal: `pages-info/*.pdf`.
- Figures stated by the client: 12,000+ students taught at IICC since 2003; 500+ students certified in TOCFL and HSK; 150+ children and teenagers certified in YCT and CCCC.
- Google reviews chosen by the client (rating 4.5, 20+ reviews at the time of the brief), stored through the admin panel.
- Event photos with captions, banners and campus images loaded by `ContentSeeder`.
- Named staff from the client's copy: Grace Zhang (Directora General), Jeymmi (Coordinación y Admisiones), Juan (Seguridad y Atención en Campus). The client plans to show 12 teachers.

**Absences, not to be fabricated**

- Client photos are low quality; there is no professional photography.
- Teacher names, photos and years of experience have not been delivered.
- No prices or schedules are confirmed for publication.
- No testimonials other than the Google reviews the client selected.

## Product Principles

1. **Answer a parent's questions first.** Age ranges, modality, group size, safety and who will teach their child come before anything else.
2. **Every path ends in WhatsApp.** The site informs; the conversation closes. Nothing should stand between a convinced visitor and that button.
3. **Culture is the proof, not the decoration.** Events, workshops and the campus show that IICC is more than a language school; they carry the positioning.
4. **Only what the client has said.** Copy, figures and people come from the client's material. Gaps stay visible as gaps until the client fills them.
5. **The institute keeps it alive.** Anything that changes over time must be editable from the panel by non-technical staff.
