<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageBookController extends Controller
{
    public function show($subscriptionPackageId, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($subscriptionPackageId);
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
            ->rawColumns(['coverImg', 'action', 'book_category_id'])
            ->toJson();
        }

        return view('admin.paket-langganan.books', compact('subscriptionPackage'));
    }
}
