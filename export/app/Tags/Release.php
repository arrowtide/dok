<?php

namespace App\Tags;

use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
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
        ];
    }

    private function getHomeEntry($collection)
    {
        return $collection?->structure()->in(Site::current()->handle())->tree()[0]['entry'];
    }
}
