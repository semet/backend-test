<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);

        return TransactionResource::collection($transactions);
    }

    public function create()
    {
        $products = Product::latest()->get();
        return view('pages.transaction.create', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {

        $product = Product::find(4);

        $response = Http::withHeaders([
            'X-API-KEY' => 'DATAUTAMA',
            'X-SIGNATURE' => Hash('sha256', 'http pot:x-api-key')
        ])->post('http://tes-skill.datautama.com/test-skill/api/v1/transactions', [
            'quantity' => 2,
            'price' => 2,
            'payment_amount' => 2 * 2
        ]);

        $decoded = json_decode($response);
        dd($decoded);
        // if ($decoded->message == 'OK') {
        //     Log::info($decoded);
        //     Transaction::create([
        //         'product_id' => $product->id,
        //         'reference_no' => $decoded->data->reference_no,
        //         'price' => $product->price,
        //         'quantity' => $request->quantity,
        //         'payment_amount' => $decoded->data->payment_amount
        //     ]);

        //     return response()->json([
        //         'msg' => 'Transaction saved'
        //     ]);
        // } else {
        //     Log::info($response);
        // }
    }

    public function search(Request $request)
    {
        $transactions = Transaction::where('reference_no', 'like', '%' . $request->reference_no . '%')->latest()->paginate(10);
        return view('pages.transaction.index', ['transactions' => $transactions]);
    }
}
