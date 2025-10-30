<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     try {
    //         $invoices = Invoice::with([
    //             'project:id,title',
    //             'customer:id,firstname,lastname,email,phone',
    //             'items' // assuming relation Invoice hasMany InvoiceItem
    //         ])
    //         ->where('user_id', $user->id)
    //         ->orderBy('id', 'DESC')
    //         ->get();

    //         if ($invoices->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No invoice found',
    //                 'status' => false
    //             ], 200);
    //         }

    //         $now = now();

    //         $invoices = $invoices->map(function ($invoice) use ($now) {
    //             // Calculate total from items
    //             $subtotal = $invoice->items->sum(function ($item) {
    //                 return $item->quantity * $item->rate;
    //             });

    //             // Apply discount
    //             if (!empty($invoice->discount_percentage)) {
    //                 $subtotal -= ($subtotal * ($invoice->discount_percentage / 100));
    //             }

    //             // Apply tax
    //             if (!empty($invoice->tax_percentage)) {
    //                 $subtotal += ($subtotal * ($invoice->tax_percentage / 100));
    //             }

    //             $totalAmount = round($subtotal, 2);
    //             $paidAmount = $subtotal - $invoice->remaining_balance ?? 0; // ensure you have this column
    //             $purpose = $invoice->project_id ? 'Project' : ($invoice->appointment_id ? 'Appointment' : 'General');

    //             // Determine status
    //             if ($paidAmount >= $totalAmount) {
    //                 $status = 'Paid';
    //             } elseif ($now->gt($invoice->due_date)) {
    //                 $status = 'Overdue';
    //             } elseif ($paidAmount == 0) {
    //                 $status = 'Unpaid';
    //             } elseif($paidAmount > 0 && $paidAmount < $totalAmount){
    //                 $status = 'Partially Paid';
    //             } else {
    //                 $status = 'Unknown';
    //             }

    //             return [
    //                 'id' => $invoice->id,
    //                 'invoice_no' => $invoice->invoice_no,
    //                 'issue_date' => $invoice->issue_date,
    //                 'due_date' => $invoice->due_date,
    //                 'total' => $totalAmount,
    //                 'paid_amount' => $paidAmount,
    //                 'remaining_balance' => $invoice->remaining_balance,
    //                 'status' => $status,
    //                 'purpose' => $purpose,
    //                 'customer' => $invoice->customer,
    //             ];
    //         });

    //         return response()->json([
    //             'status' => true,
    //             'data' => $invoices
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Error occurred',
    //             'status' => false,
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function index()
{
    $user = Auth::user();

    try {
        $invoices = Invoice::with([
            'project:id,title',
            'customer:id,firstname,lastname,email,phone',
            'items'
        ])
        ->where('user_id', $user->id)
        ->orderBy('id', 'DESC')
        ->get();

        if ($invoices->isEmpty()) {
            return response()->json([
                'message' => 'No invoice found',
                'status' => false
            ], 200);
        }

        $now = now();

        $invoices = $invoices->map(function ($invoice) use ($now) {
            // Calculate subtotal from items
            $subtotal = $invoice->items->sum(function ($item) {
                return $item->quantity * $item->rate;
            });

            // Apply discount
            if (!empty($invoice->discount_percentage)) {
                $subtotal -= ($subtotal * ($invoice->discount_percentage / 100));
            }

            // Apply tax
            if (!empty($invoice->tax_percentage)) {
                $subtotal += ($subtotal * ($invoice->tax_percentage / 100));
            }

            $totalAmount = round($subtotal, 2);
            $paidAmount = $totalAmount - ($invoice->remaining_balance ?? $totalAmount);
            $purpose = $invoice->project_id ? 'Project' : ($invoice->appointment_id ? 'Appointment' : 'General');

            // Determine status
            if ($paidAmount >= $totalAmount) {
                $status = 'Paid';
            } elseif ($now->gt($invoice->due_date)) {
                $status = 'Overdue';
            } elseif ($paidAmount == 0) {
                $status = 'Unpaid';
            } elseif ($paidAmount > 0 && $paidAmount < $totalAmount) {
                $status = 'Partially Paid';
            } else {
                $status = 'Unknown';
            }

            return [
                'id' => $invoice->id,
                'invoice_no' => $invoice->invoice_no,
                'issue_date' => $invoice->issue_date,
                'due_date' => $invoice->due_date,
                'total' => $totalAmount,
                'paid_amount' => $paidAmount,
                'remaining_balance' => $invoice->remaining_balance,
                'status' => $status,
                'purpose' => $purpose,
                'customer' => $invoice->customer,
            ];
        });

        // 📊 Calculate overviews
        $totalBilled = $invoices->sum('total');
        $totalPaid = $invoices->sum('paid_amount');
        $totalUnpaid = $invoices->where('status', 'Unpaid')->sum('total');
        $totalOverdue = $invoices->where('status', 'Overdue')->sum('total');
        $totalPartial = $invoices->where('status', 'Partially Paid')->sum('total');

        return response()->json([
            'status' => true,
            'overview' => [
                'total_billed' => $totalBilled,
                'total_paid' => $totalPaid,
                'total_unpaid' => $totalUnpaid,
                'total_overdue' => $totalOverdue,
                'total_partially_paid' => $totalPartial,
            ],
            'data' => $invoices
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error occurred',
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function create(Request $request)
    {
        // 1. IMPROVED VALIDATION
        // - appointment_id and project_id are now mutually exclusive requirements.
        // - Dates are validated as dates.
        $validator = Validator::make($request->all(), [
            'contact_id'            => ['required', 'integer', Rule::exists('contacts', 'id')],
            'appointment_id'        => ['nullable', 'required_without:project_id', 'integer', Rule::exists('appointments', 'id')],
            'project_id'            => ['nullable', 'required_without:appointment_id', 'integer', Rule::exists('projects', 'id')],
            'issue_date'            => ['required', 'date'],
            'due_date'              => ['required', 'date', 'after_or_equal:issue_date'],
            'invoice_no'            => ['required', 'string', Rule::unique('invoices')],
            'tax_percentage'        => ['nullable', 'numeric', 'min:0'], // Assumed to be a percentage
            'discount_percentage'   => ['nullable', 'numeric', 'min:0'], // Assumed to be a fixed amount
            'notes'                 => ['nullable', 'string'],
            'item'                  => ['required', 'array', 'min:1'],
            'item.*.description'    => ['required', 'string'],
            'item.*.quantity'       => ['required', 'numeric', 'min:1'],
            'item.*.rate'           => ['required', 'numeric', 'min:0'],

              // 🆕 Recurring fields
            'is_recurring'          => ['required', 'boolean'],
            'repeats'               => ['nullable', 'string', Rule::in(['weekly', 'monthly'])],
            'occuring_start_date'            => ['nullable', 'date', 'required_if:is_recurring,true'],
            'occuring_end_date'              => ['nullable', 'date', 'after_or_equal:start_date', 'required_if:is_recurring,true'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Use validated data for security
        $validatedData = $validator->validated();

        try {
            $invoice = DB::transaction(function () use ($validatedData) {
                // 2. CREATE THE INITIAL INVOICE
                // The amounts will be updated later.
                $invoice = Invoice::create([
                    'user_id'       => Auth::id(),
                    'contact_id'    => $validatedData['contact_id'],
                    'appointment_id'    => $validatedData['appointment_id'] ?? null,
                    'project_id'    => $validatedData['project_id'] ?? null,
                    'invoice_no'    => $validatedData['invoice_no'] ?? Invoice::generateInvoiceNumber(),
                    'invoice_type'  => isset($validatedData['appointment_id']) ? 'Appointment' : 'Project',
                    'issue_date'    => $validatedData['issue_date'],
                    'due_date'      => $validatedData['due_date'],
                    'tax_percentage'=> $validatedData['tax_percentage'] ?? 0,
                    'discount_percentage'      => $validatedData['discount_percentage'] ?? 0,
                    'notes'         => $validatedData['notes'] ?? null,

                     // 🆕 Recurring payload
                    'is_recurring'  => $validatedData['is_recurring'],
                    'repeats'       => $validatedData['repeats'] ?? null,
                    'occuring_start_date'    => $validatedData['occuring_start_date'] ?? null,
                    'occuring_end_date'      => $validatedData['occuring_end_date'] ?? null,
                ]);

                $subtotal = 0;

                // 3. CREATE INVOICE ITEMS AND CALCULATE SUBTOTAL
                foreach ($validatedData['item'] as $itemData) {
                    $itemAmount = $itemData['quantity'] * $itemData['rate'];
                    $subtotal += $itemAmount;

                    // Use the relationship to create items—it's cleaner.
                    $invoice->items()->create([
                        'user_id'       => Auth::id(),
                        'contact_id'    => $validatedData['contact_id'],
                        'invoice_id'    => $invoice->id,
                        'appointment_id'    => $validatedData['appointment_id'] ?? null,
                        'project_id'    => $validatedData['project_id'] ?? null,
                        'description' => $itemData['description'],
                        'quantity'    => $itemData['quantity'],
                        'rate'        => $itemData['rate'],
                        'total'       => $itemAmount,
                    ]);
                }

                // 4. CALCULATE FINAL AMOUNTS
                $taxAmount = ($subtotal * $invoice->tax_percentage) / 100;
                $discountAmount = ($subtotal * $invoice->discount_percentage) / 100;

                $total = ($subtotal + $taxAmount) - $discountAmount;

                // 5. UPDATE THE INVOICE WITH THE CALCULATED TOTALS
                $invoice->update([
                    'total'             => $total, // Renamed from 'total' to match your previous code
                    'subtotal'          => $subtotal,
                    'tax_amount'        => $taxAmount, // You'll need to add this column to your invoices table
                    'discount'    => $discountAmount,
                    'remaining_balance' => $total,
                ]);

                return $invoice;
            });

            // Load the items so they are included in the response
            $invoice->load('items');

            return response()->json([
                'message' => 'Invoice created successfully',
                'status'  => true,
                'data'    => $invoice,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the invoice.',
                'status'  => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'contact_id'         => ['required', 'integer', Rule::exists('contacts', 'id')],
            'appointment_id'     => ['nullable', 'required_without:project_id', 'integer', Rule::exists('appointments', 'id')],
            'project_id'         => ['nullable', 'required_without:appointment_id', 'integer', Rule::exists('projects', 'id')],
            'issue_date'         => ['required', 'date'],
            'due_date'           => ['required', 'date', 'after_or_equal:issue_date'],
            'invoice_no'         => ['required', 'string', Rule::unique('invoices')->ignore($invoice->id)],
            'tax_percentage'     => ['nullable', 'numeric', 'min:0'],
            'discount'           => ['nullable', 'numeric', 'min:0'],
            'notes'              => ['nullable', 'string'],
            'item'               => ['required', 'array', 'min:1'],
            'item.*.id'          => ['nullable', 'integer', Rule::exists('invoice_items', 'id')], // For existing items
            'item.*.description' => ['required', 'string'],
            'item.*.quantity'    => ['required', 'numeric', 'min:1'],
            'item.*.rate'        => ['required', 'numeric', 'min:0'],

               // 🆕 Recurring fields
            'is_recurring'          => ['required', 'boolean'],
            'repeats'               => ['nullable', 'string', Rule::in(['weekly', 'monthly'])],
            'occuring_start_date'            => ['nullable', 'date', 'required_if:is_recurring,true'],
            'occuring_end_date'              => ['nullable', 'date', 'after_or_equal:start_date', 'required_if:is_recurring,true'],


        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'status' => false, 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        try {
            DB::transaction(function () use ($validatedData, $invoice) {
                // 2. UPDATE THE MAIN INVOICE DETAILS
                $invoice->update([
                    'contact_id'     => $validatedData['contact_id'],
                    'appointment_id' => $validatedData['appointment_id'] ?? null,
                    'project_id'     => $validatedData['project_id'] ?? null,
                    'invoice_no'     => $validatedData['invoice_no'],
                    'invoice_type'   => isset($validatedData['appointment_id']) ? 'Appointment' : 'Project',
                    'issue_date'     => $validatedData['issue_date'],
                    'due_date'       => $validatedData['due_date'],
                    'tax_percentage' => $validatedData['tax_percentage'] ?? 0,
                    'discount'       => $validatedData['discount'] ?? 0,
                    'notes'          => $validatedData['notes'] ?? null,

                       // 🆕 Recurring payload
                    'is_recurring'  => $validatedData['is_recurring'],
                    'repeats'       => $validatedData['repeats'] ?? null,
                    'occuring_start_date'    => $validatedData['occuring_start_date'] ?? null,
                    'occuring_end_date'      => $validatedData['occuring_end_date'] ?? null,
                ]);

                $subtotal = 0;
                $incomingItemIds = [];

                // 3. UPDATE, CREATE, AND CALCULATE SUBTOTAL FOR ITEMS
                foreach ($validatedData['item'] as $itemData) {
                    $itemAmount = $itemData['quantity'] * $itemData['rate'];
                    $subtotal += $itemAmount;

                    // Use updateOrCreate to handle both existing and new items
                    $item = $invoice->items()->updateOrCreate(
                        [
                            'id' => $itemData['id'] ?? null, // Condition to find the item
                        ],
                        [ // Data to update or create with
                            'description' => $itemData['description'],
                            'quantity'    => $itemData['quantity'],
                            'rate'        => $itemData['rate'],
                            'total'       => $itemAmount,
                            // Fill in other necessary fields for creation
                            'user_id' => Auth::id(),
                            'contact_id' => $validatedData['contact_id'],
                            'appointment_id' => $validatedData['appointment_id'] ?? null,
                            'project_id' => $validatedData['project_id'] ?? null,
                        ]
                    );
                    $incomingItemIds[] = $item->id;
                }

                // 4. DELETE OLD ITEMS
                // Remove any items that were not included in the request
                $invoice->items()->whereNotIn('id', $incomingItemIds)->delete();

                // 5. RECALCULATE FINAL AMOUNTS
                $taxAmount = ($subtotal * $invoice->tax_percentage) / 100;
                $total = ($subtotal + $taxAmount) - $invoice->discount;

                // 6. UPDATE THE INVOICE WITH FINAL CALCULATED TOTALS
                $invoice->update([
                    'total'    => $total,
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    // You might need logic here to update the remaining_balance
                ]);
            });

            // Load the updated items for the response
            $invoice->load('items');

            return response()->json([
                'message' => 'Invoice updated successfully',
                'status'  => true,
                'data'    => $invoice,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the invoice.',
                'status'  => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $invoice = Invoice::with(['items', 'customer', 'project', 'user'])->find($id);

            if (!$invoice) {
                return response()->json([
                    'message' => 'No invoice found',
                    'status' => false
                ], 200);
            }

            // Calculate subtotal
            $subtotal = $invoice->items->sum(function ($item) {
                return $item->quantity * $item->rate;
            });

            // Discount, Tax, Amount Paid (assuming you store them in the table)
            $discount = $invoice->discount ?? 0;
            $tax      = $invoice->tax_amount ?? 0;
            $amountPaid = $invoice->payments->sum('amount');

            $discount_percentage = $invoice->discount_percentage ?? 0;
            $tax_percentage      = $invoice->tax_percentage ?? 0;

            $total = ($subtotal + $tax) - $discount;
            $remainingBalance = $total - $amountPaid;

            // Determine status
            if ($remainingBalance <= 0) {
                $status = 'Paid';
            } elseif ($amountPaid > 0 && $remainingBalance > 0) {
                $status = 'Partially Paid';
            } else {
                // Compare with due_date if exists
                if ($invoice->due_date && now()->gt($invoice->due_date)) {
                    $status = 'Overdue';
                } else {
                    $status = 'Unpaid';
                }
            }

            // Structure response
            $data = [
                'id'             => $invoice->id,
                'invoice_no'     => $invoice->invoice_no,
                'issue_date'     => $invoice->issue_date,
                'due_date'       => $invoice->due_date,
                'project_id'       => $invoice->project_id,
                'appointment_id'       => $invoice->appointment_id,
                'created_at'     => $invoice->created_at,
                'status'         => $status,

                'customer' => [
                    'id'        => $invoice->customer->id ?? null,
                    'firstname' => $invoice->customer->firstname ?? null,
                    'lastname'  => $invoice->customer->lastname ?? null,
                    'email'     => $invoice->customer->email ?? null,
                    'phone'     => $invoice->customer->phone ?? null,
                ],

                'professional' => [
                    'id'    => $invoice->user->id ?? null,
                    'name'  => $invoice->user->firstname.' '.$invoice->user->lastname ?? null,
                    'email' => $invoice->user->email ?? null,
                    'phone' => $invoice->user->phone ?? null,
                    'business_name' => $invoice->user->business_name ?? null,
                    'address' => $invoice->user->address ?? null,
                ],

                'items' => $invoice->items->map(function ($item) {
                    return [
                        'id'          => $item->id,
                        'description' => $item->description,
                        'quantity'    => $item->quantity,
                        'rate'        => $item->rate,
                        'total'       => $item->quantity * $item->rate,
                    ];
                }),

                'reoccuring' => [
                    'is_recurring'    => $invoice->is_recurring ?? null,
                    'repeats'  => $invoice->repeats ?? null,
                    'occuring_start_date' => $invoice->occuring_start_date ?? null,
                    'occuring_end_date' => $invoice->occuring_end_date ?? null,
                ],

                'summary' => [
                    'subtotal'              => $subtotal,
                    'tax'                   => $tax,
                    'discount'              => $discount,
                    'tax_percentage'        => $tax_percentage,
                    'discount_percentage'   => $discount_percentage,
                    'total'                 => $total,
                    'total_paid'            => $amountPaid,
                    'remaining_balance'     => $remainingBalance,
                ],

                'payments' => $invoice->payments->map(function ($payment) {
                    return [
                        'id'                => $payment->id,
                        'paid_amount'       => $payment->amount,
                        'payment_date'      => $payment->payment_date,
                        'payment_method'    => $payment->payment_method,
                    ];
                }),

                'notes' => $invoice->notes ?? null,
            ];

            return response()->json([
                'status' => true,
                'data'   => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'status'  => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

     public function clientInvoices($contactId)
    {
        $user = Auth::user();
        // Fetch all services for the authenticated user
                    try {
                        $invoices = Invoice::with([ 'project'])
            ->where('user_id', $user->id)
            ->where('contact_id', $contactId)
            ->orderBy('id', 'DESC')
            ->get();



            if ($invoices->isEmpty()) {
                return response()->json(['message' => 'No invoices found', 'status' => false], 200);
            }
            $invoices = InvoiceResource::collection($invoices);
            return response()->json([
                'status' => true,
                'data' => $invoices,
            ], 200);

        } catch (\Exception $e) {
           return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function projectInvoices($projectId)
    {
        $user = Auth::user();

        try {
            // Fetch invoices for this project
            $invoices = Invoice::with(['project'])
                ->where('user_id', $user->id)
                ->where('project_id', $projectId)
                ->orderBy('id', 'DESC')
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'message' => 'No invoices found',
                    'status' => false
                ], 200);
            }

            // Calculate and filter by outstanding balance
            $invoicesWithOutstanding = $invoices->filter(function ($invoice) {
                $totalPaid = \App\Models\InvoicePayment::where('invoice_id', $invoice->id)->sum('amount');
                $outstanding = max($invoice->subtotal - $totalPaid, 0);
                $invoice->outstanding_balance = $outstanding;

                // Keep only invoices that still have outstanding amount
                return $outstanding > 0;
            })->values(); // reset array indexes

            if ($invoicesWithOutstanding->isEmpty()) {
                return response()->json([
                    'message' => 'No outstanding invoices found',
                    'status' => false
                ], 200);
            }

            return response()->json([
                'status' => true,
                'data' => \App\Http\Resources\InvoiceResource::collection($invoicesWithOutstanding),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function appointmentInvoices($appointmentId)
    {
        $user = Auth::user();

        try {
            // Fetch invoices for this appointment
            $invoices = Invoice::with(['appointment'])
                ->where('user_id', $user->id)
                ->where('appointment_id', $appointmentId)
                ->orderBy('id', 'DESC')
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'message' => 'No invoices found',
                    'status' => false
                ], 200);
            }

            // Calculate and filter only invoices with outstanding balances
            $invoicesWithOutstanding = $invoices->filter(function ($invoice) {
                $totalPaid = \App\Models\InvoicePayment::where('invoice_id', $invoice->id)->sum('amount');
                $outstanding = max($invoice->subtotal - $totalPaid, 0);
                $invoice->outstanding_balance = $outstanding;

                // Keep only invoices that have a positive outstanding amount
                return $outstanding > 0;
            })->values();

            if ($invoicesWithOutstanding->isEmpty()) {
                return response()->json([
                    'message' => 'No outstanding invoices found',
                    'status' => false
                ], 200);
            }

            return response()->json([
                'status' => true,
                'data' => \App\Http\Resources\InvoiceResource::collection($invoicesWithOutstanding),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

      public function delete($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found.',
            ], 200);
        }
        $delete =  $invoice->delete();
        if($delete){
            return response()->json([
            'status' => true,
            'message'   => 'Invoice deleted',
        ], 200);
        }

    }

}
