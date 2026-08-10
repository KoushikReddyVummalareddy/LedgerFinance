<?php

namespace Src\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Contracts\Services\TransactionServiceInterface;
use Src\Http\Requests\TransactionRequest;
use Src\Models\Transaction;
use Src\Services\Concerns\HasPagination;

class TransactionService implements TransactionServiceInterface
{
    use HasPagination;

    public function createTransaction(
        TransactionRequest $request
    ): Transaction {
        $transaction = new Transaction();

        $transaction->user_id = auth()->id();
        $transaction->category_id = $request->category_id;
        $transaction->title = $request->title;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->notes = $request->notes;

        $transaction->save();

        return $transaction;
    }

    public function updateTransaction(
        int $id,
        TransactionRequest $request
    ): Transaction {
        $transaction = Transaction::findOrFail($id);

        $transaction->category_id = $request->category_id;
        $transaction->title = $request->title;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->notes = $request->notes;

        $transaction->save();

        return $transaction;
    }

    public function getTransactions(
        int $pageNumber = 1,
        int $pageSize = 10,
        ?string $type = null,
        ?int $categoryId = null,
        ?string $search = null,
        ?string $fromDate = null,
        ?string $toDate = null
    ): LengthAwarePaginator {

        $query = Transaction::query()->orderByDesc('transaction_date');

        if ($type) {
            $query->where('type', $type);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($fromDate) {
            $query->whereDate('transaction_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('transaction_date', '<=', $toDate);
        }

        return $this->getPaginatedResults(
            $query,
            $pageNumber,
            $pageSize
        );
    }

    public function getTransactionById(
        int $id
    ): Transaction {
        return Transaction::findOrFail($id);
    }

    public function deleteTransaction(
        int $id
    ): Transaction {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return $transaction;
    }
}