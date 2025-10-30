<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'contact_id' => $this->contact_id,
        'contact_name' => optional($this->contact)->firstname.' '.optional($this->contact)->lastname ?? null, // 👈 this adds the name
        'contact_email' => optional($this->contact)->email ?? null, // 👈 this adds the name
        'invoice_id' => $this->invoice_id,
        'appointment_id' => $this->appointment_id,
        'payment_method' => $this->payment_method,
        'project_id' => $this->project_id,
        'amount' => $this->amount,
        'date' => $this->date,
        'category' => $this->category,
        'type' => $this->type,
        'sub_type' => $this->sub_type,
        'title' => $this->title,
        'created_at' => $this->created_at,
        'items' => ItemResource::collection($this->whenLoaded('items')),
    ];
}
}
