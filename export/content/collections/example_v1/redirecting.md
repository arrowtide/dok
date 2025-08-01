---
id: 9f47cb5e-2a42-4818-93ad-1c9394a58e9b
blueprint: example_v1
title: Redirecting
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1741264074
---
# Redirecting

If you are using versions in your routes and are prefixing with the name of your project, you may want to set up redirects.

For example, if you anticipate large version changes and want seperate collections for each version, you might have the following url structure:
```
/docs/1.x
/docs/2.x
...
```

Great! But now `/docs` links to a 404 page. To fix this, you can set up a **Link** (a redirect) page that points to the latest version.

For the case above, we'll add a new **Link** entry in the `pages` collection:
1) Enable `Link` in the **Content Model** section of your collection settings.
2) Go back and create a new entry, and choose **Link** from the options.
3) Fill in the fields and choose your latest versions homepage from the entry selector.
