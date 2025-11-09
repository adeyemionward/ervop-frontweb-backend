<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class InvoicePaymentController extends Controller
{
    public function listPayment(Request $request)
    {
        // Start the query for payments belonging to the authenticated user
        $query = Transaction::where('user_id', Auth::id());

        // Optional: Allow filtering by project_id
        if ($request->has('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        // Optional: Allow filtering by appointment_id
        if ($request->has('appointment_id')) {
            $query->where('appointment_id', $request->input('appointment_id'));
        }

        // Eager-load relationships for efficiency to avoid N+1 problems
        $payments = $query->with([
            'invoice:id,invoice_no,total'
        ])
        ->orderBy('date', 'desc')
        ->get(); // Paginate the results

         if(count($payments) == 0){
            return response()->json([
                'status' => false,
                'message' => 'No payments found.',
            ], 200);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'Payments retrieved successfully.',
                'data' => TransactionResource::collection($payments),
            ], 200);
        }


    }

    public function recordPayment(Request $request, Invoice $invoice)
    {

        $validator = Validator::make($request->all(), [
            // The max validation ensures they don't overpay a single invoice
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $invoice->remaining_balance],
            'payment_date' => ['required', 'date_format:Y-m-d'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'status' => false, 'errors' => $validator->errors()], 422);
        }

        // Use validated data for security
        $validatedData = $validator->validated();

        $payInvoice = null;

        DB::transaction(function () use ($invoice, $validatedData, &$payInvoice) {
        // Create the payment record
        $payInvoice = $invoice->payments()->create([
            'user_id'        => Auth::id(),
            'contact_id'     => $invoice->contact_id,
            'appointment_id' => $invoice->appointment_id,
            'project_id'     => $invoice->project_id,
            'amount'         => $validatedData['amount'],
            'date'   => $validatedData['payment_date'],
            'payment_method' => $validatedData['payment_method'] ?? 'N/A',
            'title'          => $validatedData['title'],
        ]);

        // Update totals & status
        $this->updateInvoiceTotalsAndStatus($invoice);
        });

        return response()->json([
                'status' => true,
                'message' => 'Payments added successfully.',
                'data' => $payInvoice->fresh()->load(['invoice']),
            ], 200);

    }

    public function showPayment($payment)
    {
        $payment = Transaction::with([
            'invoice:id,invoice_no,total'
        ])->find($payment);

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => new TransactionResource($payment),
        ], 200);
    }


    public function updatePayment(Request $request, Transaction $payment)
    {

        $invoice = $payment->invoice;

        // The max allowed amount is the current remaining balance PLUS the original amount of the payment being edited.
        $maxAmount = $invoice->remaining_balance + $payment->amount;

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $maxAmount],
            'payment_date' => ['required', 'date_format:Y-m-d'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($payment, $invoice, $validated) {
            // Update the specific payment record
            $payment->update($validated);

            // After updating the payment, recalculate the parent invoice's totals
            $this->updateInvoiceTotalsAndStatus($invoice);
        });

        return new InvoiceResource($invoice->fresh()->load('items', 'payments'));
    }

    public function deletePayment(Transaction $payment): InvoiceResource
    {
        $invoice = $payment->invoice;

        DB::transaction(function () use ($payment, $invoice) {
            $payment->delete();
            $this->updateInvoiceTotalsAndStatus($invoice);
        });

        return new InvoiceResource($invoice->fresh()->load('items', 'payments'));
    }

    /**
     * Helper function to recalculate invoice totals and status after a payment change.
     */
    private function updateInvoiceTotalsAndStatus(Invoice $invoice)
    {
        $totalPaid = $invoice->payments()->sum('amount');
        $remainingBalance = $invoice->total - $totalPaid;



        $invoice->update([
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
        ]);
    }
}
