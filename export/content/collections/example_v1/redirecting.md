---
id: 9f47cb5e-2a42-4818-93ad-1c9394a58e9b
blueprint: example_v1
title: Redirecting
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1741264074
---
# Redirecting

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