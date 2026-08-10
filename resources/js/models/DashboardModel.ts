import type { DashboardInterface } from '../interfaces/DashboardInterface';

export class DashboardModel implements DashboardInterface {
    constructor(
        public totalIncome: number,
        public totalExpense: number,
        public currentBalance: number,
        public recentTransactions: any[],
    ) {}

    public static fromResponse(
        response: any,
    ): DashboardModel {
        return new DashboardModel(
            response.totalIncome,
            response.totalExpense,
            response.currentBalance,
            response.recentTransactions,
        );
    }
}