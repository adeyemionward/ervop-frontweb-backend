<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'progress_status' => $this->progress_status,
            'cost' => $this->cost,
            'description' => $this->description,

            // Flattened service fields (checking if the relationship is loaded)
            'service_id' => $this->whenLoaded('service', fn() => $this->service->id),
            'service_name' => $this->whenLoaded('service', fn() => $this->service->name),

            // Flattened customer fields (checking if the relationship is loaded)
            'customer_id' => $this->whenLoaded('customer', fn() => $this->customer->id),
            'customer_firstname' => $this->whenLoaded('customer', fn() => $this->customer->firstname),
            'customer_lastname' => $this->whenLoaded('customer', fn() => $this->customer->lastname),
            'customer_email' => $this->whenLoaded('customer', fn() => $this->customer->email),
            'customer_phone' => $this->whenLoaded('customer', fn() => $this->customer->phone),

            'created_at' => $this->created_at,
        ];
    }
}
