add wizpt\cms\CmsServiceProvider::class, to config/app
add to config/app.php 'locales' => ['en' => 'English', 'de' => 'German', 'pt' => 'portuguese'],
php artisan migrate
php artisan db:seed --class=wizpt\\cms\\seeds\\AdminUsersTableSeeder
php artisan db:seed --class=wizpt\\cms\\seeds\\AdminRolesTableSeeder
php artisan make:cms

In config/auth change 'model' => App\User::class, to 'model' => wizpt\cms\Models\AdminUser::class,

