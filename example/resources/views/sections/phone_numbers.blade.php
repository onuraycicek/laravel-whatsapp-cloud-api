<!-- table -->
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Verified Name</th>
      <th scope="col">Code Verification Status</th>
      <th scope="col">Display Phone Number</th>
      <th scope="col">Quality Rating</th>
      <th scope="col">Platform Type</th>
      <th scope="col">Throughput</th>
      <th scope="col">Webhook Configuration</th>
      <th scope="col">ID</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($phoneNumbers as $phoneNumber)
      <tr>
        <td>{{ $phoneNumber['verified_name'] }}</td>
        <td>{{ $phoneNumber['code_verification_status'] }}</td>
        <td>{{ $phoneNumber['display_phone_number'] }}</td>
        <td>{{ $phoneNumber['quality_rating'] }}</td>
        <td>{{ $phoneNumber['platform_type'] }}</td>
        <td>{{ json_encode($phoneNumber['throughput'], JSON_PRETTY_PRINT) }}</td>
        <td>{{ json_encode($phoneNumber['webhook_configuration'], JSON_PRETTY_PRINT) }}</td>
        <td class="phone-number-id">{{ $phoneNumber['id'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>