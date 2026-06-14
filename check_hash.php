<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@admin.com')->first();
echo "Password starts with \$2y\$: " . (str_starts_with($user->password, '$2y$') ? 'YES' : 'NO') . "\n";
echo "Password: " . substr($user->password, 0, 15) . "...\n";
echo "Role: " . $user->role . "\n";
echo "Has casts method: " . (method_exists($user, 'casts') ? 'yes' : 'no') . "\n";

$hashCheck = password_verify('12345', $user->password);
echo "Password verify (12345): " . ($hashCheck ? 'PASS' : 'FAIL') . "\n";
