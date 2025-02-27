<?php

namespace App\Tags;


use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Tags\Tags;

class Project extends Tags
{

    public function index()
    {
        if (! isset($this->context['collection'])) {
            return [];
        }

        return $this->getRelease($this->context['collection'] ?? null)['entry'];
    }

    public function entry()
    {
        return $this->getRelease($this->context['collection'] ?? null)['entry'];
    }

    public function versions()
    {
        return $this->getRelease($this->context['collection'] ?? null)['versions'];
    }

    public function githubRepoUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['github_repo_url'];
    }

    public function githubEditUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['github_edit_url'];
    }

    public function title()
    {
        return $this->getRelease($this->context['collection'] ?? null)['title'];
    }

    public function latestStableVersion()
    {
        return $this->getRelease($this->context['collection'] ?? null)['latest_stable_version'];
    }

    public function latestStableVersionUrl()
    {
        return $this->getRelease($this->context['collection'] ?? null)['latest_stable_version_url'];
    }

    public function hasVersions()
    {
        return $this->getRelease($this->context['collection'] ?? null)['has_versions'];
    }

    /**
     * Gets the project information from the collection that is retrieved
     * from the current context. 
     *
     * @param Collection $collection
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
            'entry' => $parent,
            'project' => $parent->slug(),
            'title' => $parent->title(),
            'latest_stable_version' => $parent->latest_stable_release ?? null,
            'latest_stable_version_url' => $this->getLatestStableVersionUrl($parent),
            'versions' => $this->getProjectVersions($parent),
            'has_versions' => $parent->flattenedPages()->count() > 1
        ];
    }

    private function getLatestStableVersionUrl($parent)
    {
        return Entry::find(
            Collection::findByHandle($parent->latest_stable_release->version_collection->handle())
                ->structure()
                ->in(Site::current()->handle())
                ->tree()[0]['entry']
        )
        ->url();
    }
    
    /**
     * Given a parent page, this will return an array of its children
     *
     * @param \Statamic\Structures\Page $parent
     * @return array
     */
    private function getProjectChildren(\Statamic\Structures\Page $parent): array
    {
        return $parent
            ->flattenedPages()
            ->map(function ($page) {
                return $page->id();
            })
            ->toArray();
    }
    
    /**
     * Given a parent page, this will return an array of its childrens versions
     *
     * @param \Statamic\Structures\Page $parent
     * @return array
     */
    private function getProjectVersions(\Statamic\Structures\Page $parent): array
    {
        return collect($this->getProjectChildren($parent))
            ->map(function ($child) {
                $release = Entry::find($child);
                $releaseCollection = Collection::find($release->get('version_collection'));
                $releaseCollectionHomeId = $releaseCollection?->structure()->in(Site::current()->handle())->tree()[0]['entry'];

                return [
                    'version' => $release->get('version'),
                    'url' => Entry::find($releaseCollectionHomeId)?->url(),
                    'label' => $release->get('label'),
                ];
                
            })
            ->reverse()
            ->values()
            ->toArray();
    }
}
