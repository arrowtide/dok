---
id: 497656ca-57ad-4826-afe7-da099d74563d
blueprint: example_v1
title: Github
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1741267363
---
# Using GitHub

[TOC]

## Introduction
Dok makes it easy to use GitHub as the source for your documentation. You can even mix content sources across collections, you aren't tied to one or the other. This is great when you host your docs within the same repository as your product.

You can even sync content from _different_ owners and organisations as long as your personal access token has the correct permissions.


## Prerequisites
Assumes you have already created a GitHub personal access token. [Learn how to create a personal access token.](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens#creating-a-fine-grained-personal-access-token)

---
## Getting started

1) **Add the fieldset to your blueprint**
Dok comes with a fieldset called `content_github`. On collections you want to use GitHub as the source, you will need to add that fieldset to the corrosponding collection.

2) **Update your config inside of `config/dok.php`**
Add a new array item to your `resources` array. The below is an example. You may need to clear your config cache after changing this.

```php
'resources' => [
  'documentation' => [
       // Your reposistory
       'repo' => 'owner/repo',

       // The branch to get
       'branch' => 'main',

       // An array of folders to get.
       // The below would ONLY sync the 'docs' folder from the main branch.
       'content' => ['docs'],

       // The env variable for your Github token.
       'token' => env('GITHUB_SYNC_TOKEN'),
  ],
],
```

## Syncing

### With the control panel
A utility has been provided in this starterkit to sync via the control panel. Go to `Utilities > Github Sync`.

### With a command
You can run the following command to sync a resource. Replace `your_resource` with the name of your resource.

```shell
php artisan github:sync your_resource
```
