@extends('layout.app')

@section('content')
    <div class="card mt-5 w-50 d-block mx-auto">
        <div class="card-header">
            <h2>Tambah Paket langganan</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Paket langganan belum lengkap.</strong> Silakan isi semua field yang wajib diisi.
                </div>
            @endif

            <form action="{{ route('admin.paket-langganan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control @error('name')
                        is-invalid
                        @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" value="{{ old('price') }}" min="0" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                    <div class="mb-3">
                        <label for="color_text" class="form-label mb-2">Warna</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color"
                                class="form-control @error('color') is-invalid @enderror"
                                id="color_text"
                                name="color"
                                value="{{ old('color') }}"
                                placeholder="masukan warna"
                                required>

                                <input type="color"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    id="color_picker"
                                    value="{{ old('color', '#000000') }}">
                            </div>
                            @error('color')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                    </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
