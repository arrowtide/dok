<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GitHubSyncController extends Controller
{
    /**
     * Syncs the specified GitHub repository to the local file system.
     *
     * @see https://docs.github.com/en/rest/git/trees?apiVersion=2022-11-28#get-a-tree
     * @see https://docs.github.com/en/rest/repos/contents?apiVersion=2022-11-28#get-repository-content
     *
     * @param  string  $name  The name of the resource to sync.
     *
     * @throws \Exception If the request to GitHub fails.
     */
    public function syncDocs($name)
    {

        $this->ensureConfigExistsForName($name);

        $resource = config('dok.resources')[$name];

        $url = "https://api.github.com/repos/{$resource['repo']}/git/trees/{$resource['branch']}?recursive=1";

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
            'Authorization' => 'Bearer '.$resource['token'],
            'X-GitHub-Api-Version' => '2022-11-28',
        ])->get($url);

        if (! $response->successful()) {
            throw new \Exception($response->body());
        }

        $tree = $response->json()['tree'];
        $destination = "content/docs/{$name}";

        foreach ($tree as $item) {

            // If the path does not start with any of the specified content paths then skip it
            if (isset($resource['content']) && ! Str::startsWith($item['path'], $resource['content'])) {
                continue;
            }

            if ($item['type'] === 'blob') {
                $this->downloadAndSaveBlob($resource['repo'], $item['path'], $destination, $resource['token']);

                continue;
            }

            if ($item['type'] === 'tree') {
                File::ensureDirectoryExists(base_path("{$destination}/{$item['path']}"));

                continue;
            }
        }
    }

    /**
     * Downloads a blob from a GitHub repository and saves it to the local file system.
     *
     * @param  string  $repo  The name of the GitHub repository.
     * @param  string  $filePath  The path to the blob to download.
     * @param  string  $destinationPath  The directory to save the blob to.
     * @param  string  $token  The GitHub personal access token to use for authentication.
     *
     * @throws \Exception If the request to GitHub fails.
     */
    private function downloadAndSaveBlob($repo, $filePath, $destinationPath, $token)
    {
        $url = "https://api.github.com/repos/{$repo}/contents/{$filePath}";
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
            'Authorization' => 'Bearer '.$token,
            'X-GitHub-Api-Version' => '2022-11-28',
        ])->get($url);

        if ($response->successful() && isset($response->json()['content'])) {
            $content = base64_decode($response->json()['content']);
            $localFilePath = base_path("{$destinationPath}/{$filePath}");

            File::ensureDirectoryExists(dirname($localFilePath));
            File::put($localFilePath, $content);
        } else {
            throw new \Exception("Failed to download blob: {$filePath}");
        }
    }

    /**
     * Handles the GitHub sync process via the control pnel
     *
     * @param  Request  $request  The current request.
     * @return \Illuminate\Http\JsonResponse The response to return to the user.
     */
    public function make(Request $request)
    {
        if (! $request->input('resource')) {
            session()->flash('error', 'No name provided.');

            return response()->json([
                'status' => 'error',
                'message' => 'No resource provided',
            ]);
        }

        try {
            $this->syncDocs($request->input('resource'));

            session()->flash('success', 'Your documentation has been synced.');

            return response()->json([
                'status' => 'success',
                'message' => 'Documentation synced successfully!',
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error whilst syncing documentation: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Syncs the specified resource to the local file system via a command
     *
     * @param  string  $name  The name of the resource to sync.
     *
     * @throws \Exception If the request to GitHub fails.
     */
    public function runAction($name)
    {
        echo $this->syncDocs($name);
    }

    /**
     * Ensure the specified resource exists in the github-sync config.
     *
     * @param  string  $name  The name of the resource to check.
     *
     * @throws \Exception If the resource does not exist in the config.
     */
    private function ensureConfigExistsForName($name)
    {
        if (! isset(config('dok.resources')[$name])) {
            throw new \Exception("Cannot find resource: {$name}");
        }

        $resource = config('dok.resources')[$name];

        if (! $resource['token'] || ! $resource['repo'] || ! $resource['branch']) {
            throw new \Exception("Missing some configuration for: {$name}");
        }
    }
}
