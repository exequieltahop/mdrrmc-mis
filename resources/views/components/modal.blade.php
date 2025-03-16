<div {{$attributes->merge(['class' => 'modal fade', 'id' => $id])}} tabindex="-1" aria-hidden="true" aria-labelledby="{{$id}}-modal-title">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-0" id="{{$id}}-modal-title">{{$modalTitle}}</h5>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
        </div>
    </div>
</div>