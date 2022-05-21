import Chart from 'chart.js/auto';
import IWeather from '../interfaces/weather';
import { doGet, range } from '../utils';

const Utils = require('./Utils');

async function getWeatherData() {
  const data = await doGet('/weather');
  if (!data) {
    return null;
  }

  return data.data as IWeather[];
}

function drawCanvas(weatherData: IWeather[]) {
  const canvas = document.getElementById('weather-canvas') as HTMLCanvasElement;
  if (!canvas) {
    alert('no canvas');
    return;
  }

  const ctx = canvas.getContext('2d');
  if (!ctx) {
    alert('no context');
    return;
  }

  ctx.fillStyle = '#FFF';
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.stroke();

  // eslint-disable-next-line max-len
  const skipped = (_ctx: any, value: any) => (_ctx.p0.skip || _ctx.p1.skip ? value : undefined);

  const hours = [...range(0, 24)].map((hour) => `${String(hour).padStart(2, '0')}:00`);

  const DATA_COUNT = hours.length;
  const NUMBER_CFG = { count: DATA_COUNT, min: -20, max: 50 };

  const weatherMap = new Map<number, IWeather | null>();

  weatherData.forEach((x) => {
    const h = new Date(x.main.created_at).getHours();
    if (!weatherMap.has(h)) {
      weatherMap.set(h, x);
    }
  });

  [...range(0, 23)].forEach((hour) => {
    if (!weatherMap.has(hour)) {
      weatherMap.set(hour, null);
    }
  });

  const finalData = [...weatherMap.entries()].sort((a, b) => a[0] - b[0]).map((x) => x[1]);

  const labels = hours;
  const data = {
    labels,
    datasets: [
      {
        label: 'Temperature (°C)',
        data: finalData.map((x) => (x?.main.temp) ?? NaN),
        borderColor: Utils.CHART_COLORS.red,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Humidity (%)',
        data: finalData.map((x) => (x?.main.humidity) ?? NaN),
        borderColor: Utils.CHART_COLORS.blue,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Pressure (kPa)',
        data: finalData.map((x) => {
          if (x?.main.pressure) {
            return x.main.pressure / 10;
          }
          return NaN;
        }),
        borderColor: Utils.CHART_COLORS.orange,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Visibility (km X 10)',
        data: finalData.map((x) => {
          if (x?.visibility) {
            return x.visibility / 100;
          }
          return NaN;
        }),
        borderColor: Utils.CHART_COLORS.green,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Clouds',
        data: finalData.map((x) => (x?.clouds_all) ?? NaN),
        borderColor: Utils.CHART_COLORS.grey,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Wind speed (meter/sec)',
        data: finalData.map((x) => {
          if (x?.wind.speed) {
            return x.wind.speed;
          }
          return NaN;
        }),
        borderColor: Utils.CHART_COLORS.yellow,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
      {
        label: 'Wind gust (meter/sec)',
        data: finalData.map((x) => (x?.wind.gust) ?? NaN),
        borderColor: Utils.CHART_COLORS.red,
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        cubicInterpolationMode: 'monotone' as 'monotone',
        yAxisID: 'y',
        spanGaps: true,
        segment: {
          borderColor: (_ctx: any) => skipped(_ctx, 'rgb(0,0,0,0.2)'),
          borderDash: (_ctx: any) => skipped(_ctx, [6, 6]),
        },
      },
    ],
  };

  const chart = new Chart(ctx, {
    type: 'line',
    data,
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false,
      },
      plugins: {
        title: {
          display: true,
          text: 'URent weather of the week',
        },
      },
      scales: {
        y: {
          type: 'linear',
          display: true,
          position: 'left',
        },
      },
    },
  });
}

(async () => {
  const data = await getWeatherData();
  console.log(data);
  if (!data) {
    return;
  }
  drawCanvas(data);
})();
