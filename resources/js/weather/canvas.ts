import Chart from 'chart.js/auto';
import IWeather from '../interfaces/weather';
import { doGet, range } from '../utils';

const Utils = require('./Utils');

enum Day {
  MONDAY = 1,
  SUNDAY = 2,
  TUESDAY = 3,
  WEDNESDAY = 4,
  THURSDAY = 5,
  FRIDAY = 6,
  SATURDAY = 7,
}

async function getWeatherData(day: Day) {
  const data = await doGet(`/weather/${day}`);
  if (!data) {
    return null;
  }

  return data.data as IWeather[];
}

function getDataset(finalData: (IWeather | null)[]) {
  const hours = [...range(0, 24)].map((hour) => `${String(hour).padStart(2, '0')}:00`);

  const DATA_COUNT = hours.length;
  const NUMBER_CFG = { count: DATA_COUNT, min: -20, max: 50 };

  const labels = hours;
  const skipped = (_ctx: any, value: any) => (_ctx.p0.skip || _ctx.p1.skip ? value : undefined);
  return {
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
}


function createCanvas(weatherMap: Map<number, IWeather | null>) {
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

  const finalData = [...weatherMap.entries()].sort((a, b) => a[0] - b[0]).map((x) => x[1]);
  const data = getDataset(finalData);

  // eslint-disable-next-line consistent-return
  return new Chart(ctx, {
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

function newCanvasData(weatherData: IWeather[]) {
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
  return weatherMap;
}

async function getData(day: Day.MONDAY) {
  const data = await getWeatherData(day);
  console.log(data);
  if (!data) {
    return [];
  }

  return data;
}

(async () => {
  const tmpElem = document.getElementById('tmp');
  if (tmpElem) {
    tmpElem.remove();
  }

  const data = await getData(Day.MONDAY);
  const chart = createCanvas(newCanvasData(data));
  if (!chart) {
    return;
  }

  const sizes = {
    selected: [
      'w-12',
      'h-12',
      'border-2',
      'border-zinc-800',
    ],
    unselected: [
      'w-10',
      'h-10',
      'border-0',
      'border-transparent',
    ],
  };
  const elems = document.querySelectorAll('[day-circle]');
  let n = 1;
  elems.forEach((button) => {
    const dayNumber = n;
    n += 1;
    button.addEventListener('click', () => {
      console.log(dayNumber);
      console.log('clicked');
      elems.forEach(async (elem) => {
        if (elem === button) {
          const dayData = await getData(dayNumber);
          const weatherMap = newCanvasData(dayData);
          const finalData = [...weatherMap.entries()].sort((a, b) => a[0] - b[0]).map((x) => x[1]);
          chart.data = getDataset(finalData);
          chart.update();

          elem.classList.add(...sizes.selected);
          elem.classList.remove(...sizes.unselected);
        } else {
          elem.classList.remove(...sizes.selected);
          elem.classList.add(...sizes.unselected);
        }
      });
    });
  });
})();
