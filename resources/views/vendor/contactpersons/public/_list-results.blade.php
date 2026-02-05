<ul class="contactperson-list-results-list">
    @foreach ($items as $contactperson)
    <li class="contactperson-list-results-item">
        <a class="contactperson-list-results-item-link" href="{{ $contactperson->uri() }}" title="{{ $contactperson->title }}">
            <span class="contactperson-list-results-item-title">{{ $contactperson->title }}</span>
        </a>
    </li>
    @endforeach
</ul>
