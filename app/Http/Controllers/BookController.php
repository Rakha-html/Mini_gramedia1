<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $model = Book::query();

            return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('coverImg', function ($row) {
                return '<img src="' . asset($row->cover) . '" alt="cover" style="width: 100px;" class="d-block mx-auto" />';
            })
            ->addColumn('book_category_id', function ($row) {
                return $row->bookCategory?->name ?? '-';
            })
            ->editColumn('price', function ($row) {
                return 'Rp ' . number_format($row->price, 0, ',', '.');
            })
            ->addColumn('action', function ($row) {
               $btnEdit = '<a href="' . route('admin.books.edit', $row->id) . '" class="btn btn-primary me-2">Edit</a>';
                    $btnDelete = '<form action="' . route('admin.books.destroy', $row->id) . '" method="POST" class="d-inline">'
                                . csrf_field()
                                . method_field('DELETE') .
                                '<button type="submit" class="btn btn-danger">Delete</button>
                                </form>';
                $btnDetail = '<button type="button" class="btn btn-primary btn-detail" data-bs-toggle="modal" data-bs-target="#modal-detail"
                            data-cover="'. asset($row->cover) .'"
                            data-title="'. e($row->title) .'"
                            data-category="'. e($row->bookCategory?->name ?? '-') .'"
                            data-price="'. e('Rp ' . number_format($row->price, 0, ',', '.')) .'"
                            data-writer="'. e($row->writer) .'"
                            data-publisher="'. e($row->publisher) .'"
                            data-language="'. e($row->language) .'"
                            data-page-of-book="'. e($row->page_of_book) .'"
                            data-release-date="'. e(date('d M Y', strtotime($row->release_date))) .'"
                            data-description="'. e($row->description) .'"
                            >Detail
                            </button>';
                    return $btnEdit . $btnDelete . $btnDetail;
            })
            ->rawColumns(['coverImg', 'action', 'book_category_id'])
            ->toJson();
        }

        return view('admin.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.create', compact('bookCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cover' => ['required', 'mimes:jpg,jpeg,png,webp,svg'],
            'title' => ['required'],
            'writer' => ['required'],
            'publisher' => ['required'],
            'price' => ['required', 'numeric'],
            'language' => ['required'],
            'description' => ['nullable'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'integer', 'min:1'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
        ]);

        if ($request->File('cover')) {
            $cover = $request->file('cover');
            $namaFile = time() . '_' . $cover->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('covers', $cover, $namaFile);
            //ambil alamat gambar untuk disimpan ke database, timpa data cover di validatsi dengan alamat gambar yang uda di uplod
            $validated['cover'] = Storage::url('covers/' . $namaFile);
        }
        //simpan data ke model book, data yang di simpan data data dari hasil validasi
        Book::create($validated);
        return redirect()->route('admin.books.index')->with('success', 'data buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $bookCategories = BookCategory::all();

        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'writer' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'language' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'integer', 'min:1'],
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'cover' => ['nullable', 'mimes:jpg,jpeg,png,webp,svg'],
        ]);

        $validated['description'] = $validated['description'] ?? '';

        if ($request->hasFile('cover')) {
            $oldCoverPath = str_replace('/storage/', '', $book->cover);
            $cover = $request->file('cover');
            $fileName = $cover->hashName();
            Storage::disk('public')->putFileAs('covers', $cover, $fileName);
            $validated['cover'] = Storage::url('covers/' . $fileName);
        } else {
            unset($validated['cover']);
        }

        $book->update($validated);

        if ($request->hasFile('cover') && Storage::disk('public')->exists($oldCoverPath)) {
            Storage::disk('public')->delete($oldCoverPath);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {   
        if($book->cover){
            $oldImagePath = str_replace('/storage/','',$book->cover);

            if(Storage::disk('public')->exists($oldImagePath)){
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
