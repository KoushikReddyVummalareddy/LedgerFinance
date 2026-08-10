export interface CategoryInterface {
    id: number;
    name: string;
    type: 'income' | 'expense';
    createdAt?: string;
    updatedAt?: string;
}

export interface TransactionInterface {
    id: number;
    userId: number;
    categoryId: number;
    category?: CategoryInterface;
    title: string;
    amount: number;
    type: 'income' | 'expense';
    transactionDate: string;
    notes: string | null;
    createdAt: string;
    updatedAt: string;
}