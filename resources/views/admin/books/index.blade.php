@extends('layout.app')

@section('content')
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku</h3>
            <a href="{{ route('admin.books.create') }}" class="btn btn-success">Tambah Data Buku</a>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-3" id="data-buku">
        <thead>
            <tr>
                <th>#</th>
                <th>Sampul Buku</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

        {{-- Modal detail --}}
        <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="" alt="" id="data-cover" class="img-fluid" width="200">
                    </div>
                    <div class="col-md-8">
                        <h3 class="text-primary" id="data-title"></h3>
                        <p class="badge badge-primary" id="data-category"></p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Harga<br><span id="data-price" class="text-success"></span></p>
                                <p>Penerbit<br><span id="data-publisher"></span></p>
                                <p>Tanggal Rilis<br><span id="data-release_date"></span></p>
                            </div>
                            <div class="col-sm-6">
                                <p>Penulis<br><span id="data-writer"></span></p>
                                <p>Bahasa<br><span id="data-language"></span></p>
                                <p>Jumlah Halaman<br><span id="data-page_of_book"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p class="mb-2">deskripsi</p>
                        <div id="data-description" class="border rounded p-3" style="height: 220px; overflow-y: auto; white-space: pre-line; background-color: #f5f5f5;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
        </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#data-buku").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [
                    //data dan name: nama kolom, searchable : bisa di search ga datanya, orderable: bisa di urutin ga datanya
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'coverImg', name: 'coverImg', orderable: false, searchabel: false},
                    {data: 'title', name: 'title'},
                    {data: 'writer', name: 'writer'},
                    {data: 'book_category_id', name: 'bookcategory.name'},
                    {data: 'price', name: 'price', orderable: true, searchabel: true},
                    {data: 'action', name: 'action', orderable: false, searchabel: false},
                ]
            });
            //proses memunculkan modal ketika btn detail diklick
            $("#data-buku").on('click', '.btn-detail', function(){
                const btn = $(this);

                $("#data-cover").attr('src', btn.data('cover'));
                $("#data-title").text(btn.data('title'));
                $("#data-category").text(btn.data('category'));
                $("#data-price").text(btn.data('price'));
                $("#data-publisher").text(btn.data('publisher'));
                $("#data-writer").text(btn.data('writer'));
                $("#data-language").text(btn.data('language'));
                $("#data-page_of_book").text(btn.data('pageOfBook'));
                $("#data-release_date").text(btn.data('releaseDate'));
                $("#data-description").html(btn.data('description'));

                let cover = btn.data('cover');
                $("#data-cover").attr('src', cover);

                $("#detailBookModal").modal('show');
            })
        })
    </script>
@endpush
