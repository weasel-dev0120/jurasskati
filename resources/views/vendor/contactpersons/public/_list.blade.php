<ul class="contactperson-list-list">
    @foreach ($items as $contactperson)
    @include('contactpersons::public._list-item')
    @endforeach
</ul>
