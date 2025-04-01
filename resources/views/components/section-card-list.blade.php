<section {{ $attributes->merge(['class' => 'container-fluid m-0 p-0 w-100 overflow-auto']) }}>
    <div class="card">
        <div class="card-header">
            <h5 class="m-0 text-primary">{{ $listTitle }}</h5>
        </div>
        <div class="card-body {{$cardBodyClass}}">
            {{ $slot }}
        </div>
    </div>
</section>