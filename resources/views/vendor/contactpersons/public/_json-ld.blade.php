{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $contactperson->title }}",
    "description": "{{ $contactperson->summary !== '' ? $contactperson->summary : strip_tags($contactperson->body) }}",
    "image": [
        "{{ $contactperson->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $contactperson->uri() }}"
    }
}
</script>
--}}
