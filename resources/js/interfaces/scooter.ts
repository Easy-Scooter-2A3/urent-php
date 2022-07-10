interface IScooter {
        id: number;
        status: string;
        model: string;
        created_at: string;
        updated_at: string;
        date_last_maintenance: string;
        date_next_maintenance: string;
        longitude: number;
        latitude: number;
        used_by: string;
        uuid: string;
}

export default IScooter;
