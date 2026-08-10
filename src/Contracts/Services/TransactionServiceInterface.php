<?php

namespace Src\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Http\Requests\TransactionRequest;
use Src\Models\Transaction;

interface TransactionServiceInterface
{
    /**
     * Get transactions.
     *
     * @param int $pageNumber
     * @param int $pageSize
     * @param string|null $type
     * @param int|null $categoryId
     * @param string|null $search
     * @param string|null $fromDate
     * @param string|null $toDate
     * @return LengthAwarePaginator
     */
    public function getTransactions(
        int $pageNumber = 1,
        int $pageSize = 10,
        ?string $type = null,
        ?int $categoryId = null,
        ?string $search = null,
        ?string $fromDate = null,
        ?string $toDate = null
    ): LengthAwarePaginator;

    /**
     * Get transaction by id.
     *
     * @param int $id
     * @return Transaction
     */
    public function getTransactionById(
        int $id
    ): Transaction;

    /**
     * Create transaction.
     *
     * @param TransactionRequest $request
     * @return Transaction
     */
    public function createTransaction(
        TransactionRequest $request
    ): Transaction;

    /**
     * Update transaction.
     *
     * @param int $id
     * @param TransactionRequest $request
     * @return Transaction
     */
    public function updateTransaction(
        int $id,
        TransactionRequest $request
    ): Transaction;

    /**
     * Delete transaction.
     *
     * @param int $id
     * @return Transaction
     */
    public function deleteTransaction(
        int $id
    ): Transaction;
}