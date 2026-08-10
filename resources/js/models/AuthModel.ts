import type {
    User,
    AuthResponse,
} from '../interfaces/AuthInterface';

export class UserModel implements User {
    constructor(
        public id: number,
        public name: string,
        public email: string,
        public createdAt: string,
    ) {}

    public static fromResponse(response: any): UserModel {
        return new UserModel(
            response.id,
            response.name,
            response.email,
            response.createdAt,
        );
    }

    public static fromResponseArray(
        responses: any[],
    ): UserModel[] {
        return responses.map((response) =>
            UserModel.fromResponse(response),
        );
    }
}

export class AuthResponseModel implements AuthResponse {
    constructor(
        public user: UserModel,
    ) {}

    public static fromResponse(
        response: any,
    ): AuthResponseModel {
        return new AuthResponseModel(
            UserModel.fromResponse(response.user),
        );
    }
}