@if(view()->exists(config('repeater-blocks.path') . $name))
    @include(config('repeater-blocks.path') . $name)
@endif