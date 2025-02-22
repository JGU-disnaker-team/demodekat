<option value="">Pilih Kota</option>
@foreach ($cities as $city)
    <option value="{{ $city->code }}">{{ $city->name }}</option>
@endforeach
