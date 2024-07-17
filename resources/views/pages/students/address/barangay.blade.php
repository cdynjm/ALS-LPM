@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

<input type="hidden" value="1" class="verify">

<select name="barangay" id="select-barangay" class="form-select" disabled>
    @if(!empty($barangay))
        <option value="">Select...</option>
        @foreach ($barangay as $brgy)
            <option value="{{ $aes->encrypt($brgy->brgyCode) }}">{{ $brgy->brgyDesc }}</option>
        @endforeach
    @else
        <option value="">Please select province and municipal first</option>
    @endif
</select>