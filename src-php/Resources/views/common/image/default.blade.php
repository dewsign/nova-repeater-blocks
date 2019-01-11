<div class="image image--{{ $style }}">
    @isset($link)
        <a href="{{ $link }}">
    @endisset
        <img src="{{ $repeaterContent->default_image }}" alt="{{ $alt_content }}" />
    @isset($link)
        </a>
    @endisset
</div>
