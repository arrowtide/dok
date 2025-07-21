---
id: de4f9439-e246-4532-8cd7-141aff07a0cf
blueprint: example_v1
title: 'Projects & Versions'
updated_by: cbf6fa94-2658-4dec-9152-30c80d3c652c
updated_at: 1741271329
---
# Projects & Versions

[TOC]

## Overview
Projects and versions are all managed within the **releases** collection.


## Adding a new project
1) Head over to the `releases` collection.
2) Add a new entry.
3) Select **Project**.

## Adding a new version

For this example, let's say we've just built a new plugin called `Kitty` and its version is `1.0`.


### 1) Create a new collection

1) **Add a new collection in the control panel**
 	Enter the name and version. It's recommended to follow a consistent naming convention:
    
   	| Title    | Slug |
	| -------- | ------- |
	| Kitty v1  | kitty_v1 |
    | Kitty v2  | kitty_v2 |

2) **Configure your collection**

    These are the settings you will need to change:

   	| Setting    | Value |
	| -------- | ------- |
	| Orderable  | true |
	| Expect a root page | true |
	| Slugs    | true   |
	| Template    | docs/home |
    | Layout   | docs/layout |
	| Route    | kitty/1.x/{{ slug }} |
	
### 2) Create the navigation
Add a brand new navigation in the control panel. You will be prompted to enter a **title** and **slug**.
    
### 3) Add a new release
Head over to the **releases** collection, create a new entry, and select **Release** from the dropdown to create a new version. 

Fill in the details to create your new version.

### 4) Add a stable release
Go to the **project** entry and fill in the `Latest stable release` field with the version of your choosing.