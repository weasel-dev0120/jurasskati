<li class="contactperson-list-item">
    <a class="contactperson-list-item-link" href="{{ $contactperson->uri() }}" title="{{ $contactperson->title }}">
        <div class="contactperson-list-item-title">{{ $contactperson->title }}</div>
        <div class="contactperson-list-item-image-wrapper">
            @empty (!$contactperson->image)
            <img class="contactperson-list-item-image" src="{{ $contactperson->present()->image(null, 200) }}" width="{{ $contactperson->image->width }}" height="{{ $contactperson->image->height }}" alt="{{ $contactperson->image->alt_attribute }}">
            @endempty
        </div>
    </a>
</li>
