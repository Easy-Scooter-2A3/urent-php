// add leaflet
import L from 'leaflet';
import { doGet } from './utils';

const data_endpoint_url: string = "/api/getwaypoints";
let lat: number = 48.852969;
let lon: number = 2.349903;
let map: L.Map | L.LayerGroup<any> | null = null;

interface ILinkWaypoint {
    latitude: number;
    longitude: number;
    timestamp: string;
}

interface IWaypoint {
    id: number;
    start_latitude: number;
    'start_longitude': number;
    'end_latitude': number;
    'end_longitude': number;
    'start_timestamp': string;
    'end_timestamp': string;
    'waypoints': ILinkWaypoint[];
    'distance_meters': number;
}

function getWaypoints() {
    return doGet(data_endpoint_url);
}

function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    map = L.map('map').setView([lat, lon], 11);
    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(map);
}

function parsePosition(pos: number) {
    let tp = pos.toString().slice(-7);
    let npos = pos.toString().replace(tp, ',' + tp);
    console.log(npos);
    return parseFloat(npos);
}

(async () => {
    initMap();
    let waypoints = await getWaypoints();
    if (!waypoints) {
        console.log("No waypoints found");
        return;
    }
    console.log(waypoints["data"]["data"].length);
    waypoints["data"]["data"].forEach((waypoint: IWaypoint) => {
        let marker = L.marker([
            parsePosition(waypoint["end_latitude"]),
            parsePosition(waypoint["end_longitude"])
        ]).addTo(map);
    });

})();
