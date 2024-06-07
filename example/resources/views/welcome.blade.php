<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WCA Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>


    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-md-12">
                <h1>WCA Demo</h1>
                <p>This is a demo for the WCA API</p>
            </div>
        </div>

        <div class="row gy-5">

            <div class="col-12">
                <x-table url="{{ route('phone-numbers') }}" header="Phone Numbers" />
            </div>


            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Send Message
                    </div>
                    <div class="card-body">
                        @include('sections.send_message')
                    </div>
                </div>
            </div>


            <div class="col-6">
                <x-table url="{{ route('business-profile') }}" header="Business Profile" class="h-100" />
            </div>

            <div class="col-12">
                <x-table url="{{ route('template-messages') }}" header="Template Messages" />
            </div>

        </div>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- -------------------------------------- -->
    <script>
        var event;
        let PHONE_NUMBERS = [];
        const DEFAULT_FROM_PHONE_NUMBER_ID = "{{ env('WCA_FROM_PHONE_NUMBER_ID') }}";
        const DEFAULT_TO_PHONE_NUMBER = "{{ env('WCA_TARGET_PHONE_NUMBER') }}";
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- -------------------------------------- -->
    <script>
        const tableLoaded = (id) => {
            event = new CustomEvent('tableLoaded', {
                detail: {
                    id: id
                }
            });
            document.dispatchEvent(event);
        }
    </script>
    <script>
        const refreshTable = (id) => {
            $("#" + id + " .card-body").html("Loading...");
            $.get($("#" + id).data("url"), (data) => {
                    $("#" + id + " .card-body").html(data);
                    tableLoaded(id);
                })
                .fail(function() {
                    $("#" + id + " .card-body").html("An error occured");
                });
        }
    </script>
    @stack('scripts')
</body>

</html>
