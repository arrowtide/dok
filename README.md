A beautiful documentation starter kit.

## **New in v2.0:**
* Added Torchlight Engine as the recommended **code highlighter**.
* New **hints** extension for callouts, tips etc.
* New **copy code** button.
* New **language label** (Torchlight Engine only).
* New custom breadcrumbs that work from the _navigation_ instead of the current URI.
* Better designed sidebar navigation. You can now choose between 3 different templates that come with different styles and functionality.
* Enhanced visual styles.
* Numerous other fixes and accessibility improvements.

## Features
* Tailwind 4
* AlpineJS
* Light & Dark theme
* Easily create **new themes** with css variables
* [**Phosphor Icons**](https://phosphoricons.com) used as icons
* Add an unlimited amount of **projects**
* Unlimited **versions** per project
* Fully **accessible**
* Built for **fast loading times**
* Simple progressive **View Transitions**
* **Highly customisable** typography styles
* Host your content on **Statamic** or **Github**
* Sync from GitHub, even from multiple **repositories** and **organisations**.
* Sync via **control panel**, on a **command**
* **Permalink** and **Table of contents** markdown extensions preinstalled.
* Torchlight Engine or Shiki for **code highlighting**

### Projects and versions
You can host multiple projects and manage different versions for each project. This is handled through the releases collection. To add a new project or version, simply create a new entry in the collection and configure the required fields.

### Statamic as a content source
Wanna just write markdown directly to Statamic? Yup, you can do that.

### GitHub as a content source
If you'd like to host your documentation within a project repository to keep everything centralized, Dok makes the process simple. All you need is a GitHub Personal Access Token and a small update to your configuration file. Once that's done, you can easily link entries to their corresponding resource paths.

Content is linked to the Entry using a Computed Value.

### Styling
Dok comes with a light and dark theme, along with a full set of custom typography styles all using **Tailwind v4**. This means there is **no Tailwind configuration file**, just CSS files. Yay 🎉.

### Browser support
Dok supports the latest versions of all major browsers. We use progressive enhancement where possible.

### Compiling Assets
By default, we use a simple Vite configuration that comes with every new Statamic site when using the CLI tool so you should feel right at home.

`npm run dev` - Watches your content, rebuilds, and refreshes your browser so you can instantly see the changes.

`npm run build` - Build for production


## Installation

**Installing with Statamic CLI (recommended)**

Get up and running in an instant with the Statamic CLI tool. This will install a fresh Statamic instance with Dok installed.

```bash
statamic new mysite arrowtide/dok
```

**Installing into an existing site**
```bash
php please starter-kit:install arrowtide/dok
```

