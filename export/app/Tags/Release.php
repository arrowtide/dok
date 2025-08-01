<?php

namespace App\Tags;

use Statamic\Exceptions\NavigationNotFoundException;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Nav;
use Statamic\Facades\Site;
use Statamic\Tags\Tags;

class Release extends Tags
{
    public function index()
    {
        if (! isset($this->context['collection'])) {
            return [];
        }

        return $this->getRelease($this->context['collection'] ?? null)['entry'];
    }

    public function navHandle()
    {
        return $this->getRelease($this->context['collection'] ?? null)['nav_handle'];
    }

    public function githubRepoUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['github_repo_url'];
    }

    public function githubEditUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['github_edit_url'];
    }

    public function version()
    {
        return $this->getRelease($this->context['collection'] ?? null)['version'];
    }

    public function isOutdated()
    {
        return $this->getRelease($this->context['collection'] ?? null)['is_outdated'];
    }

    public function homeUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['home_url'];
    }

    public function breadcrumbs()
    {
        return $this->getRelease($this->context['collection'] ?? null)['breadcrumbs'];
    }

    /**
     * Gets the project information from the collection that is retrieved
     * from the current context.
     *
     * @param  Collection  $collection
     * @return array
     */
    private function getRelease($collection)
    {
        if (! $collection) {
            return [];
        }

        $collection = $collection->value()->handle();

        $release = Entry::query()
            ->where('collection', 'releases')
            ->where('version_collection', $collection)
            ->first();

        $parent = $release->parent();

        return [
            'nav_handle' => $release->data()->get('version_navigation'),
            'version' => $release->data()->get('version'),
            'github_repo_url' => $release->data()->get('github_repository_url'),
            'github_edit_url' => $release->data()->get('github_edit_url'),
            'is_outdated' => $release->data()->get('show_outdated_banner'),
            'home_url' => Entry::find($this->getHomeEntry($release))->url(),
            'breadcrumbs' => $this->getBreadcrumbs($release->data()->get('version_navigation')),
        ];
    }

    private function getHomeEntry($collection)
    {
        return $collection?->structure()->in(Site::current()->handle())->tree()[0]['entry'];
    }

    private function getBreadcrumbs($handle)
    {

        if (! Nav::findByHandle($handle)) {
            throw new NavigationNotFoundException($handle);

            return [];
        }

        $items = Nav::findByHandle($handle)->trees()->get('default')->tree();
        $currentUri = '/'.request()->path();

        return $this->findBreadcrumbTrail($items, $currentUri);
    }

    private function findBreadcrumbTrail(array $items, string $currentUri, array $trail = [])
    {
        $stack = [];

        foreach ($items as $item) {
            $stack[] = [$item, []];
        }

        while (! empty($stack)) {
            [$current, $trail] = array_pop($stack);

            $entryId = $current['entry'] ?? null;

            $node = $entryId
                ? Entry::find($entryId)
                : [
                    'title' => $current['title'] ?? 'Untitled',
                    'url' => null,
                ];

            $newTrail = [...$trail, $node];

            if ($node instanceof \Statamic\Entries\Entry && $node->uri() === $currentUri) {
                return $newTrail;
            }

            if (! empty($current['children'])) {
                foreach ($current['children'] as $child) {
                    $stack[] = [$child, $newTrail];
                }
            }
        }

        return null;
    }
}
