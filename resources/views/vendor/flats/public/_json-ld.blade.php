{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $flat->title }}",
    "description": "{{ $flat->summary !== '' ? $flat->summary : strip_tags($flat->body) }}",
    "image": [
        "{{ $flat->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $flat->uri() }}"
    }
}
</script>
--}}
