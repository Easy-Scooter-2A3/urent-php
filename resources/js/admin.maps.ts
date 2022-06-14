import { Loader, LoaderOptions } from 'google-maps';

const start = async () => {
  const mapDiv = document.getElementById('map') as HTMLElement;
  if (!mapDiv) {
    console.log('mapDiv not found');
    return;
  }

  const apiKey = 'AIzaSyATtyjZ7k1VD5NLIaJ-pKjcJ-QFoic_nh4';
  const options: LoaderOptions = {};
  const loader = new Loader(apiKey, options);

  const google = await loader.load();
  const map = new google.maps.Map(mapDiv, {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 8,
  });

  const marker = new google.maps.Marker({
    position: { lat: -34.397, lng: 150.644 },
    map,
  });

  const infoWindow = new google.maps.InfoWindow({
    content: 'Hello World!',
  });

  marker.addListener('click', () => {
    infoWindow.open(map, marker);
  });

  map.addListener('click', (e) => {
    const coords = e.latLng;
    console.log(coords.lat(), coords.lng());
  });
};

(async () => {
  console.log('Hello world');
  start();
})();
