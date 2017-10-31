add wizpt\cms\CmsServiceProvider::class, to config/app
php artisan migrate
php artisan db:seed --class=wizpt\\cms\\seeds\\AdminUsersTableSeeder
php artisan db:seed --class=wizpt\\cms\\seeds\\AdminRolesTableSeeder
php artisan make:cms

In config/auth change 'model' => App\User::class, to 'model' => wizpt\cms\Models\AdminUser::class,