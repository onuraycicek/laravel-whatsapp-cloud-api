<div>
    <div>
        <span class="fw-bold">from_phone_number_id:</span>
        <span>{{ $fromPhoneNumberId }}</span>
    </div>
    @foreach ($businessProfile as $key => $value)
        <div>
            <span class="fw-bold">{{ $key }}:</span>
            <span>{{ $value }}</span>
        </div>
    @endforeach

</div>
