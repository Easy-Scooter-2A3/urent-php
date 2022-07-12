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

  const searchField = document.getElementById('searchField') as HTMLInputElement;
  if (!searchField) {
    console.log('searchField not found');
    return;
  }

  const scootersAmount = document.getElementById('scootersAmount') as HTMLSpanElement;
  if (!scootersAmount) {
    console.log('scootersAmount not found');
    return;
  }

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

    const { data }: {data: IScooter[]} = scooters.data;
    scootersAmount.textContent = data.length.toString();

    const markers = Array.from(data).map((scooter) => {
      const marker = new google.maps.Marker({
        position: { lat: scooter.latitude, lng: scooter.longitude },
        map,
      });
      marker.set('uuid', scooter.uuid);

      const content = `<div>
        <h2>Status: ${scooter.status}</h2>
        <h2>Model: ${scooter.model}</h2>
        <h2>Created at: ${scooter.created_at}</h2>
        <h2>Updated at: ${scooter.updated_at}</h2>
        <h2>Last maintenance: ${scooter.date_last_maintenance}</h2>
        <h2>Next maintenance: ${scooter.date_next_maintenance}</h2>
        <h2>Longitude: ${scooter.longitude}</h2>
        <h2>Latitude: ${scooter.latitude}</h2>
        <h2>UUID: ${scooter.uuid}</h2>
      </div>`;
      const infoWindow = new google.maps.InfoWindow({
        content,
      });

      marker.addListener('click', () => {
        infoWindow.open(map, marker);
      });
      return marker;
    });

    searchField.onkeyup = async (event: Event) => {
      const search = searchField.value;
      let n = 0;
      markers.forEach((marker) => {
        const uuid = marker.get('uuid');
        const visible = uuid.includes(search);
        marker.setVisible(visible);
        if (visible) {
          n += 1;
        }
      });
      scootersAmount.textContent = n.toString();
    };
  });

  map.addListener('click', (e) => {
    const coords = e.latLng;
    console.log(coords.lat(), coords.lng());
  });
};

(async () => {
  start();
})();
