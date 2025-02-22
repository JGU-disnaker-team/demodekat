<option value="">Pilih Kelurahan</option>
@foreach ($villages as $village)
    <option value="{{ $village->code }}">{{ $village->name }}</option>
@endforeach
