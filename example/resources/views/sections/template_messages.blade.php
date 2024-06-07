{{-- @dd($templateMessages) 
    array:3 [ // resources/views/sections/template_messages.blade.php
  0 => array:6 [
    "name" => "marketing"
    "components" => array:2 [
      0 => array:2 [
        "type" => "BODY"
        "text" => "Merhaba marketing template test"
      ]
      1 => array:2 [
        "type" => "FOOTER"
        "text" => "alt bilgi"
      ]
    ]
    "language" => "tr"
    "status" => "APPROVED"
    "category" => "MARKETING"
    "id" => "1313618432862141"
  ]
  1 => array:6 [
    "name" => "hello_world"
    "components" => array:3 [
      0 => array:3 [
        "type" => "HEADER"
        "format" => "TEXT"
        "text" => "Hello World"
      ]
      1 => array:2 [
        "type" => "BODY"
        "text" => "Welcome and congratulations!! This message demonstrates your ability to send a WhatsApp message notification from the Cloud API, hosted by Meta. Thank you for taking the time to test with us."
      ]
      2 => array:2 [
        "type" => "FOOTER"
        "text" => "WhatsApp Business Platform sample message"
      ]
    ]
    "language" => "en_US"
    "status" => "APPROVED"
    "category" => "UTILITY"
    "id" => "2758331414310103"
  ]
  2 => array:6 [
    "name" => "sample_template"
    "components" => array:3 [
      0 => array:3 [
        "type" => "HEADER"
        "format" => "TEXT"
        "text" => "Hello World"
      ]
      1 => array:2 [
        "type" => "BODY"
        "text" => "Welcome and congratulations!! This message demonstrates your ability to send a WhatsApp message notification. Thank you for taking the time to test with us."
      ]
      2 => array:2 [
        "type" => "FOOTER"
        "text" => "WhatsApp Business Platform sample message"
      ]
    ]
    "language" => "en_US"
    "status" => "APPROVED"
    "category" => "UTILITY"
    "id" => "657451862855595"
  ]
]
    


    --}}


    <!-- table -->
    <div class="card">
        <div class="card-header">
            Template Messages
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Language</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Components</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templateMessages as $templateMessage)
                        <tr>
                            <td>{{ $templateMessage['name'] }}</td>
                            <td>{{ $templateMessage['language'] }}</td>
                            <td>{{ $templateMessage['status'] }}</td>
                            <td>{{ $templateMessage['category'] }}</td>
                            <td>
                                <ul>
                                    @foreach ($templateMessage['components'] as $component)
                                        <li>{{ $component['type'] }}: {{ $component['text'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>