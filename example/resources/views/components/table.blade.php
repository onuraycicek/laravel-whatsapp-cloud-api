@props(['url', 'id' => 'table-' . Str::random(8), 'header' => 'Table', 'refresh' => true, 'class' => ''])

<div  {{$attributes->merge(['class' => 'card p-0'])}} 
    id="{{$id}}"
data-url="{{$url}}">
    <div class="card-header">
        {!! $header !!}
    </div>
    <div class="card-body">
        Loading...
    </div>
    @if($refresh)
    <div class="card-footer">
        <button class="btn btn-primary mx-auto d-block" onclick="refreshTable('{{$id}}')">Refresh</button>
    </div>
    @endif
</div>
@push('scripts')
<script>
    $.get("{{$url}}", function(data){
        $("#{{$id}} .card-body").html(data);
        tableLoaded("{{$id}}");
    });
</script>
@endpush