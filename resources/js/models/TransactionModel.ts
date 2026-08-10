import type {
    CategoryInterface,
    TransactionInterface,
} from '../interfaces/TransactionInterface';

export class CategoryModel implements CategoryInterface {
    constructor(
        public id: number,
        public name: string,
        public type: 'income' | 'expense',
        public createdAt?: string,
        public updatedAt?: string,
    ) {}

    public static fromResponse(
        response: any,
    ): CategoryModel {
        return new CategoryModel(
            response.id,
            response.name,
            response.type,
            response.createdAt,
            response.updatedAt,
        );
    }

    public static fromResponseArray(
        responses: any[],
    ): CategoryModel[] {
        return responses.map((response) =>
            CategoryModel.fromResponse(response),
        );
    }
}

export class TransactionModel
    implements TransactionInterface
{
    constructor(
        public id: number,
        public userId: number,
        public categoryId: number,
        public category: CategoryModel | undefined,
        public title: string,
        public amount: number,
        public type: 'income' | 'expense',
        public transactionDate: string,
        public notes: string | null,
        public createdAt: string,
        public updatedAt: string,
    ) {}

    public static fromResponse(
        response: any,
    ): TransactionModel {
        return new TransactionModel(
            response.id,
            response.userId,
            response.categoryId,
            response.category
                ? CategoryModel.fromResponse(
                      response.category,
                  )
                : undefined,
            response.title,
            response.amount,
            response.type,
            response.transactionDate,
            response.notes,
            response.createdAt,
            response.updatedAt,
        );
    }

    public static fromResponseArray(
        responses: any[],
    ): TransactionModel[] {
        return responses.map((response) =>
            TransactionModel.fromResponse(response),
        );
    }
}