<option value="">Pilih Kecamatan</option>
@foreach ($districts as $district)
    <option value="{{ $district->code }}">{{ $district->name }}</option>
@endforeach
