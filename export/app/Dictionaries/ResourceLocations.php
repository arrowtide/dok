<?php

namespace App\Dictionaries;

use Illuminate\Support\Facades\File;
use Statamic\Dictionaries\BasicDictionary;

class ResourceLocations extends BasicDictionary
{
    protected string $valueKey = 'path';

    protected string $labelKey = 'path';

    protected function getItems(): array
    {
        $files = File::allFiles(base_path('content/docs'));
        $dictionary = [];

        foreach ($files as $file) {

            $dictionary[] = [
                'path' => $file->getRelativePathname(),
                'shortPath' => preg_replace('/^[^\/]+\//', '', $file->getRelativePathname()),
            ];
        }

        return $dictionary;
    }
}
