interface IWeather {
    visibility: number;
    clouds_all: number;
    main: {
        id: number,
        created_at: string,
        temp: number,
        temp_min: number,
        temp_max: number,
        pressure: number,
        humidity: number,
        feels_like: number;
    },
    wind: {
        speed: number;
        deg: number;
        gust: number;
    }
}

export default IWeather;
