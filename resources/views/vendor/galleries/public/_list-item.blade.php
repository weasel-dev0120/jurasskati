<li class="gallery-list-item">
    <a class="gallery-list-item-link" href="{{ $gallery->uri() }}" title="{{ $gallery->title }}">
        <div class="gallery-list-item-title">{{ $gallery->title }}</div>
        <div class="gallery-list-item-image-wrapper">
            @empty (!$gallery->image)
            <img class="gallery-list-item-image" src="{{ $gallery->present()->image(null, 200) }}" width="{{ $gallery->image->width }}" height="{{ $gallery->image->height }}" alt="{{ $gallery->image->alt_attribute }}">
            @endempty
        </div>
    </a>
</li>
