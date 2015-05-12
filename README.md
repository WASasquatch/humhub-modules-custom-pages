Custom Pages Extended
============

Allows admins to add custom pages (html, **php**, or markdown), widgets (php), iframes or external links to various navigations (e.g. top navigation, account menu).

- __Status:__ Alpha v0.2.4-3
- __Module website:__ <https://github.com/WASasquatch/humhub-modules-custom-pages-extended/>
- __Author:__ Jordan Thompson, Luke
- __Author website:__ [Jordan Thompson @ HumHub](http://community.humhub.org)
- __Releases:__ <https://github.com/WASasquatch/humhub-modules-custom-pages-extended/releases>

### New Features in Extended Version

- **Widgets** - Create widgets on various pages that allow endless possiblies!
- **PHP** Pages for [Inline-Module](#php-page--widget-usage) Creation!
- **Active User Model** data passed for Inline-Module creation.
- **Active Space Model** data passed to Space Widgets for Inline-Module creation
- Set link target for external/internal links.
- Set unlisted pages which will not appear on menus
- **More Soon** ...

### Installation

- Simply drop the module as **custom_pages** into your `/protected/modules/` folder
- Activate the module

### Updating from Custom Pages or Previous Version

You can update Custom Pages with Custom Pages Extended. To do so, follow these simple directions

- Overwrite the `modules/custom_pages/` with the new source code
- Disable the module from Admin Control center
- Enable the module to migrate the database

Alternatively you can update with **YIIC** with the following command: `path/to/php yiic migrate --migrationPath=custom_pages.migrations`

### PHP Page / Widget Usage

- The PHP pages run off the eval() functioning, meaning all supplied input needs to be already in PHP Mode. Do not start, or end with `<?php ... ?>`, instead write as if already in PHP Mode. 
- One of the most important things to remember is you are writing PHP in the confines of Yii and HumHub and must write within those standards. 
- You can use the object var `$user` to access user information such as the user display name `$user->displayName`
- When using Widget Type **Space (Sidebar Widget)** you can access the space information with the `$space` variable. For example to access the space name you would use `$space->name`

### What is a Inline-Module
A Inline-Module is a form of module that is ran all within one file hooked into the main system it is extending. Usually these forms of modules are included `include()` into a application that updates regularily, allowing your code to be seperate and easily modified/re-included.  

### Examples

- [Example PHP Page Inline-Module HStats](docs/example-hstats.md)
- [Example Widget "Welcome Back"](docs/widget-example-1.md)
- *Submit your own Widget/PHP examples to `docs/` via pull requests, and help others learn!*


For more  information visit parent module:
<https://github.com/humhub/humhub-modules-custom-pages>
