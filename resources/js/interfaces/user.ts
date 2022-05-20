interface IUser {
        id: number,
        name: string,
        email: string,
        email_verified_at: string,
        two_factor_confirmed_at: string,
        created_at: string,
        updated_at: string,
        location: string,
        phone: string,
        partner_code: string,
        fidelity_points: number,
        credit_points: number,
        isAdmin: number,
        isActive: number,
}

export default IUser;
