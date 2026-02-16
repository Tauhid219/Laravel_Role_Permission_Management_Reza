<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportRolePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-permission:export {path : Absolute path to the target project root}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Role Permission features to another Laravel project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetPath = $this->argument('path');

        if (!File::exists($targetPath)) {
            $this->error("Target path does not exist: {$targetPath}");
            return;
        }

        if (!File::exists($targetPath . '/artisan')) {
            $this->error("Target path does not appear to be a Laravel project (missing artisan): {$targetPath}");
            return;
        }

        $this->info("Exporting Role Permission features to: {$targetPath}");

        // 1. Copy Controllers
        $controllers = [
            'PermissionController.php',
            'RoleController.php',
            'UserController.php',
            'ProductController.php'
        ];
        $this->copyFiles(app_path('Http/Controllers'), $targetPath . '/app/Http/Controllers', $controllers);

        // 2. Copy Requests
        $requests = [
            'StorePermissionRequest.php', 'UpdatePermissionRequest.php',
            'StoreRoleRequest.php', 'UpdateRoleRequest.php',
            'StoreUserRequest.php', 'UpdateUserRequest.php',
            'StoreProductRequest.php', 'UpdateProductRequest.php'
        ];
        // Ensure directory exists
        if (!File::exists($targetPath . '/app/Http/Requests')) {
            File::makeDirectory($targetPath . '/app/Http/Requests', 0755, true);
        }
        $this->copyFiles(app_path('Http/Requests'), $targetPath . '/app/Http/Requests', $requests);

        // 3. Copy Views
        $this->copyDirectory(resource_path('views/role-permission'), $targetPath . '/resources/views/role-permission');
        $this->copyDirectory(resource_path('views/product'), $targetPath . '/resources/views/product');
        // Copy nav-links? It's inside role-permission now? No, it's inside role-permission dir.

        // 4. Copy Seeders
        $seeders = [
            'RoleSeeder.php',
            'PermissionSeeder.php',
            'UserSeeder.php',
            'RolePermissionSeeder.php'
        ];
        $this->copyFiles(database_path('seeders'), $targetPath . '/database/seeders', $seeders);

        // 5. Append Routes
        $routesContent = "\n\n// Role Permission Routes\n" .
            "Route::group(['middleware' => 'auth'], function () {\n" .
            "    Route::resource('/permission', App\Http\Controllers\PermissionController::class);\n" .
            "    Route::resource('/role', App\Http\Controllers\RoleController::class);\n" .
            "    Route::get('/role/{id}/add-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('addPermissionToRole');\n" .
            "    Route::put('/role/{id}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole'])->name('givePermissionToRole');\n" .
            "    Route::resource('/user', App\Http\Controllers\UserController::class);\n" .
            "    Route::resource('/product', App\Http\Controllers\ProductController::class);\n" .
            "});\n";

        File::append($targetPath . '/routes/web.php', $routesContent);
        $this->info("Appended routes to web.php");

        $this->info("Export Completed Successfully!");
        $this->warn("Next Steps in Target Project:");
        $this->line("1. Run: composer require spatie/laravel-permission");
        $this->line("2. Run: php artisan vendor:publish --provider=\"Spatie\Permission\PermissionServiceProvider\"");
        $this->line("3. Run: php artisan migrate");
        $this->line("4. Add 'use HasRoles;' to User model.");
        $this->line("5. Update DatabaseSeeder to call RoleSeeder, PermissionSeeder, UserSeeder.");
        $this->line("6. Run: php artisan db:seed");
    }

    private function copyFiles($sourceDir, $targetDir, $files)
    {
        foreach ($files as $file) {
            if (File::exists($sourceDir . '/' . $file)) {
                File::copy($sourceDir . '/' . $file, $targetDir . '/' . $file);
                $this->line("Copied: {$file}");
            }
            else {
                $this->warn("File not found: {$file}");
            }
        }
    }

    private function copyDirectory($sourceDir, $targetDir)
    {
        if (File::exists($sourceDir)) {
            File::copyDirectory($sourceDir, $targetDir);
            $this->line("Copied Directory: " . basename($sourceDir));
        }
        else {
            $this->warn("Directory not found: " . basename($sourceDir));
        }
    }
}
