<?php

namespace App\Providers;

use App\Exceptions\ErrorHandler;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\Eloquent\BookRepository;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Reports\Output\Formats\CsvFormater;
use App\Services\Reports\Output\Formats\JsonFormater;
use App\Services\Reports\Output\Formats\PdfFormater;
use App\Services\Reports\Output\Formats\XmlFormater;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);

        $this->app->singleton(
            ExceptionHandler::class,
            ErrorHandler::class
        );

        $this->app->tag(
            [JsonFormater::class, CsvFormater::class, PdfFormater::class, XmlFormater::class],
            'report.formatters'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
