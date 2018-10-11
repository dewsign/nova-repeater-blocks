@if(view()->exists(config('repeater-blocks.path') . $template_name))
    @include(config('repeater-blocks.path') . $template_name)
@endif