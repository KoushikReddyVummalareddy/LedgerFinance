<?php

namespace Src\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Src\Contracts\Services\TransactionServiceInterface;
use Src\Http\Requests\PaginatedIndexRequest;
use Src\Http\Requests\TransactionRequest;
use Src\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService
    ) {
    }

    /**
     * Display transactions.
     */
    public function index(
        PaginatedIndexRequest $request
    ): AnonymousResourceCollection {

        $records = $this->transactionService->getTransactions(
            $request->getPage(),
            $request->getSize(),
            $request->type,
            $request->categoryId,
            $request->search,
            $request->fromDate,
            $request->toDate
        );

        return TransactionResource::collection($records);
    }

    /**
     * Store transaction.
     */
    public function store(
        TransactionRequest $request
    ): TransactionResource {

        $record = $this->transactionService
            ->createTransaction($request);

        return new TransactionResource($record);
    }

    /**
     * Update transaction.
     */
    public function update(
        TransactionRequest $request,
        int $id
    ): TransactionResource {

        $record = $this->transactionService
            ->updateTransaction($id, $request);

        return new TransactionResource($record);
    }

    /**
     * Delete transaction.
     */
    public function destroy(
        int $id
    ): TransactionResource {

        $record = $this->transactionService
            ->deleteTransaction($id);

        return new TransactionResource($record);
    }
}