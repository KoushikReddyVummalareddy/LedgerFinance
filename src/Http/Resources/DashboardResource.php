<?php

namespace Src\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
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
            'totalIncome' => $this['totalIncome'],

            'totalExpense' => $this['totalExpense'],

            'currentBalance' => $this['currentBalance'],

            'recentTransactions' => TransactionResource::collection(
                $this['recentTransactions']
            ),
        ];
    }
}