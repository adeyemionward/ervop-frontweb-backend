<?php

namespace App\Http\Controllers\API\Professionals\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationResource;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuotationController extends Controller
{
    /**
     * 🧾 List all quotations for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        try {
            $quotations = Quotation::with([
                'project:id,title',
                'customer:id,firstname,lastname,email,phone',
                'items'
            ])
                ->where('user_id', $user->id)
                ->orderBy('id', 'DESC')
                ->get();

            if ($quotations->isEmpty()) {
                return response()->json([
                    'message' => 'No quotations found',
                    'status' => false
                ], 200);
            }

            $now = now();

            $quotations = $quotations->map(function ($quotation) use ($now) {
                $subtotal = $quotation->items->sum(fn($item) => $item->quantity * $item->rate);

                // Apply discount and tax
                if (!empty($quotation->discount_percentage)) {
                    $subtotal -= ($subtotal * ($quotation->discount_percentage / 100));
                }
                if (!empty($quotation->tax_percentage)) {
                    $subtotal += ($subtotal * ($quotation->tax_percentage / 100));
                }

                $totalAmount = round($subtotal, 2);
                $purpose = $quotation->project_id ? 'Project' : ($quotation->appointment_id ? 'Appointment' : 'General');

                return [
                    'id' => $quotation->id,
                    'quotation_no' => $quotation->quotation_no,
                    'issue_date' => $quotation->issue_date,
                    'valid_until' => $quotation->valid_until,
                    'total' => $totalAmount,
                    'status' => $quotation->status ?? 'Draft',
                    'purpose' => $purpose,
                    'customer' => $quotation->customer,
                ];
            });

            // // Overview stats
            $totalQuoted = $quotations->count();
            $accepted = $quotations->where('status', 'Accepted')->count();
            $rejected = $quotations->where('status', 'Rejected')->count();
            $pending = $quotations->where('status', 'Pending')->count();



            return response()->json([
                'status' => true,
                'overview' => [
                    'total_quoted' => $totalQuoted,
                    'accepted' => $accepted,
                    'rejected' => $rejected,
                    'pending' => $pending,
                ],
                'data' => $quotations
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🧾 Create a new quotation.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => ['required', 'integer', Rule::exists('contacts', 'id')],
            'appointment_id' => ['nullable', 'integer', Rule::exists('appointments', 'id')],
            'project_id' => ['nullable', 'integer', Rule::exists('projects', 'id')],
            'quotation_no' => ['nullable', 'string', Rule::unique('quotations')],
            'issue_date' => ['required', 'date'],
            'valid_until' => ['required', 'date', 'after_or_equal:issue_date'],
            'tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'item' => ['required', 'array', 'min:1'],
            'item.*.description' => ['required', 'string'],
            'item.*.quantity' => ['required', 'numeric', 'min:1'],
            'item.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $quotation = DB::transaction(function () use ($validated) {
                $quotation = Quotation::create([
                    'user_id' => Auth::id(),
                    'contact_id' => $validated['contact_id'],
                    'appointment_id' => $validated['appointment_id'] ?? null,
                    'project_id' => $validated['project_id'] ?? null,
                    'quotation_no' => $validated['quotation_no'] ??  Quotation::generateQuotationNumber(),
                    'quotation_type'  => isset($validatedData['appointment_id']) ? 'Appointment' : 'Project',
                    'issue_date' => $validated['issue_date'],
                    'valid_until' => $validated['valid_until'],
                    'tax_percentage' => $validated['tax_percentage'] ?? 0,
                    'discount_percentage' => $validated['discount_percentage'] ?? 0,
                    'notes' => $validated['notes'] ?? null,
                    'status' => 'Pending',
                ]);

                $subtotal = 0;
                foreach ($validated['item'] as $itemData) {
                    $amount = $itemData['quantity'] * $itemData['rate'];
                    $subtotal += $amount;

                    $quotation->items()->create([
                        'user_id' => Auth::id(),
                        'contact_id' => $validated['contact_id'],
                        'quotation_id' => $quotation->id,
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'rate' => $itemData['rate'],
                        'total' => $amount,
                    ]);
                }

                $taxAmount = ($subtotal * $quotation->tax_percentage) / 100;
                $discountAmount = ($subtotal * $quotation->discount_percentage) / 100;
                $total = ($subtotal + $taxAmount) - $discountAmount;

                $quotation->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'discount' => $discountAmount,
                    'total' => $total,
                ]);

                return $quotation;
            });

            $quotation->load('items');

            return response()->json([
                'message' => 'Quotation created successfully',
                'status' => true,
                'data' => $quotation,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating quotation',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 🧾 Show a specific quotation.
     */
    public function show($id)
    {
        try {
            $quotation = Quotation::with(['items', 'customer', 'project', 'user'])->find($id);

            if (!$quotation) {
                return response()->json([
                    'message' => 'No quotation found',
                    'status' => false
                ], 200);
            }

            $subtotal = $quotation->items->sum(fn($i) => $i->quantity * $i->rate);
            $discount = $quotation->discount ?? 0;
            $tax = $quotation->tax_amount ?? 0;
            $total = ($subtotal + $tax) - $discount;

            $data = [
                'id' => $quotation->id,
                'quotation_no' => $quotation->quotation_no,
                'issue_date' => $quotation->issue_date,
                'valid_until' => $quotation->valid_until,
                'project_id'       => $quotation->project_id,
                'appointment_id'       => $quotation->appointment_id,
                'status' => $quotation->status,
                'customer' => $quotation->customer,
                'items' => $quotation->items,
                'summary' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'total' => $total,
                ],
                'notes' => $quotation->notes,
            ];

            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'contact_id' => ['required', 'integer', Rule::exists('contacts', 'id')],
        'appointment_id' => ['nullable', 'integer', Rule::exists('appointments', 'id')],
        'project_id' => ['nullable', 'integer', Rule::exists('projects', 'id')],
        'quotation_no' => ['nullable', 'string', Rule::unique('quotations', 'quotation_no')->ignore($id)],
        'issue_date' => ['required', 'date'],
        'valid_until' => ['required', 'date', 'after_or_equal:issue_date'],
        'tax_percentage' => ['nullable', 'numeric', 'min:0'],
        'discount_percentage' => ['nullable', 'numeric', 'min:0'],
        'notes' => ['nullable', 'string'],
        'item' => ['required', 'array', 'min:1'],
        'item.*.description' => ['required', 'string'],
        'item.*.quantity' => ['required', 'numeric', 'min:1'],
        'item.*.rate' => ['required', 'numeric', 'min:0'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $validated = $validator->validated();

    try {
        $quotation = DB::transaction(function () use ($validated, $id) {
            $quotation = Quotation::where('user_id', Auth::id())->findOrFail($id);

            $quotation->update([
                'contact_id' => $validated['contact_id'],
                'appointment_id' => $validated['appointment_id'] ?? null,
                'project_id' => $validated['project_id'] ?? null,
                'quotation_no' => $validated['quotation_no'] ?? $quotation->quotation_no,
                'quotation_type'  => isset($validated['appointment_id']) ? 'Appointment' : 'Project',
                'issue_date' => $validated['issue_date'],
                'valid_until' => $validated['valid_until'],
                'tax_percentage' => $validated['tax_percentage'] ?? 0,
                'discount_percentage' => $validated['discount_percentage'] ?? 0,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing items before recreating
            $quotation->items()->delete();

            // Recalculate items
            $subtotal = 0;
            foreach ($validated['item'] as $itemData) {
                $amount = $itemData['quantity'] * $itemData['rate'];
                $subtotal += $amount;

                $quotation->items()->create([
                    'user_id' => Auth::id(),
                    'contact_id' => $validated['contact_id'],
                    'quotation_id' => $quotation->id,
                    'description' => $itemData['description'],
                    'quantity' => $itemData['quantity'],
                    'rate' => $itemData['rate'],
                    'total' => $amount,
                ]);
            }

            // Recalculate totals
            $taxAmount = ($subtotal * $quotation->tax_percentage) / 100;
            $discountAmount = ($subtotal * $quotation->discount_percentage) / 100;
            $total = ($subtotal + $taxAmount) - $discountAmount;

            $quotation->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount' => $discountAmount,
                'total' => $total,
            ]);

            return $quotation;
        });

        $quotation->load('items', 'customer');

        return response()->json([
            'message' => 'Quotation updated successfully',
            'status' => true,
            'data' => $quotation,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error updating quotation',
            'status' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * 🧾 Delete quotation.
     */
    public function delete($id)
    {
        $quotation = Quotation::find($id);

        if (!$quotation) {
            return response()->json([
                'status' => false,
                'message' => 'Quotation not found.',
            ], 200);
        }

        $quotation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quotation deleted successfully.',
        ], 200);
    }

    /**
     * 🔄 Convert quotation to invoice.
     */
    public function convertToInvoice($id)
    {
        try {
            $quotation = Quotation::with('items')->findOrFail($id);

            $invoice = \App\Models\Invoice::create([
                'user_id' => $quotation->user_id,
                'contact_id' => $quotation->contact_id,
                'project_id' => $quotation->project_id,
                'appointment_id' => $quotation->appointment_id,
                'invoice_no' => Quotation::generateQuotationNumber(),
                'issue_date' => now(),
                'due_date' => now()->addDays(14),
                'tax_percentage' => $quotation->tax_percentage,
                'discount_percentage' => $quotation->discount_percentage,
                'notes' => $quotation->notes,
            ]);

            foreach ($quotation->items as $item) {
                $invoice->items()->create([
                    'user_id' => $quotation->user_id,
                    'contact_id' => $quotation->contact_id,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'rate' => $item->rate,
                    'total' => $item->total,
                ]);
            }

            $quotation->update(['status' => 'Converted']);

            return response()->json([
                'status' => true,
                'message' => 'Quotation converted to invoice successfully.',
                'invoice_id' => $invoice->id,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error converting quotation',
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
