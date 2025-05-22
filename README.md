# MageHx_HtmxActions

A Magento 2 module that enhances HTMX integration by providing structured controllers, events, view models, services, and enums to streamline dynamic HTML responses.

An HTMX request expects an HTML snippet in response, which will be dynamically swapped into the frontend page.

This module provides many utilities to ease this process.

It offers a convenient base for handling common HTMX response scenarios, allowing you to return HTML fragments efficiently and consistently.

---

## ✨ Features

* **Abstract Controller**: Simplifies handling HTMX requests with a base controller.
* **Event Dispatching**: Fires events during the HTMX request lifecycle for extensibility.
* **View Models**: Provides view models to assist in rendering HTMX attributes in templates.
* **Header Management Service**: Offers a service to manage HTMX-specific response headers.
* **Enumerations**: Defines enums for HTMX attributes and headers to ensure consistency.
* **HTMX Attribute Renderers**: Includes traits for rendering HTMX attributes in templates.

---

## 📦 Installation

Install the module via Composer:

```bash
composer require magehx/htmx-actions
```

---

## 🔧 Usage

### Abstract Controller

Extend the `MageHx\HtmxActions\Controller\HtmxAction` to handle HTMX requests:

  - `getBlockResponse()` - This allows to retrieve a block response from the given layout handles.
  - `getMultiBlockResponse()` - This allows to retrieve combined blocks response from the given layout handles.
  - `getEmptyResponse()` - Gives empty response. Useful when you decided to not swap the content in the frontend.

```php
use MageHx\HtmxActions\Controller\HtmxAction;

class Example extends HtmxAction
{
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        return $this->getBlockResponse('your.block.name', ['your_layout_handle']);
    }
}
```

#### Event Dispatching

The controller dispatches useful events during the HTMX request lifecycle:

* `hxactions_block_response_before`: Fires before preparing the block response. Useful to add more layout handles or change the block itself.
* `hxactions_block_response_after`: Fires after preparing the block response. Useful to change the response.
* `hxactions_multi_blocks_response_before`: Fires before preparing the multi block response.
* `hxactions_multi_blocks_response_after`: Fires after preparing the multi block response.

Observers can be created to listen to these events for custom logic.

---

### View Models

`MageHx\HtmxActions\ViewModel\HxAttributesRenderer` provides many convenient ways to render HTMX attributes on HTML elements

```php
<?php
/** @var MageHx\HtmxActions\ViewModel\HxAttributesRenderer $hxAttrRenderer */
?>

<button 
    <?= $hxAttrRenderer->post('/submit') ?>
    <?= $hxAttrRenderer->target('#result') ?>
>Submit</button>
```
The outputs will look like this:
```html
<button hx-post="/submit" hx-target="#result">Submit</button>
```

You can also chain attributes using the `hxBuilder()` method for rendering HTMX attributes. Example:

```php
<?php
/** @var MageHx\HtmxActions\ViewModel\HxAttributesRenderer $hxAttrRenderer */
?>

<button 
    <?= $hxAttrRenderer->hxBuilder()
        ->post('/submit')
        ->target('#result')
        ->render() ?>
>Submit</button>
```

This will also give you the same result as in the first case.

There are many other methods supported like `get`, `indicator`, `swap` and many more.

---

### Header Management Service

Utilize the `MageHx\HtmxActions\Service\HtmxHeaderReader` to manage HTMX request/response headers:

```php
// to verify the request is an HTMX request.
$manager->isHtmxRequest(); 
// Here you can set a header value to the response.
$manager->setHeader($response, \MageHx\HtmxActions\Enums\HtmxResponseHeader::RESWAP, \MageHx\HtmxActions\Enums\HtmxSwapOption::NONE->value);
```

and there are many more such useful header methods available there.

---

### Enumerations

The module defines enums for HTMX attributes and headers:

* `HtmxCoreAttributes`: Includes `get`, `post`, `target`, `swap`, `trigger`, etc.
* `HtmxAdditionalAttributes`: Includes `boost`, `indicator`, etc.
* `HtmxHeaders`: Includes `HX-Trigger`, `HX-Redirect`, `HX-Refresh`, etc.

These enums ensure consistency and reduce typos in attribute names.

---

## 🔗 Requirements

* Magento 2.4.0+
* PHP 8.1+

---

## 🛠️ License

This module is open-sourced software licensed under the [MIT license](LICENSE).

---

## 💬 Feedback / Contributions

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/magehx/htmx-actions/issues).

---
