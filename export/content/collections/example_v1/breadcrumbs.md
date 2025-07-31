---
id: 3993552d-7262-454c-ac31-eed45c6a47b2
blueprint: example_v1
title: Breadcrumbs
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1753967819
---

# Breadcrumbs

Breadcrumbs are used to indicate the current navigational context of a page.

Dok uses a custom tag to display breadcrumbs that are based on the **_navigation_**, instead of of the **_uri_**. This allows you to have a consistent context for users, and a different collection structure than the one used for navigation.

```antlers
{{ release:breadcrumbs }}
    <span>
        {{ title }}
    </span>
{{ /release:breadcrumbs }}
```


