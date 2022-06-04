interface IOrder {
    id: number;
    status: string;
    delivery_place: string;
    delivery_date: string;
    transporter: string;
    transporter_tracking_number: string;
    created_at: string;
    updated_at: string;
    total_price: number;
    payment_method: string;
    fidelityPoints: string;
    recu: string;
}

export default IOrder;
