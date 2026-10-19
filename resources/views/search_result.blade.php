@extends('layout.app')

@section('content')
    <div class="container py-4">
        {{-- Bagian atas hasil search--}}
        @if (isset($search))
            <h2 class="text-dark mb-4" style="font-weight: bold;">
                Hasil Pencarian: <span>{{ $search }}</span>
            </h2>
        @endif

        {{-- Search & Sort --}}
        @if (isset($category))
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="text-dark fw-bold mb-1">Buku {{ $category->name }}</h2>
                    <span class="text-secondary small">Menampilkan {{ $books->count() }} buku</span>
                </div>

                <form action="{{ route('category.show', $category->id) }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                    {{-- Search Bar --}}
                    <div class="input-icon">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="cari judul atau penulis"
                               style="min-width: 220px;" />
                        <button type="submit" class="input-icon-addon btn p-0 border-0 bg-transparent text-secondary" title="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>

                    {{-- Sort Dropdown --}}
                    <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Buku Terbaru</option>
                    </select>
                </form>
            </div>
        @endif

        {{-- Daftar Buku --}}
        <div class="row g-4">
            @forelse ($books as $book)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card border-0 shadow-sm h-100 d-flex flex-column">
                        <div class="p-3 pb-0">
                            <div class="border rounded d-flex align-items-center justify-content-center bg-light"
                                style="height: 200px;">
                                <img class="img-fluid" alt="{{ $book->title }}"
                                    src="{{ asset($book->cover) }}"
                                    style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column flex-fill">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-secondary text-white">
                                    <i class="fa-solid fa-mobile-screen me-1"></i>E-Book
                                </span>
                            </div>
                            <span style="font-size: 0.8rem;" class="text-secondary">{{ $book->writer }}</span>
                            <h5 class="mb-2 mt-1 font-weight-bold">{{ $book->title }}</h5>
                            <h6 class="mt-auto pt-2" style="font-size: 1.15rem; font-weight: bold;">
                                Rp {{ number_format($book->price, 0, ',', '.') }}
                            </h6>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center">
                    <div class="card py-5 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fa-solid fa-book-open text-muted fs-1 mb-3"></i>
                            <h4 class="fw-bold text-dark">Tidak ada buku ditemukan</h4>
                            <p class="text-secondary mb-3">
                                @if (request('search'))
                                    Tidak ada buku dengan kata kunci "<strong>{{ request('search') }}</strong>".
                                @else
                                    Belum ada buku yang tersedia.
                                @endif
                            </p>
                            @if (isset($category) && (request('search') || request('sort')))
                                <a href="{{ route('category.show', $category->id) }}" class="btn btn-primary btn-sm">
                                    Lihat Semua Buku Kategori Ini
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">
                                    Kembali ke Beranda
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
