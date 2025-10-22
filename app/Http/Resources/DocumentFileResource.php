<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentFileResource extends JsonResource
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
            'contact_id' => $this->contact_id,
            'file_path' => $this->file_path,
            'file_type' => $this->file_type,
            'document_status'    => $this->status,

            // ✅ Pull title from related document
            'document_id' => $this->document_id,
            'document_title' => $this->whenLoaded('document', fn() => $this->document->title),
            'document_type' => $this->whenLoaded('document', fn() => $this->document->type),

            // Flattened project fields
            'project_id' => $this->whenLoaded('project', fn() => $this->project->id),
            'project_title' => $this->whenLoaded('project', fn() => $this->project->title),

            // Flattened customer fields
            'customer_id' => $this->whenLoaded('customer', fn() => $this->customer->id),
            'customer_firstname' => $this->whenLoaded('customer', fn() => $this->customer->firstname),
            'customer_lastname' => $this->whenLoaded('customer', fn() => $this->customer->lastname),
            'customer_email' => $this->whenLoaded('customer', fn() => $this->customer->email),
            'customer_phone' => $this->whenLoaded('customer', fn() => $this->customer->phone),

            'count' => $this->when(isset($this->count), $this->count),
            'created_at' => $this->created_at,
        ];
    }

}
