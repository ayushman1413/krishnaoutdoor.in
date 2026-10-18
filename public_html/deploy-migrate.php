<?php
/**
 * ONE-TIME production migration runner — place in public_html/, visit it
 * once over HTTPS, then DELETE IT IMMEDIATELY. Only use this if you don't
 * have SSH/Terminal access on Hostinger; if you do, delete this file and
 * instead run from Hostinger's terminal:
 *   cd laravel && php artisan migrate --force
 *
 * USAGE:
 * 1. Make sure laravel/.env is already the production .env (pointed at the
 *    real Hostinger MySQL database — see laravel/.env.production in this repo).
 * 2. Visit: https://krishnaoutdoor.in/deploy-migrate.php?token=4f2990825fc6875742e190d4c22d701f1ead97acfffbf92f
 * 3. Read the output. It should say "SUCCESS".
 * 4. DELETE THIS FILE from public_html/ immediately after — leaving it in
 *    place is a security risk, since anyone who learns the token can run
 *    migrations (not destroy data, but still: remove it once done).
 */

define('DEPLOY_MIGRATE_TOKEN', '4f2990825fc6875742e190d4c22d701f1ead97acfffbf92f');

if (!isset($_GET['token']) || !hash_equals(DEPLOY_MIGRATE_TOKEN, $_GET['token'])) {
    http_response_code(403);
    die('Forbidden.');
}

if (!headers_sent()) {
    header('Content-Type: text/plain');
}

require __DIR__ . '/../laravel/vendor/autoload.php';

$app = require_once __DIR__ . '/../laravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Running migrations...\n\n";

$exitCode = Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

echo Illuminate\Support\Facades\Artisan::output();

echo "\nExit code: $exitCode\n";
echo $exitCode === 0 ? "SUCCESS — now DELETE this file from the server.\n" : "FAILED — check the output above.\n";
