import { Loader, LoaderOptions } from 'google-maps';
import IScooter from './interfaces/scooter';
import { doGet } from './utils';

const start = async () => {
  const mapDiv = document.getElementById('map') as HTMLElement;
  if (!mapDiv) {
    console.log('mapDiv not found');
    return;
  }

  const apiKey = 'AIzaSyATtyjZ7k1VD5NLIaJ-pKjcJ-QFoic_nh4'; // TODO: get from env & protect key from public
  const options: LoaderOptions = {};
  const loader = new Loader(apiKey, options);

  const res = doGet('/dashboard/admin/scooters/list');

  const google = await loader.load();
  const map = new google.maps.Map(mapDiv, {
    center: { lat: 45.75952687752151, lng: 4.836465260338083 },
    zoom: 8,
  });

  res.then((scooters) => {
    if (!scooters) {
      console.log('scooters not found');
      return;
    }

    console.log(scooters.data);
    const { data } = scooters.data;

    data.forEach((scooter: IScooter) => {
      const marker = new google.maps.Marker({
        position: { lat: scooter.latitude, lng: scooter.longitude },
        map,
      });

      const infoWindow = new google.maps.InfoWindow({
        content: scooter.uuid, // dialog content with scooter details
      });

      marker.addListener('click', () => {
        infoWindow.open(map, marker);
      });
    });
  });

  map.addListener('click', (e) => {
    const coords = e.latLng;
    console.log(coords.lat(), coords.lng());
  });
};

(async () => {
  start();
})();
