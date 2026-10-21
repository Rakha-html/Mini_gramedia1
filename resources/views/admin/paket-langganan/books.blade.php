@extends('layout.app')

@section('content')
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h3>Data Buku yang akan dipilih untuk paket langganan <b>{{ $subscriptionPackage->name }}</b></h3>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-3" id="data-buku">
        <thead>
            <tr>
                {{-- th kosong untuk ceklis --}}
                <th></th>
                <th>#</th>
                <th>Sampul Buku</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

        {{-- Modal detail --}}

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#data-buku").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.paket-langganan.books', $subscriptionPackage->id) }}",
                columns: [
                    // yg dikirimkan ketika menceklis buku itu id nya
                    // data isinya dari data: 'id'
                    // nama pake [ ] karena yang diceklis bisa lebih dari 1 buku (dibuat jadi aray)
                    {data: 'id', name: 'id', searchable: false, orderable: false, render: function(data) {
                        return `<input type="checkbox" value="${data}" name="book_id[]" class="book-checkbox">`;
                        // class book-checkbox ditambahkan untuk mendetek jumlah checkbox yang diceklis nantinya
                    }},
                    //data dan name: nama kolom, searchable : bisa di search ga datanya, orderable: bisa di urutin ga datanya
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'coverImg', name: 'coverImg', orderable: false, searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'book_category_id', name: 'book_category_id', orderable: false, searchable: false},
                    {data: 'price', name: 'price', orderable: true, searchable: true},
                ]
            });
            })

    </script>
@endpush
