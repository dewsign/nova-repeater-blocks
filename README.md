# Repeater Blocks for Laravel Nova

Enable repeatable content blocks through Polymorphic relationships on Nova resources.

## Installation

Install the repeater blocks package through composer

```sh
composer require dewsign/nova-repeater-blocks
```

Run the migrations. Note: This package uses a single table to manage all polymorphic repeater blocks so there is no need to modify any existing tables!

```php
php artisan migrate
```

## Nova UI

For this readme we will use a basic Blog example where a Blog Post is generated from multiple Rich Text Editor style repeatable content blocks (e.g. Text, Image.)

First add the trait to your Model

```php
// app/Post.php
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Post extends Model {
    use HasRepeaterBlocks;
    ...
}
```

Then create a Resource to define the repeater blocks for this Model/Resource (e.g. Posts). This can be more generic if you are planning on sharing the same blocks on different models. Extend the base resource provided.

```php
// app/Nova/PostRepeater.php

use App\Nova\RbText;
use Illuminate\Http\Request;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;

class PostRepeater extends Repeater
{
    // One or more Nova Resources which use this Repeater
    public static $morphTo = 'App\Nova\Post';

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        return [
            RbText::class,
            RbImage::class,
        ];
    }
}
```

Now we need to create `RbText` and `RbImage`, both of which are just standard Nova Resources with an extra Trait. You are free to name them however you like and you can simply create them as you would any other Laravel Model and Resource.

```sh
php artisan make:model -m RbText
```

```php
// app/RbText.php
<?php
use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class RbText extends Model
{
    use IsRepeaterBlock;

    // Optional: To use a special template outside of the standard naming contention to render a block, define it here.
    public static $repeaterBlockViewTemplate = 'any.blade.view';
}
```

```php
// app/Nova/RbText.php

use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;

class RbText extends Resource
{
    use IsRepeaterBlockResource;

    public function fields(Request $request)
    {
        return [
            Select::make('Format')->options([
                'p' => 'Paragraph',
                'h2' => 'Heading',
            ]),
            Text::make('Text'),
        ];
    }
    ...
}
```

Finally, within your Nova Post Resource, create the relationship.

```php
// app/Nova/Post.php

class Post extends Resource
{
    public function fields(Request $request)
    {
        return [
            ...
            MorphMany::make(__('Repeaters'), 'repeaters', PostRepeater::class),
        ];
    }
}
```

## Front-end blade output

This package includes a blade helper to render repeater blocks on a model. Simply pass your entire model into the helper to render all the repeaters in their sorting order.

```php
@repeaterblocks($model)

// Optionally wrap each repeater with before and after code.
@repeaterblocks($model, '<div>', '</div>')
```

The following naming sequence will be used to find the correct template to render. The first view found will be used. The namespace is a slugified version of the full class namespace of the model

```php
    [
        $repeaterBlockViewTemplate,
        'repeaters.app.rbtext', // App\RbText
        'nova-repeater-blocks::app.rbtext',
        'repeaters.default',
        'nova-repeater-blocks::default',
    ]
```

The repeater block view will receive the following parameters:

|Key|Content Type|Purpose|
|---|----|---|
|repeater|Object|The complete repeater base model|
|repeaterKey|String|The key used to find the template|
|repeaterShortKey|String|The short name of the model without namespace|
|repeaterContent|Object|The full related model|
|{attributes}|Mixed|All the attributes from the model as variables|

Typically the easiest way to access the data in your repeater view is to access the attributes directly as variables. For the above example given this could be.

```php
// rbtext.blade.php

<{{ $format }}>
    {{ $text }}
</{{ $format }}>
```

There is also a helper for json output (Handy for Javascript front ends). Same as before, just pass the model in to generate json output.

```php
@repeaterjson($model)
```

## Customisation

If you want to display additional fields in the repeaters index view you can merge computed properties into the fields method. Be sure to include the parent fields though. It is best to include the custom fields at the beginning of the fields array.

```php
// app/Nova/PostRepeater.php

public function fields(Request $request)
{
    return array_merge([
        Text::make('Format', function () {
            return $this->type->format;
        })->onlyOnIndex(),
    ], parent::fields($request))
}
```

**NOTE:** Laravel 2.0 introduced a `reverse` meta field which throws an error when using `BelongsTo` fields in Repeaters. You'd typically never have a reverse relationship on nested repeaters so we avoid this situation by using the include `RepeatableBelongsTo` field instead.

There is an included `getExtraInfo()` function that allows you to pass in any information you would like displayed on the Repeaters index view inside the Laravel Nova Admin UI.

To pass data into this, call `getExtraInfo()` on your repeater resource.

```php
// app/Repeaters/Common/Blocks/SampleRepeaterBlock.php

    public function getExtraInfo()
    {
        return $this->template;
    }
```

## Custom View Block

The custom view block allows you to use an HTML view template as a repeater block.  To use this block, the custom templates you create must be stored in the path defined in the `repeater-blocks` configuration file.  By default, the path for your custom templates is `resources/views/repeaters/custom`.

Once your custom views have been created, they will be available in the 'Template Name' dropdown list when you select the 'Custom View' repeater type.

## Containers

All the default blocks included can be Containerised. Essentially a way of grouping multiple repeaters in a container. You can create new container types by creating new templates inside the `resources/views/vendor/nova-repeater-blocks/container` directory. These will automatically appear in the Select options.

You can allow custom repeater blocks to be containerised by adding the `CanBeContainerised` trait to the model and `ResourceCanBeContainerised` to the Block resource.

## Images

### Styles

You can create multiple image styles by adding new templates to the `/views/vendor/nova-repeater-blocks/common/image` resource folder. The system will fallback to the default style if a view is not found.

### Image Processing

The config provides an easy way to customise the Image Processor. Create a new class with a compatible get method which can return the processed image url. Each Item template can have a unique image processor. Some common template names are included but they all render the default template (typically sufficient when combined with the Image Processor).

Here is an example of a custom Image Processor to replace the defaults

```php
namespace App\Processors;

use Illuminate\Support\Facades\Storage;
use Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor;

class DefaultImageProcessor extends ImageProcessor
{
    public static function get(string $image, array $params = [])
    {
        // Process the image and perform any special tasks before returning the final Image URL.

        return $myImageURL;
    }

    public static function delete(string $image)
    {
        // Handle the deletion of the image (e.g. from a remote filesystem)
    }
}
```

You can now assign this processor to any of the default (and custom) image styles in the `repeater-blocks` config.

```php
return [
    ...
    'images' => [
        ...
        'processors' => [
            'default' => App\Processors\DefaultImageProcessor::class,
        ],
    ],
    ...
];
```

Within your views, on repeater blocks you can use the `default_iamge` helper or you can use ImageProcessors directly to process any image by calling `DefaultImageProcessor::get('path/to/image')`.

## Advanced Nested Repeater Blocks

Any repeater block can have more nested repeater blocks if desired. In order to achieve this, the repeater block model must have a `types` method indicating what types can be added to the block. Each of these types must include a `sourceTypes` method, you should be able to simply reference the parent block `types`.

```php
class GridBlock extends Model
{
    use IsRepeaterBlock;
    use HasRepeaterBlocks;

    public static $repeaterBlockViewTemplate = 'repeaters.grid';

    public static function types()
    {
        return [
            \App\Nova\GridBlockItem::class,
        ];
    }
}
```

```php
class GridBlockItem extends Model
{
    use IsRepeaterBlock;

    public static $repeaterBlockViewTemplate = 'repeaters.gridItem';

    public static function sourceTypes()
    {
        return GridBlock::types();
    }
}
```
