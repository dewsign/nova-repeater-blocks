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

## Usage (Nova UI)

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
