<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
     public function create(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'contact_id' => ['required', 'integer', Rule::exists('contacts', 'id')],
            'project_id' => ['required', 'integer', Rule::exists('projects', 'id')],
            'issue_date' => ['nullable', 'string'],
            'due_date' => ['nullable', 'string'],
            'invoice_no' => ['required', 'string'],
            'tax' => ['nullable', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string'],

            'item.*.description' => 'required|string',
            'item.*.quantity' => 'required|numeric',
            'item.*.rate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status'=>false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $invoice = DB::transaction(function () use ($request) {
                $invoice = new Invoice([
                    'user_id'       => Auth::user()->id,
                    'contact_id'    => $request->input('contact_id'),
                    'project_id'    => $request->input('project_id'),
                    'invoice_no'    => $request->input('invoice_no'),
                    'invoice_type'  => 'Project',
                    'issue_date'    => $request->input('issue_date'),
                    'due_date'      => $request->input('due_date'),
                    'tax'           => $request->input('tax'),
                    'discount'      => $request->input('discount'),
                    'notes'         => $request->input('notes'),
                ]);
                $invoice->save();


                foreach ($request->item as $itemData) {
                   $item =  InvoiceItem::updateOrCreate(
                        // 1. Attributes to find the record by:
                        [
                            'user_id' => Auth::user()->id,
                            'contact_id' => $request->input('contact_id'),
                            'invoice_id' => $invoice->id,
                        ],
                        // 2. Values to update or create with:
                        [
                            'quantity' => $itemData['quantity'],
                            'rate' => $itemData['rate'],
                            'description'   => $itemData['description'],
                        ]
                    );
                }
                // Then, insert the new ones
                if ($request->has('items') && is_array($request->items)) {
                    $itemsToInsert = [];
                    foreach ($request->items as $item) {
                        // Skip any empty task fields from the form
                        if (!empty($item)) {
                            $itemsToInsert[] = [
                                'user_id'    => Auth::user()->id,
                                'contact_id' => $request->input('contact_id'),
                                'invoice_id' => $invoice->id,
                                'description'       => $item,
                                'created_at' => now(), // Add timestamps for insert
                                'updated_at' => now(),
                            ];
                        }
                    }

                    if (!empty($itemsToInsert)) {
                        InvoiceItem::insert($itemsToInsert);
                    }
                }
                return $invoice;
            });

            // You can customize the success response as needed
            return response()->json([
                'message' => 'Invoice created successfully',
                'status' => true,
                'data' => $project,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occured', 'status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
