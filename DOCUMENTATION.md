
## Using GitHub as your content source
Dok makes it easy to use GitHub as the source for your documentation. You can even mix content sources across collections, you aren't tied to one or the other. This is great when you host your docs within the same repository as your product. 

You can even sync content from _different_ owners and organisations as long as your personal access token has the correct permissions. 

### Prerequisites
* Assumes you have already created a GitHub personal access token. [Learn how to create a personal access token.](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens#creating-a-fine-grained-personal-access-token)

---

#### 1) Add the fieldset to your blueprint
Dok comes with a fieldset called `content_github`. On collections you want to use GitHub as the source, you will need to add that fieldset to the corrosponding collection.

#### 2) Update your config inside of `documentation.php`
Add a new array item to your `paths` array. The below is an example. You may need to clear your config cache after changing this. 

```php
'resources' => [
	'MonsterSEO' => [
		'repo' => 'owner/repo',
		'branch' => 'main',

		// If you want to sync just these folders 
		// from within the repo.
		'content' => ['docs'],
		'token' => env('GITHUB_SYNC_TOKEN'),
	],
],
```
	
#### 3) Get syncing 
You should now see your resource within the GitHub sync utilty page (`example.com/cp/utilities/github-sync`). If you can't see it - clear your config cache. You can now sync that resource.

Alternatively you can run the following command:
```bash
php artisan github:sync [your-resource-name]

# Using the example above, your resource name would be 'documentation'
```


## Adding new projects & versions
Projects and versions are all managed within the **releases** collection.

### Adding a new project
You don't need to do anything special for adding a project. You can go started straight away by adding the version below. 

### Adding a new version

For this example, let's say we've just built a new plugin called `Monster SEO` and it's version is `1.0`.

1) **Add a new collection in the control panel**

   Enter the name and version. It's recommended to follow a consistent naming convention:
   ```yaml
    # Title 
    Monster SEO v1
	
	# Slug
	monster_seo_v1.yaml
   ```

2) **Configure your collection**

    These are the settings you will need to change:

   	| Setting    | Value |
	| -------- | ------- |
	| Orderable  | true |
	| Expect a root page | true |
	| Slugs    | true   |
	| Template    | docs/home    |
	| Route    | monster_seo/1.x/{{ slug }} |
	

3) **Create the navigation**

	Add a brand new navigation in the control panel. You will be prompted to enter a **title** and **slug**. Follow the same pattern as when creating your collection:
   ```yaml
    # Title 
    Monster SEO v1
	
	# Slug
	monster_seo_v1.yaml
   ```

4) **Add a new release**

	Add a new release in the control panel by going to the **Releases** collection. Add a new entry and fill in all of your details.


## Redirecting
If you are using versions in your routes and are prefixing with the name of your project, you may want to set up redirects.

```
/docs/1.x
```
Using the example above your homepage for that collection will be mapped to the `1.x`, if you wanted to navigate to `/docs` this page wouldn't be found. 

For this reason we ship Dok with a [redirect](https://statamic.com/addons/alt-design/alt-redirects) plugin by the amazing folks at [Alt Design](https://statamic.com/creators/alt-design). 

Simply add a redirect for that URL in the plugins settings page that points to the latest version:

| From    | To | Type |
| -------- | ------- | ------- |
| `/docs` | `/docs/1.x` | 302 |


## Search
Dok doesn't come with search configured. There are so many different ways to do search we didn't want to package one. [Docsearch by Algolia](https://docsearch.algolia.com/) is the quickest and easiest to set up on your site.

## Code Highlighting
Dok comes packaged with [spatie/commonmark-shiki-highlighter](https://github.com/spatie/commonmark-shiki-highlighter) for easy code highlighting. You can of course swap this out for another package like Torchlight. 

Shiki runs every page load, so it's recommended to have some sort of static caching. [Learn more about static caching in Statamic](https://statamic.dev/static-caching). Alternativly you may choose to use the [`{{ cache }}`](https://statamic.dev/tags/cache) tags instead. 

Dok adds an environment variable called `SHIKI_ENABLED` that you can use to toggle this feature.

```
SHIKI_ENABLED=true
```



### Theming 

You can change your theme by changing the `theme` parameter inside of your `AppServiceProvider.php`
```php
Markdown::addExtension(function () {
    return new HighlightCodeExtension(theme: 'material-theme-lighter');
});
```

[View a list of available themes.
](https://github.com/shikijs/textmate-grammars-themes/tree/main/packages/tm-themes)


## Markdown
Dok comes with two commonmark extensions pre-installed. These are initiated inside of `AppServiceProvider.php` and their config is managed at `config/statamic/markdown.php`.

You can reference the commonmark documentation for extra information on either the [Table of Contents](https://commonmark.thephpleague.com/2.6/extensions/table-of-contents/) or [Heading Permalink](https://commonmark.thephpleague.com/2.6/extensions/heading-permalinks/) extensions.
