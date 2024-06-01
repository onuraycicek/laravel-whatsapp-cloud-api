<div class="d-flex flex-column gap-3">

    <div class="row">

        <div class="col-6">
            <div class="form-group">
                <label for="from-phone-number">From Phone Number ID</label>
                <select class="form-control" id="from-phone-number" name="from-phone-number">
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="to-phone-number">To Phone Number</label>
                <input type="text" class="form-control" id="to-phone-number" name="to-phone-number">
            </div>
        </div>

    </div>
    <div class="row">

        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label for="file">File</label>
            <input type="file" class="form-control" id="file" name="file" multiple>
        </div>
    </div>
    <button id="sendMessage" type="button" class="btn btn-primary mt-3">Send Message</button>
</div>

@push('scripts')
    <script>
        $("#sendMessage").click(function() {
            // $.post("{{ route('send-message') }}", {
            //     "from_phone_number_id": $("#from-phone-number").val(),
            //     "to_phone_number": $("#to-phone-number").val(),
            //     "message": $("#message").val(),

            // }, function(data) {
            //     console.log(data);
            // });
            // post with files
            var formData = new FormData();
            formData.append("from_phone_number_id", $("#from-phone-number").val());
            formData.append("to_phone_number", $("#to-phone-number").val());
            formData.append("message", $("#message").val());
            var files = $("#file")[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append("file[]", files[i]);
            }
            $.ajax({
                url: "{{ route('send-message') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
    <script>
        $("#from-phone-number").append(new Option(DEFAULT_FROM_PHONE_NUMBER_ID, DEFAULT_FROM_PHONE_NUMBER_ID));
        $("#to-phone-number").val(DEFAULT_TO_PHONE_NUMBER);
    </script>
    <script>
        document.addEventListener("tableLoaded", function(e) {
            $("#from-phone-number").empty();

            PHONE_NUMBERS = $(".phone-number-id").map(function() {
                return $(this).text();
            }).get();

            PHONE_NUMBERS.forEach(function(phoneNumber) {
                $("#from-phone-number").append(new Option(phoneNumber, phoneNumber));
            });

            if (!PHONE_NUMBERS.includes(DEFAULT_FROM_PHONE_NUMBER_ID)) {
                $("#from-phone-number").append(new Option(DEFAULT_FROM_PHONE_NUMBER_ID,
                    DEFAULT_FROM_PHONE_NUMBER_ID));
            }

        });
    </script>
@endpush
