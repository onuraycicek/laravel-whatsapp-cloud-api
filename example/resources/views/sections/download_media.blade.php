<div class="d-flex flex-column gap-3">

    <div class="form-group">
        <label for="media-id">
            Media ID
        </label>
        <input class="form-control" id="media-id" name="media-id" type="text">
    </div>

    <div id="response">
        <img src="" alt="Placeholder" class="img-fluid">
    </div>

</div>

<button id="downloadMedia" type="button" class="btn btn-primary mt-3">
    Download Media
</button>
</div>

@push('scripts')
    <script>
        $("#downloadMedia").click(function() {

            $.ajax({
                url: "{{ route('download-media') }}",
                type: 'POST',
                data: {
                    "media_id": $("#media-id").val()
                },
                success: function(data) {
                    $("#response img").attr("src", data);
                }
            });
        });
    </script>
@endpush
