<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\warning;

class StarterKitPostInstall
{
    protected string $env = '';

    protected string $config = '';

    public function handle($console)
    {

        $this->exportAndDeleteFile('config/dok.export.php', 'config/dok.php');
        info('[✓] Added config/dok.php');
        $this->exportAndDeleteFile('package.export.json', 'package.json');
        info('[✓] Added package.json');

        $this->config = app('files')->get(base_path('config/dok.php'));
        $this->env = app('files')->get(base_path('.env'));

        warning('Please ensure you are running node version ^20.19.0 || >=22.12.0 or this installation may not work properly.');

        $this->installNodeModules();
        $this->chooseCodeHighligher();
        $this->updateEnv();
        $this->generateReleaseCollectionTree();
        $this->writeFiles();
        $this->finish();
    }

    protected function installNodeModules(): void
    {

        $selected = confirm(
            required: true,
            label: 'Ready to install node modules?',
        );

        if ($selected) {
            $this->runCommand(
                command: 'npm i',
                message: 'Installing node modules...'
            );
        }
    }

    protected function chooseCodeHighligher(): void
    {
        $selected = select(
            required: true,
            label: 'Which code highligher do you want to use?',
            options: [
                'torchlight-engine' => 'Torchlight Engine (Recommended)',
                'shiki' => 'Shiki',
                'none' => 'None',
            ]
        );

        if ($selected === 'torchlight-engine') {
            $this->runCommand(
                command: 'composer require torchlight/engine',
                message: 'Installing Torchlight Engine...'
            );

            $this->config = str_replace('PLACEHOLDER_CONFIG_CODE_HIGHLIGHTER', 'torchlight-engine', $this->config);

        } elseif ($selected === 'shiki') {
            $this->runCommand('composer require spatie/commonmark-shiki-highlighter', message: 'Installing Shiki composer dependencies...');
            $this->runCommand('npm i shiki', message: 'Installing Shiki node modules...');
            $this->config = str_replace('PLACEHOLDER_CONFIG_CODE_HIGHLIGHTER', 'shiki', $this->config);
        }
    }

    protected function updateEnv(): void
    {
        $this->env .= PHP_EOL.'CODE_HIGHLIGHTER_ENABLED=false';
    }

    protected function generateReleaseCollectionTree()
    {
        $path = base_path('content/trees/collections/releases.yaml');
        $content = <<<'YAML'
tree:
  -
    entry: 43637327-fa17-42d4-a0b8-2ebdc90a7638
    children:
      -
        entry: 761e8cfd-30f7-4d96-b443-abccb9cdb652

YAML;

        if (! File::exists($path)) {
            File::ensureDirectoryExists(base_path('content/trees/collections'));
            File::put($path, $content);
        }

        info('[✓] Generated release collection tree');
    }

    protected function runCommand(string $command, bool $spin = true, string $message = ''): void
    {

        $result = null;

        if ($spin) {
            spin(
                callback: function () use (&$result, $command) {
                    $result = Process::timeout(120)->run($command);
                },
                message: $message
            );
        } else {
            $result = Process::timeout(120)->run($command);
        }

        if ($result->failed()) {
            throw new \RuntimeException("Command failed: {$command}\n".$result->errorOutput());
        }

        echo $result->output();
    }

    protected function writeFiles(): void
    {
        app('files')->put(base_path('config/dok.php'), $this->config);
        app('files')->put(base_path('.env'), $this->env);
    }

    protected function exportAndDeleteFile(string $source, string $destination): void
    {
        $sourcePath = base_path($source);
        $destinationPath = base_path($destination);

        File::ensureDirectoryExists(dirname($destinationPath));

        File::put($destinationPath, File::get($sourcePath));

        File::delete($sourcePath);
    }

    protected function finish(): void
    {
        info('[✓] CODE_HIGHLIGHTER_ENABLED has been placed in your .env file. If you want to enable, set to `true`');
        info('I hope this starterkit helps you! If you have any questions or run into any issues, please create an issue on GitHub. Have a nice day!');
    }
}
