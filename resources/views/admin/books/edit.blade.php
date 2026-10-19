@extends('layout.app')

@section('content')
    @php
        $releaseDate = $book->release_date
            ? \Illuminate\Support\Carbon::parse($book->release_date)->format('Y-m-d')
            : '';
    @endphp
    <form action="{{ route('admin.books.update', $book) }}" method="POST" class="card w-75 d-block mx-auto mt-5" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-header">
            <h3>Edit Buku</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="book_category_id" class="form-label">Kategori Buku</label>
                    <select name="book_category_id" id="book_category_id" class="form-select">
                        <option value="" disabled hidden>Pilih Kategori Buku</option>
                        @foreach ($bookCategories as $category)
                            <option value="{{ $category->id }}" {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    @error('book_category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $book->title) }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="writer" class="form-label">Penulis</label>
                    <input type="text" name="writer" id="writer" class="form-control" value="{{ old('writer', $book->writer) }}">
                    @error('writer')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" value="{{ old('publisher', $book->publisher) }}">
                    @error('publisher')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $book->price) }}">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="language" class="form-label">Bahasa</label>
                   @php
                       $language = array_unique([
                           $book->language,
                           'Indo',
                           'English',
                           'Japan',
                           'Arabic',
                       ]);
                   @endphp
                  <select name="language" id="language" class="form-select">
                        <option value="" disabled hidden>Pilih Bahasa</option>
                        @foreach ($language as $lang)
                            <option value="{{ $lang }}" {{ old('language', $book->language) == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                        @endforeach
                  </select>
                  @error('language')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="release_date" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="release_date" class="form-control" id="release_date" value="{{ old('release_date', $releaseDate) }}">
                    @error('release_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                    <input type="number" name="page_of_book" class="form-control" id="page_of_book" value="{{ old('page_of_book', $book->page_of_book) }}">
                    @error('page_of_book')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <label for="cover" class="form-label">Sampul Buku</label>
                    @if ($book->cover)
                    <div class="mb-2">
                        <img src="{{ asset($book->cover) }}" alt="Cover Buku" style="width: 100px; height: 150px; object-fit: contain;" class="img-thumbnail">
                          <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah sampul</small>
                    </div>

                    @endif
                    <input type="file" name="cover" id="cover" class="form-control">
                    @error('cover')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="description"></div>
                    <input type="hidden" name="description" id="description-input" value="{{ old('description', $book->description) }}">
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row" style="margin-top: 8%">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
{{-- library DOMpurify untuk sanitasi XSS agar aman --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.8/purify.min.js"></script>
<script>
  const quill = new Quill('#description', {
    theme: 'snow'
  });

  const descriptionInput = document.getElementById('description-input');
  if (descriptionInput.value) {
    quill.clipboard.dangerouslyPasteHTML(descriptionInput.value);
  }

  quill.on('text-change', function() {
    descriptionInput.value = quill.root.innerHTML;
  });
</script>
@endpushhom