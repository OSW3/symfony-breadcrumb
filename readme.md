# Symfony Breadcrumb

Add breadcrumbs to your app pages.

## How to install

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require osw3/symfony-breadcrumb
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php 
// config/bundles.php

return [
    // ...
    OSW3\Breadcrumb\BreadcrumbBundle::class => ['all' => true],
];
```

### Step 3: Expose the Bundle to Twig

```yaml
twig_component:
    defaults:
        #...
        OSW3\Breadcrumb\Twig\Components\: '@Breadcrumb/'
```

## How to use

### Step 1: Edit controllers

Edit each controller that needs breadcrumb and add the "Breadcrumb" attribute.

```php 
class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product')]
    #[Breadcrumb([['label' => "Products", 'route' => "app_product"]])]
    public function index(): Response
    {
        // ...
    }
}
```

or add multiple items

```php 
class BookController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    #[Breadcrumb([
        ['label' => "Products", 'route' => "app_product"]
        ['label' => "Books", 'route' => "app_books"]
    ])]
    public function index(): Response
    {
        // ...
    }
}
```

### Step 2: The twig component

In your twig files use : 

```html
<twig:Breadcrumb />
```

Or wtih custom ID and/or custom class 

```html 
<twig:Breadcrumb id="my-custom-id" class="my-custom-class" />
```

## How to configure

The breadcrumb configuration is located at `config/package/breadcrumb.yaml`.

Configuration sample

```yaml
breadcrumb:
    home:
        label: Home
        route: app_homepage
        icon: 'fa fa-home'
        domain: null
    template: default
    separator: null
    items:
        class: null
        absolute: false
    hide_empty: true
```