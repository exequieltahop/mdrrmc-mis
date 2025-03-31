<section {{ $attributes->merge(['class' => 'container-fluid m-0 p-0']) }}>
    <div class="card">
        <div class="card-header">
            <h5 class="m-0 text-primary">{{ $listTitle }}</h5>
        </div>
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</section>