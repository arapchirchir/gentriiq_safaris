# Gentriiq Safaris & Tours — Project Guide for Developers & Coding Agents

This file is the source of truth for developers and AI coding agents working on the **Gentriiq Safaris & Tours** website.

Read this root `AGENTS.md` before making changes. It combines the Gentriiq product requirements with the Laravel Boost engineering guidance below. Maintain project instructions in this file as the single source of truth.

## How to apply this guide

- Follow explicit project-owner instructions for the current task. The roadmap describes incremental development, not authorization to build every feature at once.
- The Gentriiq sections define product requirements and brand direction. The Laravel Boost section defines development tooling and framework conventions; where engineering instructions overlap, use its more specific commands and requirements.
- Confirm installed package versions before relying on APIs. Laravel 13, PHP 8.3+, and PostgreSQL are the intended stack, not evidence of the current environment. Report discrepancies; do not upgrade packages or change the stack without approval.
- Suggested packages, models, directories, colors, and layouts are guidance, not mandatory additions. Reuse existing implementation, request approval before dependency changes or new base folders, and preserve established brand choices unless the task authorizes changing them.
- Read applicable `.ai/rules` and activate relevant skills as required by the Laravel Boost guidance.
- Validate changes proportionately: run relevant Pest tests for behavior changes, `vendor/bin/pint --dirty --format agent` for PHP changes, and `npm run build` for frontend code changes. Documentation-only changes need a content review, not application tests or a build.
- If Git metadata is unavailable, report that limitation and review changed files using a local diff; do not initialize a repository just to perform checks.

---

## 1. Project Overview

**Project:** Gentriiq Safaris & Tours  
**Website:** `gentriiqsafaris.co.ke`  
**Business:** Safari and travel company focused on Kenya and East Africa  
**Primary contacts:**

- `+254 717 838061`
- `+254 720 115305`

The website should present Gentriiq Safaris & Tours as a trustworthy, modern and premium East African safari operator.

The site should help visitors:

- Discover safari packages
- Explore destinations
- Explore safari experiences
- Read travel guides
- View detailed itineraries
- Contact Gentriiq Safaris & Tours
- Request a customized safari
- Submit trip-planning inquiries
- Contact the company through phone or WhatsApp

The public website is both a marketing website and a lead-generation platform.

---

## 2. Design Reference

The main UX and information-architecture reference is:

**Altezza Travel**  
`https://altezzatravel.com/`

Use Altezza Travel as inspiration for:

- Navigation structure
- Safari discovery
- Destination organization
- Tour presentation
- Tour itinerary structure
- Trip-planning flow
- Strong photography
- Trust signals
- Content hierarchy
- Conversion placement
- Travel guides
- Calls to action
- Mobile experience

### Important

Do **not** copy:

- Altezza branding
- Their wording
- Their page copy
- Their photographs
- Their source code
- Their exact layout
- Their graphics
- Their icons
- Their proprietary assets

Gentriiq Safaris & Tours must have its own visual identity and original implementation.

---

## 3. Technology Stack

Use the following stack unless explicitly changed by the project owner.

### Backend

```text
Laravel 13
PHP 8.3+
PostgreSQL
```

### Frontend

```text
Blade
Tailwind CSS
Alpine.js
Vite
```

Avoid introducing React, Vue or another frontend framework unless there is a strong technical reason and approval has been given.

### Recommended Laravel Packages

Where appropriate:

```text
spatie/laravel-permission
spatie/laravel-medialibrary
spatie/laravel-sitemap
```

Do not install packages unnecessarily. Obtain project-owner approval before adding, removing, or changing dependencies.

Prefer native Laravel functionality when it is sufficient.

---

## 4. Core Engineering Principles

All contributors and agents should follow these principles.

### Keep the application simple

Prefer:

- Laravel conventions
- Blade components
- Eloquent relationships
- Form Requests
- Services only when justified
- Reusable Tailwind components

Avoid:

- Premature abstraction
- Over-engineering
- Unnecessary repositories
- Large JavaScript frameworks
- Business logic inside Blade templates
- Huge controller methods
- Duplicate components

### Existing code comes first

Before creating a new:

- Model
- Controller
- Component
- Service
- Helper
- Migration
- Route

search the codebase first.

Reuse existing functionality whenever appropriate.

---

## 5. Project Structure

Expected high-level structure:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Web/
│   │   └── Admin/
│   └── Requests/
├── Models/
├── Services/
└── Policies/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/
    ├── layouts/
    ├── components/
    ├── home/
    ├── tours/
    ├── destinations/
    ├── experiences/
    ├── blog/
    ├── contact/
    └── admin/

routes/
├── web.php
└── console.php
```

Adapt this suggested structure to the existing application. Obtain approval before creating new base folders. Do not create deeply nested structures unless they improve clarity.

---

## 6. Main Public Website Structure

The website should eventually support the following structure.

```text
/
├── Safaris
│   ├── Kenya Safaris
│   ├── Tanzania Safaris
│   ├── Uganda Safaris
│   ├── Rwanda Safaris
│   ├── Private Safaris
│   └── Group Safaris
│
├── Tours
│   ├── All Tours
│   └── Tour Details
│
├── Destinations
│   ├── Kenya
│   ├── Tanzania
│   ├── Uganda
│   ├── Rwanda
│   └── Zanzibar
│
├── Experiences
│   ├── Wildlife Safaris
│   ├── Honeymoon Safaris
│   ├── Family Safaris
│   ├── Beach Holidays
│   ├── Cultural Tours
│   ├── Photography Safaris
│   └── Adventure Tours
│
├── About
├── Why Gentriiq
├── Reviews
├── Travel Guide
├── Contact
└── Plan My Safari
```

Not all sections must be implemented immediately.

Build incrementally.

---

## 7. Homepage Direction

The homepage should be visually strong and conversion focused.

Suggested structure:

```text
Sticky / fixed navigation
Hero
Popular safaris
Why Gentriiq
Destinations
Safari experiences
Featured itinerary / promotion
Testimonials
Travel guides
Plan My Safari CTA
Footer
```

### Hero

The hero should:

- Use strong East African safari imagery or video
- Have a concise headline
- Explain what Gentriiq offers
- Include clear CTAs

Example CTA labels:

```text
Explore Safaris
Plan My Safari
Talk to a Safari Expert
WhatsApp Us
```

Do not overwhelm the hero with too much copy.

---

## 8. Navigation

Desktop navigation should support a premium travel-site experience.

Suggested top-level items:

```text
Safaris
Destinations
Experiences
Travel Guide
About
```

Right side:

```text
Phone
WhatsApp
Plan My Safari
```

The navigation should remain visible while scrolling.

Use either:

```text
sticky top-0
```

or:

```text
fixed top-0
```

depending on the final page structure.

### Mega Menu

Safaris and destinations may use a mega menu.

Example Safari mega menu:

```text
SAFARIS

Safari Types
- Private Safaris
- Group Safaris
- Family Safaris
- Honeymoon Safaris
- Luxury Safaris

Popular Tours
- 5-Day Maasai Mara Safari
- 7-Day Kenya Classic Safari
- Kenya & Tanzania Safari

Destinations
- Maasai Mara
- Amboseli
- Samburu
- Tsavo

Safari Guide
- Best Time to Visit
- Safari Packing List
- The Big Five
- Great Migration Guide
```

Use Alpine.js for menu state where needed.

---

## 9. Gentriiq Visual Direction

The final website should use a clean, premium safari aesthetic.

Suggested colors:

```text
Forest Green: #173F35
Dark Green:   #10291F
Safari Gold:  #D29B42
Cream:        #F7F6F1
White:        #FFFFFF
Dark Text:    #17201C
Muted Text:   #6B706C
```

These may evolve during design.

### Typography

Recommended:

```text
Primary UI font:
Inter
or
Manrope

Optional editorial heading font:
DM Serif Display
```

Do not use too many fonts.

---

## 10. Responsive Design

All public-facing components must work well on:

```text
Mobile
Tablet
Laptop
Desktop
Large desktop
```

Mobile is not an afterthought.

Always check:

- Navigation
- Hero text
- Buttons
- Forms
- Cards
- Galleries
- Tables
- Itinerary sections
- Sticky elements

Avoid horizontal overflow.

---

## 11. Accessibility

All new UI should meet reasonable accessibility standards.

Required:

- Semantic HTML
- Correct heading hierarchy
- Keyboard-accessible menus
- Visible focus states
- Sufficient color contrast
- Descriptive image alt text
- Form labels
- Proper button elements for actions
- Proper anchor elements for navigation
- ARIA attributes only where useful

Do not use clickable `<div>` elements when a button or anchor is appropriate.

---

## 12. Tour Data Model

Tours should be database-driven.

Do not hardcode full tours directly into Blade templates.

Suggested `tours` fields:

```text
id
title
slug
short_description
description
duration_days
duration_nights
starting_price
currency
tour_type
difficulty
featured
status
published_at
meta_title
meta_description
created_at
updated_at
```

Possible `tour_type` values:

```text
private
group
both
```

Possible `status` values:

```text
draft
published
archived
```

---

## 13. Tour Days / Itinerary

Use a related model such as:

```text
TourDay
```

Suggested fields:

```text
id
tour_id
day_number
title
location
description
accommodation
meals
created_at
updated_at
```

Display itinerary days in chronological order.

Example:

```text
Day 1
Arrival in Nairobi

Day 2
Nairobi → Amboseli

Day 3
Amboseli National Park

Day 4
Amboseli → Lake Naivasha

Day 5
Lake Naivasha → Maasai Mara
```

---

## 14. Suggested Core Models

Potential models include:

```text
User
Tour
TourDay
Destination
Country
Experience
Accommodation
Inquiry
Testimonial
Post
PostCategory
Faq
Page
Setting
```

Pivot relationships may include:

```text
tour_destination
tour_experience
```

Add models only when needed.

---

## 15. Tour Detail Page

The tour detail page is one of the most important conversion pages.

Suggested structure:

```text
Breadcrumbs

Tour title
Destination summary
Duration
Tour type
Price from
Primary CTA

Image gallery

Overview
Highlights

Detailed itinerary

What's included
What's excluded

Accommodation

Best time to travel

Travel notes

FAQ

Related tours

Final CTA
```

Desktop may include a sticky booking/inquiry card.

Example:

```text
From $1,850

7 Days / 6 Nights

Have questions?

[ Plan This Safari ]
[ WhatsApp Us ]
```

---

## 16. Destinations

Destinations must support SEO-friendly pages.

Example URLs:

```text
/destinations/kenya
/destinations/kenya/maasai-mara
/destinations/kenya/amboseli
/destinations/tanzania/serengeti
```

A destination page may include:

```text
Hero
Overview
Why visit
Best time to visit
Wildlife
Things to do
Featured tours
Travel tips
FAQ
Related guides
```

---

## 17. Experiences

Experiences may include:

```text
Wildlife Safaris
Family Safaris
Honeymoon Safaris
Luxury Safaris
Photography Safaris
Beach Holidays
Cultural Experiences
Adventure Tours
```

Use relationships rather than duplicating tour data.

A tour may belong to multiple experiences.

---

## 18. Plan My Safari

This is a high-priority lead-generation feature.

Suggested multi-step form:

### Step 1 — Destination

```text
Kenya
Tanzania
Uganda
Rwanda
Zanzibar
Not sure yet
```

### Step 2 — Experience

```text
Wildlife safari
Honeymoon
Family holiday
Beach holiday
Cultural experience
Adventure
```

### Step 3 — Duration

```text
1–3 days
4–6 days
7–10 days
10+ days
```

### Step 4 — Travellers

Collect:

```text
Adults
Children
```

### Step 5 — Travel Date

Allow:

```text
Exact date
Approximate month
Not decided
```

### Step 6 — Budget

Collect an approximate budget range.

### Step 7 — Contact Information

Collect:

```text
Name
Email
Phone
WhatsApp
Country
```

### Step 8 — Notes

Allow additional requests.

---

## 19. Inquiry Workflow

All submitted inquiries should be stored in the database.

Suggested inquiry statuses:

```text
new
contacted
quote_sent
negotiating
confirmed
cancelled
```

The application should optionally:

- Send a confirmation email to the customer
- Send a notification email to Gentriiq
- Allow admins to update inquiry status
- Record notes
- Record the source page or tour

Never lose inquiry data because an email fails.

Database persistence should happen before notification sending.

---

## 20. Contact Information

Use the following current phone numbers unless changed by the project owner:

```text
+254 717 838061
+254 720 115305
```

Telephone links:

```html
<a href="tel:+254717838061">+254 717 838061</a>
<a href="tel:+254720115305">+254 720 115305</a>
```

WhatsApp URL format:

```text
https://wa.me/254720115305
```

Do not include spaces or `+` inside the WhatsApp URL.

---

## 21. Admin Panel

The admin area should eventually support:

```text
Dashboard
Tours
Destinations
Experiences
Accommodations
Inquiries
Testimonials
Blog
FAQs
Pages
Media
SEO
Users
Settings
```

Build admin functionality incrementally.

Do not create a complex CMS before the public-site data requirements are clear.

---

## 22. Authorization

Use Laravel policies and permissions.

Possible roles:

```text
super-admin
admin
editor
sales
```

Example access:

### Super Admin

Full access.

### Admin

Manage most website content and inquiries.

### Editor

Manage:

- Tours
- Destinations
- Blog
- Pages

### Sales

Manage:

- Inquiries
- Customer notes
- Inquiry statuses

Never rely only on hidden navigation links for access control.

Authorization must be enforced server-side.

---

## 23. Blade Components

Prefer reusable Blade components.

Expected reusable components may include:

```text
navbar
footer
hero
section-heading
tour-card
destination-card
experience-card
testimonial-card
blog-card
button
badge
breadcrumb
faq
gallery
inquiry-cta
whatsapp-button
```

Avoid duplicating large sections of markup.

---

## 24. Tailwind CSS Rules

Use Tailwind utility classes as the primary styling system.

Prefer:

```html
<div class="max-w-7xl mx-auto px-6 lg:px-8">
```

over writing custom CSS for ordinary spacing and layout.

Custom CSS is acceptable for:

- Complex animations
- Third-party integration fixes
- Specialized effects
- Styles that are impractical in utilities

Do not create unnecessary CSS classes that duplicate Tailwind utilities.

---

## 25. JavaScript Rules

Use Alpine.js for simple UI state.

Good Alpine use cases:

```text
Mobile navigation
Mega menu
FAQ accordion
Gallery modal
Multi-step inquiry form
Dropdowns
Tabs
```

Avoid writing large monolithic JavaScript files.

Do not add jQuery.

---

## 26. Images and Media

Safari websites depend heavily on photography.

All images should be:

- High quality
- Relevant to the destination
- Properly licensed
- Optimized
- Responsive
- Lazy-loaded where appropriate

Prefer Laravel Media Library when dynamic media management is needed.

Use WebP or AVIF where practical.

Do not commit huge unoptimized images into the repository.

---

## 27. SEO Requirements

SEO must be considered during development, not added at the end.

Each major public page should support:

```text
meta title
meta description
canonical URL
Open Graph title
Open Graph description
Open Graph image
```

Use meaningful URLs.

Good:

```text
/tours/7-day-kenya-classic-safari
/destinations/kenya/maasai-mara
/travel-guide/best-time-to-visit-kenya
```

Avoid:

```text
/tour?id=14
/page/23
```

---

## 28. Structured Data

Where appropriate implement schema.org JSON-LD.

Possible schema types:

```text
Organization
TravelAgency
TouristTrip
BreadcrumbList
FAQPage
Article
Review
```

Do not add invalid or misleading structured data.

---

## 29. Travel Guide / Blog

Content marketing will be important for organic search.

Example article topics:

```text
Best time to visit Kenya
Best time to visit Maasai Mara
Kenya safari cost guide
What to pack for safari
The Big Five in Kenya
Great Migration guide
Kenya visa guide
Safari with children
Kenya vs Tanzania safari
Kenya and Tanzania combined safari
What to wear on safari
How many days do you need for Maasai Mara?
```

Blog content should link naturally to relevant tours and destinations.

---

## 30. Performance

Performance is important for both SEO and conversions.

Always consider:

- Optimized images
- Lazy loading
- Minimal JavaScript
- Vite production builds
- Laravel caching
- Database indexes
- Eager loading
- Pagination
- CDN usage where appropriate

Avoid N+1 queries.

Use Laravel Debugbar only in development if installed.

Never expose development debugging tools in production.

---

## 31. Database Rules

Use migrations for every schema change.

Never manually modify the production schema without a corresponding migration.

Use:

```bash
php artisan make:migration <name> --no-interaction
```

Use foreign keys where appropriate.

Add database indexes for fields commonly used in:

```text
WHERE
ORDER BY
JOIN
slug lookups
status filters
published_at queries
```

---

## 32. Eloquent Rules

Use relationships properly.

Example:

```php
class Tour extends Model
{
    public function days(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TourDay::class)->orderBy('day_number');
    }
}
```

Use scopes for repeated query logic.

Example:

```php
public function scopePublished(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
{
    return $query
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now());
}
```

Avoid repeating this logic across controllers.

---

## 33. Controllers

Controllers should stay focused.

Good controller responsibilities:

```text
Validate request
Retrieve data
Call service when needed
Return view / redirect / response
```

Avoid:

- Massive business logic
- HTML generation
- Long validation arrays inside large methods
- Complex repeated queries

Use Form Request classes when validation becomes substantial.

---

## 34. Validation

All form submissions must be validated server-side.

Example:

```php
public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
        'message' => ['required', 'string', 'max:5000'],
    ];
}
```

Client-side validation may improve UX but never replaces server-side validation.

---

## 35. Security

Follow Laravel security defaults.

Always consider:

- CSRF protection
- Validation
- Authorization
- XSS prevention
- Mass-assignment protection
- Secure file uploads
- Rate limiting
- Authentication
- Secure environment configuration

Never commit:

```text
.env
API keys
Passwords
Private keys
Database credentials
Mail credentials
```

---

## 36. File Uploads

For admin uploads:

- Validate MIME type
- Validate extension
- Limit size
- Generate safe filenames
- Store outside source-controlled directories
- Do not trust client-provided file names

For images, restrict accepted file types appropriately.

---

## 37. Routes

Use RESTful route naming when possible.

Example:

```php
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

Route::get('/tours/{tour:slug}', [TourController::class, 'show'])
    ->name('tours.show');
```

Use route model binding.

Prefer slugs for public content.

---

## 38. Route Naming

Always name routes used by views.

Use:

```php
route('tours.show', $tour)
```

instead of hardcoding:

```php
url('/tours/' . $tour->slug)
```

where practical.

---

## 39. Testing

New important features should include tests.

Prioritize tests for:

```text
Tour visibility
Published/draft behavior
Inquiry submission
Validation
Admin authorization
Tour slug routes
Destination pages
Authentication
Permissions
```

Use Pest and the testing-best-practices skill. Run the narrowest relevant tests, for example:

```bash
php artisan test --compact --filter=Tour
```

Follow the Laravel Boost testing guidance below for test creation, reruns, and the complete suite.

Do not change or remove existing tests just to make a failing implementation pass.

Fix the implementation unless the test is genuinely incorrect.

---

## 40. Code Style

Use Laravel/PHP conventions.

Before finalizing PHP changes:

```bash
vendor/bin/pint --dirty --format agent
```

Use meaningful names.

Good:

```php
$featuredTours
$destination
$inquiry
```

Avoid:

```php
$data1
$tmp
$x
$stuff
```

except for trivial loop counters where appropriate.

---

## 41. Environment Setup

Reference setup for a new installation only; inspect the existing environment first. These commands do not authorize dependency changes or replacing an existing `.env`:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate --no-interaction
php artisan migrate --no-interaction
npm run dev
php artisan serve
```

For PostgreSQL, configure:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=gentriiq
DB_USERNAME=
DB_PASSWORD=
```

Do not overwrite an existing `.env` without permission.

---

## 42. Common Development Commands

### Start frontend

```bash
npm run dev
```

### Production frontend build

```bash
npm run build
```

### Run Laravel locally

```bash
php artisan serve
```

### Run migrations

```bash
php artisan migrate --no-interaction
```

### Seed database

```bash
php artisan db:seed --no-interaction
```

### Clear caches

```bash
php artisan optimize:clear --no-interaction
```

### Format changed PHP files

```bash
vendor/bin/pint --dirty --format agent
```

### Run the complete test suite

```bash
php artisan test --compact
```

During development, run the narrowest relevant tests first as specified below.

---

## 43. Agent Workflow

AI coding agents must follow this workflow.

### Before changing code

1. Read this `AGENTS.md`.
2. Inspect relevant existing files.
3. Understand the current implementation.
4. Search for reusable components.
5. Identify affected routes, models, views and tests.
6. Make the smallest coherent change.

### While changing code

1. Follow existing project style.
2. Reuse existing components.
3. Avoid unrelated refactoring.
4. Do not rename files unnecessarily.
5. Do not change dependencies without project-owner approval, even when a package has a clear use.
6. Keep backwards compatibility where practical.
7. Maintain responsive behavior.

### After changing code

1. Review the diff.
2. Check for accidental unrelated changes.
3. Run `vendor/bin/pint --dirty --format agent` if PHP files changed.
4. Run relevant Pest tests for affected behavior; documentation-only changes require content review.
5. Run the frontend build if frontend code changed.
6. Confirm routes and views compile.
7. Explain what was changed.

---

## 44. What Agents Must Not Do

Agents should not:

- Rewrite large sections without need
- Delete working functionality without approval
- Change the technology stack without approval
- Replace Blade with React/Vue without approval
- Install packages casually
- Change brand colors randomly
- Commit secrets
- Modify `.env` destructively
- Drop production tables
- Run destructive database commands without explicit permission
- Copy Altezza content or code
- Use unlicensed images
- Hardcode data that belongs in the database
- Disable tests to achieve a green test suite
- Remove authorization checks
- Hide errors instead of fixing them

---

## 45. Destructive Commands

Do not run commands such as:

```bash
php artisan migrate:fresh
php artisan db:wipe
DROP DATABASE
DROP TABLE
git reset --hard
git clean -fd
rm -rf
```

unless explicitly authorized by the project owner.

If data loss is possible, stop and ask first.

---

## 46. Git Guidelines

Before editing:

```bash
git status
```

After editing:

```bash
git diff
```

Do not include unrelated files in a commit.

Suggested commit style:

```text
feat: add safari tour listing page
feat: add plan my safari inquiry form
fix: correct mobile navigation overflow
refactor: extract reusable tour card component
test: add inquiry submission tests
```

---

## 47. UI Component Rules

When implementing from screenshots or references:

1. Match the intended structure first.
2. Match spacing and typography.
3. Match responsive behavior.
4. Use project colors.
5. Use reusable components.
6. Test mobile.
7. Avoid absolute positioning unless genuinely required.

When a reference site is used, capture the idea rather than cloning the exact implementation.

---

## 48. Forms

Forms should have:

- Clear labels
- Helpful validation messages
- Loading state
- Disabled submit state while submitting where appropriate
- Success feedback
- Error feedback
- Accessible inputs
- CSRF protection

Do not clear a long form after an error unless values are preserved.

---

## 49. Buttons

Maintain a small, consistent button system.

Suggested variants:

```text
Primary
Secondary
Outline
Ghost
Danger
```

Example primary style direction:

```text
bg-[#D29B42]
text-[#10291F]
hover:bg-[#C58E35]
```

Avoid creating a unique button style for every section.

---

## 50. Content Tone

Gentriiq copy should feel:

- Warm
- Confident
- Knowledgeable
- Welcoming
- Premium
- Authentic
- Human

Avoid exaggerated claims such as:

```text
The world's best safari company
Guaranteed best safari in Africa
#1 safari operator
```

unless independently supported.

Prefer:

```text
Explore East Africa with experienced local guidance.

Thoughtfully planned safari journeys across Kenya and East Africa.

Discover remarkable wildlife, landscapes and cultures with Gentriiq Safaris & Tours.
```

---

## 51. Pricing

Where prices are shown, use clear wording such as:

```text
From $1,850 per person
```

If pricing varies, explain major factors such as:

- Season
- Number of travellers
- Accommodation level
- Transport option
- Private vs group tour

Do not display fake placeholder prices on production pages.

---

## 52. Currency

Safari pricing may commonly use USD.

Store prices carefully.

Prefer decimal database columns.

Example:

```php
$table->decimal('starting_price', 12, 2)->nullable();
$table->string('currency', 3)->default('USD');
```

Do not use floating point columns for currency.

---

## 53. Dates and Publishing

Content with publication states should support:

```text
draft
published
archived
```

Use `published_at` for scheduled or controlled publication.

Only published content should appear publicly.

---

## 54. Slugs

Generate readable slugs.

Example:

```text
7-day-kenya-classic-safari
maasai-mara-national-reserve
best-time-to-visit-kenya
```

Slugs should be unique within their content type.

Consider redirects if a published slug is changed later.

---

## 55. Search

Do not implement complex search prematurely.

Initial search can cover:

```text
Tours
Destinations
Blog posts
```

If search is added, start with PostgreSQL capabilities before introducing external search infrastructure.

---

## 56. Analytics

The site should eventually support analytics.

Possible integrations:

```text
Google Analytics
Google Search Console
Meta Pixel
```

Do not hardcode production analytics IDs directly inside templates.

Use environment/config settings.

---

## 57. Cookies and Privacy

If tracking technologies are introduced, implement appropriate consent and privacy handling.

The site should eventually have:

```text
Privacy Policy
Terms & Conditions
Cookie Policy
Booking Terms
Cancellation Policy
```

---

## 58. Email

Transactional emails may include:

```text
Inquiry received
Inquiry notification
Quote follow-up
Booking confirmation
Contact form confirmation
```

Use Laravel Mailables or Notifications.

Do not place SMTP credentials in code.

---

## 59. SEO Content Relationships

Use internal linking intentionally.

Example:

A page about:

```text
Maasai Mara
```

should link to:

```text
Maasai Mara tours
Great Migration guide
Best time to visit Maasai Mara
Kenya safari planning
```

A tour should link to its:

```text
Destinations
Experiences
Related guides
Related tours
```

---

## 60. Footer

The final footer should likely contain:

```text
Gentriiq Safaris & Tours
Short company description

Explore
- Safaris
- Destinations
- Experiences
- Travel Guide

Company
- About
- Why Gentriiq
- Reviews
- Contact

Help
- FAQs
- Terms
- Privacy

Contact
+254 717 838061
+254 720 115305

Social links
```

Only display social networks that actually exist.

---

## 61. Initial Development Roadmap

Build in this order unless priorities change.

### Phase 1 — Foundation

```text
Laravel setup
PostgreSQL
Tailwind
Base layout
Navbar
Footer
Brand tokens
```

### Phase 2 — Homepage

```text
Hero
Featured safaris
Why Gentriiq
Destinations
Experiences
Testimonials
Travel guides
Final CTA
```

### Phase 3 — Tour System

```text
Tour migrations
Tour model
TourDay model
Tour listing
Tour detail
Tour filters
```

### Phase 4 — Destination System

```text
Countries
Destinations
Destination listing
Destination details
Tour relationships
```

### Phase 5 — Inquiry System

```text
Plan My Safari
Contact form
Database persistence
Notifications
Admin inquiry management
```

### Phase 6 — Admin

```text
Authentication
Roles
Tours CRUD
Destinations CRUD
Experiences CRUD
Inquiries
Blog
Settings
```

### Phase 7 — SEO & Content

```text
Travel guide
Metadata
Schema
Sitemap
Robots
Internal linking
```

### Phase 8 — Production

```text
Performance review
Security review
Accessibility review
Testing
Backups
Deployment
Monitoring
```

---

## 62. Definition of Done

A feature is not complete merely because it looks correct.

Before considering a feature complete:

- It works on desktop
- It works on mobile
- Validation works
- Authorization works where required
- No console errors
- No obvious PHP errors
- Tests pass
- PHP formatting passes
- Frontend build passes
- No secrets were committed
- No unrelated files changed
- SEO implications were considered
- Accessibility was considered
- Data is not unnecessarily hardcoded
- Existing functionality still works

---

## 63. Current Brand Contact Details

Use these until explicitly changed:

```text
Gentriiq Safaris & Tours

Phone:
+254 717 838061
+254 720 115305
```

Phone URLs:

```text
tel:+254717838061
tel:+254720115305
```

WhatsApp:

```text
https://wa.me/254720115305
```

---

## 64. Final Instruction to Coding Agents

When given a task:

1. Understand exactly what is being requested.
2. Inspect the existing implementation.
3. Follow this guide.
4. Prefer small, safe and maintainable changes.
5. Reuse Laravel and Tailwind conventions.
6. Do not invent business requirements unnecessarily.
7. Ask before performing destructive or architecture-changing actions.
8. Preserve working functionality.
9. Test the affected area.
10. Report clearly what changed and any remaining considerations.

The goal is not merely to produce code.

The goal is to build a maintainable, fast, visually strong and conversion-focused safari website for **Gentriiq Safaris & Tours**.

---

## Laravel Boost Engineering Guidance

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.3. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record a rule with `record-rule` only when the user explicitly asks for one. Instructions for the work at hand are not rules, no matter how emphatic: "remove this typo", "use X here" are work to do, not rules to record. Never record a rule on your own initiative, as a byproduct of a change, or to summarize what you just did. When the user does ask, pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Use `record-rule` rather than your native memory or notes tool, because native memory is personal and session-scoped, while only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== tests rules ===

# Test Enforcement

- Add or update tests for behavior and logic changes when a test provides meaningful regression coverage.
- Pure copy, styling, and layout-only changes do not require new or updated tests.
- When test coverage applies, run the affected tests and ensure they pass.
- Test the changed behavior and its important failure modes, but do not add tests beyond them.
- Read the `testing-best-practices` skill before writing tests.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.
- After the feature tests pass, ask the user to run the complete suite with `php artisan test --compact`.

</laravel-boost-guidelines>
