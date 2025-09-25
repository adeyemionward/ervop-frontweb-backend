<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
           return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'amount' => $this->amount,

            // Flattened project fields (checking if the relationship is loaded)
            'project_id' => $this->whenLoaded('project', fn() => $this->project->id),
            'project_title' => $this->whenLoaded('project', fn() => $this->project->title),

            // Flattened customer fields (checking if the relationship is loaded)
            'customer_id' => $this->whenLoaded('customer', fn() => $this->customer->id),
            'customer_firstname' => $this->whenLoaded('customer', fn() => $this->customer->firstname),
            'customer_lastname' => $this->whenLoaded('customer', fn() => $this->customer->lastname),
            'customer_email' => $this->whenLoaded('customer', fn() => $this->customer->email),
            'customer_phone' => $this->whenLoaded('customer', fn() => $this->customer->phone),

            // Add the count here
            'count' => $this->when(isset($this->count), $this->count),

            'created_at' => $this->created_at,
        ];


        // return [
        //     'id' => $this->id,
        //     'invoice_no' => $this->invoice_no,
        //     'issue_date' => $this->issue_date,
        //     'due_date' => $this->due_date,
        //     'subtotal' => $this->subtotal,
        //     'tax_percentage' => $this->tax_percentage,
        //     'tax_amount' => $this->tax_amount,
        //     'discount_amount' => $this->discount_amount,
        //     'total' => $this->total,
        //     'status' => $this->status,
        //     'notes' => $this->notes,
        //     'items' => InvoiceItemResource::collection($this->whenLoaded('items')),
        //'payment_history' => InvoicePaymentResource::collection($this->whenLoaded('payments')),
        //     // Add other loaded relationships like contact, project etc.
        // ];
    }
}
