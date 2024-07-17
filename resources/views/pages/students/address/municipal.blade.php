@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

<input type="hidden" value="1" class="verify">

<select name="municipal" id="select-municipal" class="form-select" disabled>
    @if(!empty($municipal))
        <option value="">Select...</option>
        @foreach ($municipal as $mun)
            <option value="{{ $aes->encrypt($mun->citymunCode) }}">{{ ucwords(strtolower($mun->citymunDesc)) }}</option>
        @endforeach
    @else
        <option value="">Please select province first</option>
    @endif
</select>