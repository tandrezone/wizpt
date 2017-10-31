<?php

namespace wizpt\cms\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class CmsMakeCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic login and registration views and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
        'home.stub' => 'home.blade.php',

        'pages/create.stub' => 'pages/create.blade.php',
        'pages/edit.stub' => 'pages/edit.blade.php',
        'pages/frontend.stub' => 'pages/frontend.blade.php',
        'pages/index.stub' => 'pages/index.blade.php',
        'pages/show.stub' => 'pages/show.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();

        if (! $this->option('views')) {
            file_put_contents(
                app_path('Http/Controllers/HomeController.php'),
                $this->compileControllerStub('HomeController')
            );
            file_put_contents(
                app_path('Http/Controllers/Auth/ForgotPasswordController.php'),
                $this->compileControllerStub('ForgotPasswordController')
            );
            file_put_contents(
                app_path('Http/Controllers/Auth/LoginController.php'),
                $this->compileControllerStub('LoginController')
            );
            file_put_contents(
                app_path('Http/Controllers/Auth/RegisterController.php'),
                $this->compileControllerStub('RegisterController')
            );
            file_put_contents(
                app_path('Http/Controllers/Auth/ResetPasswordController.php'),
                $this->compileControllerStub('ResetPasswordController')
            );
            file_put_contents(
                app_path('Http/Controllers/Admin/PagesController.php'),
                $this->compileControllerStub('PagesController')
            );
            file_put_contents(
                app_path('Http/Controllers/Admin/tinymceController.php'),
                $this->compileControllerStub('ResetPasswordController')
            );

            file_put_contents(
                app_path('Http/Controllers/PagesController.php'),
                $this->compileControllerStub('PagesController2')
            );
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/stubs/make/routes.stub'),
                FILE_APPEND
            );
        }

        $this->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        if (! is_dir($directory = resource_path('views/layouts'))) {
            mkdir($directory, 0755, true);
        }
        if (! is_dir($directory = resource_path('views/auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
        if (! is_dir($directory = resource_path('views/pages'))) {
            mkdir($directory, 0755, true);
        }
        if (! is_dir($directory = app_path('Http/Controllers/Admin'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/'.$value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/stubs/make/views/'.$key,
                $view
            );
        }
    }

    /**
     * Compiles the HomeController stub.
     *
     * @return string
     */
    protected function compileControllerStub($name)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__.'/stubs/make/controllers/'.$name.'.stub')
        );
    }
}
