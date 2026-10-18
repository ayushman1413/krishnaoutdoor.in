// Minifies the site scripts: public/js/<name>.js -> public/js/<name>.min.js.
//
//   cd laravel && npm install && npm run build:js
//
// Edit the unminified files, then rebuild. Commit both.
import { readFileSync, writeFileSync } from 'node:fs';
import { minify } from 'terser';

const root = new URL('..', import.meta.url).pathname;

for (const name of ['main', 'kr-laravel', 'tracking', 'chat']) {
  const source = readFileSync(root + `public/js/${name}.js`, 'utf8');
  const { code } = await minify(source, { compress: true, mangle: true, format: { comments: false } });
  writeFileSync(root + `public/js/${name}.min.js`, code);
  console.log(`${name}.min.js: ${(source.length / 1024).toFixed(0)} KB -> ${(code.length / 1024).toFixed(0)} KB`);
}
