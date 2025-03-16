<div {{ $attributes->merge(['class' => 'form-floating mb-4']) }}>
    <input type="{{$inputType}}" id="{{$name}}" name="{{$name}}" placeholder="" class="form-control text-primary" {{ $required ? 'required' : '' }}>
    <label for="{{$name}}">{{$label}}</label>
</div>