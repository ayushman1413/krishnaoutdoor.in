// Builds the per-template CSS bundles public/css/bundle-<name>.min.css from the three
// source stylesheets the layout used to load one by one (same order):
//
//   public/css/style.css, public/css/home-style-sync.css, public/css/kr-laravel.css
//
// Each bundle keeps only the rules its page template, the shared partials
// (header, footer, popups, chat) and the site scripts can use, then minifies.
// "site" is the catch-all used by any page that does not pick a bundle with
// @section('css-bundle', '...').
//
//   cd laravel && npm install && npm run build:css
//
// Edit the source files, then rebuild. Commit the sources and the bundles.
import { readFileSync, writeFileSync } from 'node:fs';
import { PurgeCSS } from 'purgecss';
import CleanCSS from 'clean-css';

const root = new URL('..', import.meta.url).pathname;
const views = root + 'resources/views/web/';
const sources = ['public/css/style.css', 'public/css/home-style-sync.css', 'public/css/kr-laravel.css'];

const shared = [
  views + 'layouts/app.blade.php',
  views + 'common/*.blade.php',
  root + 'public/js/main.js',
  root + 'public/js/kr-laravel.js',
  root + 'public/js/tracking.js',
  root + 'public/js/chat.js',
];

const bundles = {
  home: [views + 'pages/home.blade.php'],
  about: [views + 'pages/about.blade.php'],
  contact: [views + 'pages/contact.blade.php'],
  careers: [views + 'pages/careers.blade.php'],
  services: [views + 'pages/services.blade.php'],
  network: [views + 'pages/network.blade.php'],
  projects: [views + 'pages/projects.blade.php'],
  media: [views + 'pages/ooh-media.blade.php', views + 'pages/transit-media.blade.php', views + 'pages/digital-media.blade.php'],
  keyword: [views + 'pages/keywords/*.blade.php', views + 'pages/free-site-list.blade.php'],
  site: [views + '**/*.blade.php'],
};

const css = sources.map((f) => readFileSync(root + f, 'utf8')).join('\n');

// Level 1 only: strips whitespace/comments and shortens values, but never
// merges, reorders or restructures rules, so the cascade of this heavily
// layered stylesheet stays exactly as written.
const minifier = new CleanCSS({ level: 1, rebase: false });

for (const [name, pages] of Object.entries(bundles)) {
  const [purged] = await new PurgeCSS().purge({
    content: [...shared, ...pages],
    css: [{ raw: css }],
    // State classes that scripts add at runtime, plus the site-wide header
    // nav, mobile drawer, enquiry popup and chat widget, which appear on
    // every page and build some class names in JS.
    safelist: {
      standard: [/^is-/, /^has-/, 'open', 'active', 'in', 'show', 'visible', 'scrolled', 'loaded', 'playing', 'center', 'user', 'bot'],
      deep: [/^marker-/, /^chat/, /^msg/, /typing/, /-time$/, /^nav/, /^mobile-/, /^enquiry-/, /^header/],
      greedy: [/reveal/, /chat/, /nav-/, /menu/],
    },
    keyframes: true,
    fontFace: true,
    variables: false,
  });

  const result = minifier.minify(purged.css);
  if (result.errors.length) {
    throw new Error(`${name}: ${result.errors.join('; ')}`);
  }
  writeFileSync(root + `public/css/bundle-${name}.min.css`, result.styles);
  console.log(`bundle-${name}.min.css: ${(result.styles.length / 1024).toFixed(0)} KB`);
}
console.log(`(sources: ${(css.length / 1024).toFixed(0)} KB)`);
