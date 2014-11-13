---
title: Control Change Log

---

## Version 2.2 {#v2-2}

### v2.2.2 {#v2-2-2}

* Allow Roles table to be search and sorted using `Orchestra\Html\Table\Grid` new functionality.
* Use full PHP syntax.

### v2.2.1 {#v2-2-1}

* Filter theme to only to be shown when the theme support it.
* Add events to attach fields to roles.

### v2.2.0 {#v2-2-0}

* Bump minimum version to PHP v5.4.0.
* Add support for Orchestra Platform 2.2.

## Version 2.1 {#v2-1}

### v2.1.5 {#v2-1-5}

* Improves CSRF support.

### v2.1.4 {#v2-1-4}

* Filter theme to only to be shown when the theme support it.
* Add events to attach fields to roles.


### v2.1.3 {#v2-1-3}

* Added events to hook into the role management.

### v2.1.2 {#v2-1-2}

* Fixes `Orchestra\Control\ExtensionConfigHandler` type-hint to use `Illuminate\Support\Fluent` instead of array.
* Fixes control theme switcher CSS issue.

### v2.1.1 {#v2-1-1}

* Fixed missing `Orchestra\Control\Presenter\AbstractablePresenter` class and add some tests.

### v2.1.0 {#v2-1-0}

* Update support for Orchestra Platform v2.1
* Implement passive controllers for `orchestra/control`.

## Version 2.0 {#v2-0}

### v2.0.13 {#v2-0-13}

* Implement [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard.

### v2.0.12 {#v2-0-12}

* Update menu to support subdomain handling.
* Implement `Orchestra\Model\Role::setDefaultRoles()`.

### v2.0.11 {#v2-0-11}

* Fixed Bootstrap 3 panel CSS.

### v2.0.10 {#v2-0-10}

* Use facade instead of alias.
* Update PHPUnit configuration.
* Fixed CSS styling based on Bootstrap 3-RC2.
* Remove `src/orchestra.php` as no longer required.

### v2.0.9 {#v2-0-9}

* Update Form/Table builder to use view from orchestra/foundation.

### v2.0.8 {#v2-0-8}

* Move bootstrap process to `Orchestra\Control\ControlServiceProvider`.
* Tweak Travis-CI integration.

### v2.0.7 {#v2-0-7}

* Add .img-thumbnail to theme screenshot.

### v2.0.6 {#v2-0-6}

* Fixed unable to save ACL metric.

### v2.0.5 {#v2-0-5}

* Optimised UX.

### v2.0.4 {#v2-0-4}

* Fixed usage of `Orchestra\Resources` visible option.
* Revert use of `.checkbox-inline` and use bootstrap grid.
* Fixed syncing roles issue on `vendor/package` ACL metric.
* Improve ACL name to show extension name if exist.
* Fixed route filter not is called before registered.

### v2.0.3 {#v2-0-3}

* Move folder structure to follow strict PSR-0.
* Changes CSS and HTML structure to follow current Orchestra Platform structure.

### v2.0.2 {#v2-0-2}

* Tweak design to match Bootstrap 3.

### v2.0.1 {#v2-0-1}

* Fixed unable to change backend theme.

### v2.0.0 {#v2-0-0}

* Add Role, ACL and Theme Management support.

