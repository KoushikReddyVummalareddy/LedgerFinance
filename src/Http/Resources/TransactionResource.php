<?php

namespace Src\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'userId' => $this->user_id,

            'categoryId' => $this->category_id,

            'category' => $this->whenLoaded('category'),

            'title' => $this->title,

            'amount' => $this->amount,

            'type' => $this->type,

            'transactionDate' => $this->transaction_date,

            'notes' => $this->notes,

            'createdAt' => $this->created_at,

            'updatedAt' => $this->updated_at,
        ];
    }
}