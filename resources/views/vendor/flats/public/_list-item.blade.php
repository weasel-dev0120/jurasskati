<li class="flat-list-item">
    <a class="flat-list-item-link" href="{{ $flat->uri() }}" title="{{ $flat->title }}">
        <div class="flat-list-item-title">{{ $flat->title }}</div>
        <div class="flat-list-item-image-wrapper">
            @empty (!$flat->image)
            <img class="flat-list-item-image" src="{{ $flat->present()->image(null, 200) }}" width="{{ $flat->image->width }}" height="{{ $flat->image->height }}" alt="{{ $flat->image->alt_attribute }}">
            @endempty
        </div>
    </a>
</li>
