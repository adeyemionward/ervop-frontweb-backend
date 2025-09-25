<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            // 'title' => $this->title,
            'amount' => $this->amount,
            'date' => $this->date,
            'category' => $this->category,
            // 'items' => TransactionItemResource::collection($this->whenLoaded('items')), // Load items relationship
            'contact_id' => $this->contact_id,
            'project_id' => $this->project_id,
            'appointment_id' => $this->appointment_id,
            'invoice_id' => $this->invoice_id,
            'created_at' => $this->created_at,
        ];
    }
}
