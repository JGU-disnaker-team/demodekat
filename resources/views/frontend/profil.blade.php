@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('update_profil') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Profil
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama Lengkap" for="name" name="name"
                                    value="{{ $data->name }}" :error="$errors->first('name')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.email label="email" for="email" name="email"
                                    value="{{ $data->email }}" :error="$errors->first('email')" required></x-form.email>
                            </div>
                            <div class="col-md-6">
                                <x-form.password label="password" for="password" name="password"
                                     :error="$errors->first('password')"></x-form.password>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="no_telp" for="no_telp" name="no_telp"
                                    value="{{ $data->no_telp }}" :error="$errors->first('no_telp')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Nomor Rekening" for="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening', $data->no_rekening) }}" :error="$errors->first('no_rekening')" required></x-form.text>
                            </div>
                            <!-- Dropdown Provinsi -->
                            <div class="col-12">
                                <label for="province">Provinsi</label>
                                <select name="province_code" id="province" class="form-control" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->code }}" {{ $province->code == Auth::user()->province_code ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Kota -->
                            <div class="col-12">
                                <label for="city">Kota/Kabupaten</label>
                                <select name="city_code" id="city" class="form-control" required>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    
                                </select>
                            </div>

                            <!-- Dropdown Kecamatan -->
                            <div class="col-12">
                                <label for="district">Kecamatan</label>
                                <select name="district_code" id="district" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <!-- Dropdown Kelurahan -->
                            <div class="col-12">
                                <label for="village">Kelurahan/Desa</label>
                                <select name="village_code" id="village" class="form-control" required>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="RT" for="rt" name="rt"
                                    value="{{ $data->rt }}" :error="$errors->first('rt')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="RW" for="rw" name="rw"
                                    value="{{ $data->rw }}" :error="$errors->first('rw')" required></x-form.text>
                            </div>
                            <div class="col-md-12">
                                <x-form.text label="alamat" for="alamat" name="alamat"
                                    value="{{ $data->alamat }}" :error="$errors->first('alamat')" required></x-form.text>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Info data
                    </div>
                    <div class="card-body">
                        
                        
                        <div class="mb-3">
                            <x-form.file label="image" for="image" name="image" data-default-file="{{ $data->avatar_url }}"
                                :error="$errors->first('image')"></x-form.file>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary "><i
                                class="fa fa-save me-2"></i>Simpan</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Debug untuk memastikan jQuery dan event berjalan
    console.log('Document ready');
    
    // Fungsi untuk memuat data kota
    function loadCities(provinceCode, selectedCity = '') {
        console.log('Loading cities for province:', provinceCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-cities/' + provinceCode,
            type: 'GET',
            success: function(data) {
                console.log('Cities response:', data); // Debug
                $('#city').empty();
                $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
                data.forEach(function(city) {
                    $('#city').append(`<option value="${city.code}" ${city.code == selectedCity ? 'selected' : ''}>${city.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    // Fungsi untuk memuat data kecamatan
    function loadDistricts(cityCode, selectedDistrict = '') {
        console.log('Loading districts for city:', cityCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-districts/' + cityCode,
            type: 'GET',
            success: function(data) {
                console.log('Districts response:', data); // Debug
                $('#district').empty();
                $('#district').append('<option value="">Pilih Kecamatan</option>');
                data.forEach(function(district) {
                    $('#district').append(`<option value="${district.code}" ${district.code == selectedDistrict ? 'selected' : ''}>${district.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading districts:', error);
            }
        });
    }

    // Fungsi untuk memuat data desa/kelurahan
    function loadVillages(districtCode, selectedVillage = '') {
        console.log('Loading villages for district:', districtCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-villages/' + districtCode,
            type: 'GET',
            success: function(data) {
                console.log('Villages response:', data); // Debug
                $('#village').empty();
                $('#village').append('<option value="">Pilih Kelurahan/Desa</option>');
                data.forEach(function(village) {
                    $('#village').append(`<option value="${village.code}" ${village.code == selectedVillage ? 'selected' : ''}>${village.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading villages:', error);
            }
        });
    }

    // Event listener untuk perubahan provinsi
    $('#province').on('change', function() {
        const provinceCode = $(this).val();
        console.log('Province changed to:', provinceCode); // Debug
        if (provinceCode) {
            loadCities(provinceCode);
            $('#district').empty().append('<option value="">Pilih Kecamatan</option>');
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kota
    $('#city').on('change', function() {
        const cityCode = $(this).val();
        console.log('City changed to:', cityCode); // Debug
        if (cityCode) {
            loadDistricts(cityCode);
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kecamatan
    $('#district').on('change', function() {
        const districtCode = $(this).val();
        console.log('District changed to:', districtCode); // Debug
        if (districtCode) {
            loadVillages(districtCode);
        }
    });

    // Load data awal jika ada nilai yang tersimpan
    const initialProvinceCode = '{{ Auth::user()->province_code }}';
    const initialCityCode = '{{ Auth::user()->city_code }}';
    const initialDistrictCode = '{{ Auth::user()->district_code }}';
    const initialVillageCode = '{{ Auth::user()->village_code }}';

    console.log('Initial values:', { 
        province: initialProvinceCode,
        city: initialCityCode,
        district: initialDistrictCode,
        village: initialVillageCode
    });

    if (initialProvinceCode) {
        loadCities(initialProvinceCode, initialCityCode);
    }
    if (initialCityCode) {
        loadDistricts(initialCityCode, initialDistrictCode);
    }
    if (initialDistrictCode) {
        loadVillages(initialDistrictCode, initialVillageCode);
    }
});
</script>
@endpush