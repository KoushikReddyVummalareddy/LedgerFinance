<?php

namespace Src\Services;

use Src\Contracts\Services\DashboardServiceInterface;
use Src\Models\Transaction;

class DashboardService implements DashboardServiceInterface
{
    /**
     * Get dashboard summary.
     *
     * @param int $userId
     * @return array
     */
    public function getDashboardSummary(
        int $userId
    ): array {

        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $expense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $recentTransactions = Transaction::where('user_id', $userId)
            ->latest('transaction_date')
            ->take(5)
            ->get();

        return [
            'totalIncome' => $income,
            'totalExpense' => $expense,
            'currentBalance' => $income - $expense,
            'recentTransactions' => $recentTransactions,
        ];
    }
}