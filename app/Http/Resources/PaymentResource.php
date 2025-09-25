<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'payment_date' => $this->payment_date->format('Y-m-d'),
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'created_at' => $this->created_at->toDateTimeString(),

            // Related data will only be included if it was loaded in the controller
            'invoice' => $this->whenLoaded('invoice'),
        ];
    }
}
