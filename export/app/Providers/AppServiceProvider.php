<?php

namespace App\Providers;

use App\Http\Controllers\GitHubSyncController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Markdown;
use Statamic\Facades\Utility;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Markdown::addExtension(function () {
            return new HeadingPermalinkExtension;
        });

        Markdown::addExtension(function () {
            return new TableOfContentsExtension;
        });

        if (env('SHIKI_ENABLED', true)) {
            Markdown::addExtension(function () {
                return new HighlightCodeExtension(theme: 'material-theme-palenight');
            });
        }

        Utility::extend(function () {
            Utility::register('github_sync')
                ->view('utility.github_sync')
                ->title('Github Sync')
                ->navTitle('Github Sync')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63 61" fill="currentColor"><path d="M31.5 0C14.096 0 0 13.994 0 31.271c0 13.838 9.017 25.526 21.538 29.67 1.575.273 2.166-.665 2.166-1.486 0-.743-.04-3.205-.04-5.824-7.914 1.446-9.962-1.916-10.592-3.675-.354-.899-1.89-3.674-3.228-4.417-1.103-.586-2.678-2.033-.04-2.072 2.481-.039 4.253 2.268 4.844 3.206 2.835 4.73 7.363 3.4 9.174 2.58.276-2.033 1.102-3.401 2.008-4.183-7.009-.782-14.332-3.479-14.332-15.44 0-3.401 1.22-6.215 3.228-8.404-.315-.782-1.417-3.988.315-8.287 0 0 2.638-.821 8.663 3.205a29.43 29.43 0 0 1 7.875-1.056c2.677 0 5.355.352 7.875 1.056 6.024-4.065 8.662-3.205 8.662-3.205 1.733 4.3.63 7.505.315 8.287 2.008 2.189 3.229 4.964 3.229 8.404 0 12-7.363 14.658-14.372 15.44 1.142.977 2.126 2.854 2.126 5.785 0 4.183-.039 7.544-.039 8.6 0 .82.59 1.798 2.166 1.485C53.983 56.797 63 45.07 63 31.271 63 13.994 48.904 0 31.5 0Z"/></svg>')
                ->description('Syncs your Statamic documentation from your github repositories ')
                ->routes(function ($router) {
                    $router->post('/', [GitHubSyncController::class, 'make'])->name('make');
                });
        });

        $contentComputedCollections = collect(Entry::query()
            ->where('collection', 'releases')
            ->where('content_is_computed', true)
            ->get())
            ->map(function ($entry) {
                return $entry->value('version_collection');
            })
            ->toArray();

        Collection::computed($contentComputedCollections, 'content', function ($entry, $value) {
            if (! $entry->get('resource_location')) {
                return;
            }

            $file = base_path('content/docs/'.$entry->get('resource_location'));

            if (File::exists($file)) {
                return file_get_contents($file);
            }
        });
    }
}
