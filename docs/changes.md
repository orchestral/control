---
title: Control Change Log

---

## Version 3.1 {#v3-1}

### v3.1.4 {#v3-1-4}

* Remove debugging code.

### v3.1.3 {#v3-1-3}

* `Orchestra\Control\ControlServiceProvider` should utilize the new `Orchestra\Foundation\Support\Providers\ModuleServiceProvider`.

### v3.1.2 {#v3-1-2}

* Add `Orchestra\Control\ControlPlugin`.

### v3.1.1 {#v3-1-1}

* Improved performances by reducing call within `Illuminate\Container\Container`.
* Utilize `Orchestra\Support\Providers\EventProviderTrait` and separate events on to separate class.

### v3.1.0 {#v3-1-0}

* Update support for Orchestra Platform v3.1.
* Convert filter to middleware.

## Version 3.0 {#v3-0}

### v3.0.5 {#v3-0-5}

* Removing debugging code.

### v3.0.4 {#v3-0-4}

* Include csrf token for deleting role route.

### v3.0.3 {#v3-0-3}

* Fixes missing delete roles route.

### v3.0.2 {#v3-0-2}

* Rename `Orchestra\Control\Authorize` to `Orchestra\Control\Command\Synchronizer`.
* Convert `Orchestra\Control\Command\Synchronizer` to not use static method.
* Add `Orchestra\Control\Contracts\Command\Synchronizer` contract.
* Restructure menu views.

### v3.0.1 {#v3-0-1}

* Rename `Orchestra\Control\ControlMenuHandler` to `Orchestra\Control\Http\Handlers\ControlMenuHandler`.
* Move `Orchestra\Control\Presenter` namespace to `Orchestra\Control\Http\Presenters`.
* Move `Orchestra\Control\Routing` namespace to `Orchestra\Control\Http\Controllers`.
* Rename `Orchestra\Control\Http\Handlers\ControlMenuHandler::getPosition()` method to `Orchestra\Control\Http\Handlers\ControlMenuHandler::getPositionAttribute()`.

### v3.0.0 {#v3-0-0}

* Update support to Orchestra Platform v3.0.
* Simplify PSR-4 path.
* Use basic routing instead of `orchestra/resources`.
* Move all start-up files to service provider.

## Version 2.2 {#v2-2}

### v2.2.4 {#v2-2-4}

* Add `src/migrations` to composer autoload classmap.
* Sync ACL after synchronizing roles.

### v2.2.3 {#v2-2-3}

* Improves CSRF support.

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

### v2.1.6 {#v2-1-6}

* Add `src/migrations` to composer autoload classmap.
* Sync ACL after synchronizing roles.

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

