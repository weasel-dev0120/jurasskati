<ul class="flat-list-results-list">
    @foreach ($items as $flat)
    <li class="flat-list-results-item">
        <a class="flat-list-results-item-link" href="{{ $flat->uri() }}" title="{{ $flat->title }}">
            <span class="flat-list-results-item-title">{{ $flat->title }}</span>
        </a>
    </li>
    @endforeach
</ul>
