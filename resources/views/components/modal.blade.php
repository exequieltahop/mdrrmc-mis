<div {{$attributes->merge(['class' => 'modal fade'])}} id="{{$modalId}}" tabindex="-1" aria-hidden="true" aria-labelledby="{{$modalId}}-modal-title">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-0 text-primary" id="{{$modalId}}-modal-title">{{$modalTitle}}</h5>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>