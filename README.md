Custom Pages Extended
============

Allows admins to add custom pages (html, **php**, or markdown), widgets (php), iframes or external links to various navigations (e.g. top navigation, account menu).

- __Status:__ Alpha v0.2.4
- __Module website:__ <https://github.com/WASasquatch/humhub-modules-custom-pages-extended/>
- __Author:__ Jordan Thompson, Luke
- __Author website:__ [Jordan Thompson @ HumHub](http://community.humhub.org)

### New Features in Extended Version

- **Widgets** Create widgets with inline-modules!
- **PHP** Pages for Inline-Module Creation!
- **Active User Model** data passed for Inline-Module creation, or other software, such as use for chat nicknames.
- Create Unlisted Pages
- Set link target *(Currently broken)*
- **More Soon** ...

### Installation

- Simply drop the module as **custom_pages** into your `/protected/modules/` folder
- Activate the module

### PHP Page / Widget Usage

- The PHP pages run off the eval() functioning, meaning all supplied input needs to be already in PHP Mode. Do not start, or end with `<?php ... ?>`, instead write as if already in PHP Mode. 
- You can use the object var `$user` to access user information such as the user display name `$user->displayName`
- When using Widget Type **Space (Sidebar Widget)** you can access the space information with the `$space` variable. For example to access the space name you would use `$space->name`

### What is a Inline-Module
A Inline-Module is a form of module that is ran all within one file hooked into the main system it is extending. Usually these forms of modules are included `include()` into a application that updates regularily, allowing your code to be seperate and easily modified/re-included.  

For more  information visit parent module:
<https://github.com/humhub/humhub-modules-custom-pages>

### Examples

- [Example PHP Page Inline-Module HStats](docs/example-hstats.md)
- [Example Widget "Welcome Back"](docs/widget-example-1.md)
- *Submit your own Widget/PHP examples to `docs/` via pull requests, and help others learn!*
