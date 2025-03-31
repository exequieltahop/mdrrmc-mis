<div {{ $attributes->merge(['class' => '']) }}>
    <table class="table {{$tableClass}}" id="{{ $tableId }}">
        <thead>
            @foreach ($ths as $th)
                <th>{{ $th }}</th>
            @endforeach
        </thead>
        <tbody id="{{ $tbodyId }}">
            {{ $slot }}
        </tbody>
    </table>
</div>