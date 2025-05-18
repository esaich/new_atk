<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::select('id', 'supplier', 'alamat')->get();
        return view('payments.index', compact('suppliers'));
    }

    public function getData()
    {
        $payments = Payments::with('supplier')->get()->map(function ($payment) {
            return [
                'id' => $payment->id,
                'invoice_number' => $payment->invoice_number,
                'supplier_name' => $payment->supplier->supplier ?? '-',
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'payment_date' => $payment->payment_date->format('Y-m-d'),
                'status' => $payment->status,
                'description' => $payment->description,
            ];
        });

        return response()->json(['data' => $payments]);
    }

    public function store(Request $request)
    {
        $rules = [
            'invoice_number' => 'required|string|max:50',
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'payment_date' => 'required|date',
            'status' => 'required|in:Paid,Pending,Cancelled',
            'description' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $payment = Payments::create($request->only([
            'invoice_number', 'supplier_id', 'amount', 'payment_method', 'payment_date', 'status', 'description'
        ]));

        return response()->json([
            'message' => 'Payment berhasil ditambahkan',
            'data' => $payment,
        ]);
    }

    public function destroy($id)
    {
    $payment = Payments::find($id);

    if (!$payment) {
        return response()->json(['message' => 'Payment tidak ditemukan'], 404);
    }

    try {
        $payment->delete();
        return response()->json(['message' => 'Payment berhasil dihapus']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Gagal menghapus payment', 'error' => $e->getMessage()], 500);
    }
}

}
