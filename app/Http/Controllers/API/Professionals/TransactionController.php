<?php

namespace App\Http\Controllers\API\Professionals;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
     public function index()
    {
        $transactions = Transaction::with('items')->where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        return response()->json($transactions);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:income,expense,disbursement',
            'amount' => 'required_if:type,income|numeric|min:0',
            // 'notes' => 'required',
            'invoice_id' => 'nullable|exists:invoices,id',
            
            // **THE FIXES ARE HERE:**
            'title' => 'required_if:type,expense|string|max:255', // This is correct
            'items' => 'required_if:type,expense|array|min:1',
            'items.*.description' => 'required|string|max:255', // Changed from 'title' to 'description'
            'items.*.amount' => 'required|numeric|min:0',
            
            'date' => 'required|date_format:Y-m-d',
            'payment_method' => 'required|string',
            'category' => 'required_if:type,expense|string|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'project_id' => 'nullable|exists:projects,id',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Use validatedData data for security
        $validatedData = $validator->validated();

        $transaction = DB::transaction(function () use ($validatedData) {
            $data = [
                'user_id' => Auth::id(),
                'type' => $validatedData['type'],
                'date' => $validatedData['date'],
                'payment_method' => $validatedData['payment_method'],
                'category' => $validatedData['category'] ?? null,
                'contact_id' => $validatedData['contact_id'] ?? null,
                'project_id' => $validatedData['project_id'] ?? null,
                'appointment_id' => $validatedData['appointment_id'] ?? null,
                'title' => $validatedData['title'] ?? null,

            ]; 

            if ($validatedData['type'] === 'income' || $validatedData['type'] === 'disbursement' ) {
                $data['amount'] = $validatedData['amount'];
                $data['invoice_id'] = $validatedData['invoice_id'] ?? null;
                $transaction = Transaction::create($data);
            } else { // Expense
                // $data['description'] = $validatedData['items']['description'];
                $data['amount'] = collect($validatedData['items'])->sum('amount');

                // Create the parent transaction first
                $transaction = Transaction::create($data);

                // Then create the associated items in the new table
                $transaction->items()->createMany($validatedData['items']);
            }

            return $transaction;
        });

        // Load the items relationship for the response
        return new TransactionResource($transaction->load('items'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:income,expense, disbursement',
            'amount' => 'required_if:type,income|numeric|min:0',
            'invoice_id' => 'nullable|exists:invoices,id',

            'title' => 'required_if:type,expense|string|max:255',
            'items' => 'required_if:type,expense|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.amount' => 'required|numeric|min:0',

            'date' => 'required|date_format:Y-m-d',
            'payment_method' => 'required|string',
            'category' => 'required_if:type,expense|string|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'project_id' => 'nullable|exists:projects,id',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $transaction = DB::transaction(function () use ($transaction, $validatedData) {
                    $data = [
                'type' => $validatedData['type'],
                'date' => $validatedData['date'],
                'payment_method' => $validatedData['payment_method'],
                'category' => $validatedData['category'] ?? null,
                'contact_id' => $validatedData['contact_id'] ?? null,
                'project_id' => $validatedData['project_id'] ?? null,
                'appointment_id' => $validatedData['appointment_id'] ?? null,
                'title' => $validatedData['title'] ?? null,
            ];

            if ($validatedData['type'] === 'income') {
                $data['amount'] = $validatedData['amount'];
                $data['invoice_id'] = $validatedData['invoice_id'] ?? null;

                $transaction->update($data);
            } else { // Expense
                $data['amount'] = collect($validatedData['items'])->sum('amount');

                $transaction->update($data);

                // Remove old items first
                $transaction->items()->delete();

                // Insert new items
                $transaction->items()->createMany($validatedData['items']);
            }

            return $transaction;
        });

        return new TransactionResource($transaction->load('items'));
    }

    public function show($id)
    {
         $transaction = Transaction::with('items')->find($id);

        if (is_null($transaction)) {
            return response()->json([
                'message' => 'Transaction not found',
                'status' => false
            ], 200); // better to send real 404 status
        }

        // Structure response differently based on type
        if ($transaction->type === 'income' || $transaction->type === 'disbursement') {
            return response()->json([
                'id' => $transaction->id,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'invoice_id' => $transaction->invoice_id,
                'date' => $transaction->date,
                'title' => $transaction->title,
                'payment_method' => $transaction->payment_method,
                'category' => $transaction->category,
                'contact_id' => $transaction->contact_id,
                'project_id' => $transaction->project_id,
                'appointment_id' => $transaction->appointment_id,
            ]);
        }

        // Expense response
        return response()->json([
            'id' => $transaction->id,
            'type' => $transaction->type,
            'title' => $transaction->title,
            'amount' => $transaction->amount,
            'date' => $transaction->date,
            'payment_method' => $transaction->payment_method,
            'category' => $transaction->category,
            'contact_id' => $transaction->contact_id,
            'project_id' => $transaction->project_id,
            'appointment_id' => $transaction->appointment_id,
            'items' => $transaction->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'amount' => $item->amount,
                ];
            }),
        ]);
    }





    public function delete($id)
    {
        try {
            DB::beginTransaction();

            // Find transaction
            $transaction = Transaction::with('items')->find($id);

            if (!$transaction) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaction not found',
                ], 404);
            }

            // Delete items if any
            if ($transaction->items && $transaction->items->count() > 0) {
                $transaction->items()->delete();
            }

            // Delete transaction itself
            $transaction->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaction deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        $category = TransactionCategory::create([
            'title' => $request->title,
            'type' => $request->type,
            'user_id' => Auth::user()->id, 
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function listCategory()
    {
        $transactions = TransactionCategory::where('type', 'expense')
            ->where('user_id', Auth::user()->id)
            ->latest() // orders by created_at DESC
            ->get();

        return response()->json($transactions);
    }

}
