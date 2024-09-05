<?php

namespace App\Providers;

use App\Extensions\Paginator\CustomPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Tinify\Tinify;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        \App\Driver\File\Contracts\FileSystemInterface::class => \App\Driver\File\FileSystem::class,
        \App\Utils\Contracts\ResponseInterface::class => \App\Utils\Response::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Intervention\Image\ImageManager::class,
            static function (): ImageManagerInterface {
                // Is cli is worker
                if (getenv('PHP_MODE') === 'php-cli') {
                    $driver = new \Intervention\Image\Drivers\Imagick\Driver();
                } else {
                    $driver = new class extends \Intervention\Image\Drivers\Imagick\Driver {
                        public function checkHealth(): void {}
                    };
                }

                return new \Intervention\Image\ImageManager($driver);
            }
        );

        $this->app->alias(CustomPaginator::class, LengthAwarePaginator::class);

        Tinify::setKey(env('TINYPNG_API_KEY'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(
        //     ImageWasSavedEvent::class,
        //     OptimizeImageListener::class
        // );
    }
}
