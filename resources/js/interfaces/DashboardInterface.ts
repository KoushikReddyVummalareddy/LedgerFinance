import type { TransactionInterface } from './TransactionInterface';

export interface DashboardInterface {
    totalIncome: number;
    totalExpense: number;
    currentBalance: number;
    recentTransactions: TransactionInterface[];
}