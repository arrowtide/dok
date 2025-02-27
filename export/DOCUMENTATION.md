
## Using GitHub as your content source
Dok makes it easy to use GitHub as the source for your documentation. You can even mix content sources across collections, you aren't tied to one or the other. This is great when you host your docs within the same repository as your product. 

You can even sync content from _different_ owners and organisations as long as your personal access token has the correct permissions. 

### Prerequisites
* Assumes you have already created a GitHub personal access token. [Learn how to create a personal access token](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens#creating-a-fine-grained-personal-access-token)

---

#### 1) Add the fieldset to your blueprint
Dok comes with a fieldset called `content_github`. On collections you want to use GitHub as the source, you will need to add that fieldset to the corrosponding collection.

#### 2) Update your config inside of `github_sync.php`
Add a new array item to your `paths` array. The below is an example. You may need to clear your config cache after changing this. 

```php
'documentation' => [
	 // Your reposistory
	 'repo' => 'owner/repo',

	 // The branch to get
	 'branch' => 'main',

	 // Will sync to content/docs/documentation
	 'destination' => 'documentation',

	 // An array of folders to get. The below would ONLY sync the 'docs' folder from the main branch.
	 'content' => ['docs'],

	 // The env variable for your Github token. 
	 'token' => env('GITHUB_SYNC_TOKEN'),
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

	Add a new release in the control panel by going to the **Releases** collection. Add a new entry and fill in all of your details. If you're creating an entirely new project, you can type into the `Project` select field to add a new name.


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

If you do want to include your own search, you can uncomment the search button inside `resources/views/docs/partials/document/header.antlers.html`. This gives you an idea of styles you can use for the button, or you can change it to an input if you run your own search. 
