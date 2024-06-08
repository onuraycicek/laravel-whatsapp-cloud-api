<div class="d-flex flex-column gap-3">

    <div class="row">

        <div class="col-6">
            <div class="form-group">
                <label for="template-from-phone-number">From Phone Number ID</label>
                <select class="form-control" id="template-from-phone-number" name="from-phone-number">
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="template-to-phone-number">To Phone Number</label>
                <input type="text" class="form-control" id="template-to-phone-number" name="to-phone-number">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="form-group">
            <label for="file">Template</label>
            <select class="form-control" id="template-name" name="template-name">
            </select>
        </div>
    </div>
    <button id="sendTemplateMessage" type="button" class="btn btn-primary mt-3">Send Message</button>
</div>

@push('scripts')
    <script>
        $("#sendTemplateMessage").click(function() {
            var formData = new FormData();
            formData.append("from_phone_number_id", $("#template-from-phone-number").val());
            formData.append("to_phone_number", $("#template-to-phone-number").val());
            formData.append("template_name", $("#template-name").val());
            $.ajax({
                url: "{{ route('send-template-message') }}",
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
        $("#template-from-phone-number").append(new Option(DEFAULT_FROM_PHONE_NUMBER_ID, DEFAULT_FROM_PHONE_NUMBER_ID));
        $("#template-to-phone-number").val(DEFAULT_TO_PHONE_NUMBER);
    </script>
    <script>
        document.addEventListener("tableLoaded", function(e) {
            $("#template-from-phone-number").empty();

            PHONE_NUMBERS = $(".phone-number-id").map(function() {
                return $(this).text();
            }).get();

            PHONE_NUMBERS.forEach(function(phoneNumber) {
                $("#template-from-phone-number").append(new Option(phoneNumber, phoneNumber));
            });

            if (!PHONE_NUMBERS.includes(DEFAULT_FROM_PHONE_NUMBER_ID)) {
                $("#template-from-phone-number").append(new Option(DEFAULT_FROM_PHONE_NUMBER_ID,
                    DEFAULT_FROM_PHONE_NUMBER_ID));
            }

            //template-messages
            $("#template-name").empty();
            var TEMPLATE_MESSAGES = $(".template-message-name").map(function() {
                return $(this).text();
            }).get();

            TEMPLATE_MESSAGES.forEach(function(templateMessage) {
                $("#template-name").append(new Option(templateMessage, templateMessage));
            });

        });
    </script>
@endpush
