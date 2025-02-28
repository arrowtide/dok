<?php

use Illuminate\Support\Facades\File;

class StarterKitPostInstall
{
    public function handle($console)
    {
        $this->generateDocumentationConfig($console);
        $this->generateReleaseCollectionTree($console);
        $this->addShikiEnv($console);
    }

    protected function generateDocumentationConfig($console)
    {
        $configPath = config_path('documentation.php');

        $content = <<<PHP
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | If you're using Github to sync your content, you can add your resources
    | here.
    |
    */
    'resources' => [
        // 'YOUR_RESOURCE' => [
        //     'repo' => 'owner/repo',
        //     'branch' => 'main',
        //     'content' => ['docs'],
        //     'token' => env('GITHUB_SYNC_TOKEN'),
        // ],
    ],
];

PHP;

        if (!File::exists($configPath)) {
            File::put($configPath, $content);
        }

        $console->line('Placed config/documentation.php');
    }

    protected function generateReleaseCollectionTree($console) 
    {
        $path = base_path('content/trees/collections/releases.yaml');
        $content = <<<YAML
tree:
  -
    entry: 43637327-fa17-42d4-a0b8-2ebdc90a7638
    children:
      -
        entry: 761e8cfd-30f7-4d96-b443-abccb9cdb652

YAML;

        if (!File::exists($path)) {
            File::ensureDirectoryExists(base_path('content/trees/collections'));
            File::put($path, $content);
        }

        $console->line('Placed content/trees/collections/releases.yaml');
    }

    protected function addShikiEnv($console)
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            file_put_contents($envPath, "\nSHIKI_ENABLED=false", FILE_APPEND);
            $console->line('Added SHIKI_ENABLED to .env');
        }
    }
}
