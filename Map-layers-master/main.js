const apiKey = 'pk.eyJ1IjoiYWxmcmVkMjAxNiIsImEiOiJja2RoMHkyd2wwdnZjMnJ0MTJwbnVmeng5In0.E4QbAFjiWLY8k3AFhDtErA';

const mymap = L.map('map').setView([40.72659208460753, -73.98181628235675], 13);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: apiKey
}).addTo(mymap);

// Adding Marker

const marker = L.marker([40.72659208460753, -73.98181628235675]).addTo(mymap);

// Add popup message
let template = `

<h3>Fire Danger</h3>
<div style="text-align:center">
    <img width="150" height="150"src="image.jpg"/>
</div>
`
marker.bindPopup(template);

// Add circle 

const circle = L.circle([40.72659208460753, -73.98181628235675], {
    radius:500, 
    color: 'green', 
    fillColor: 'red',
    fillOpacity:0.2
}).addTo(mymap).bindPopup('Fire Zone')

// Add Polygon

const polygon = L.polygon([
   
     [40.73618, -73.97545],
    [40.731497, -73.974342],
    [40.729324, -73.972234],
     [40.732368, -73.981293],
 ], {
     color:'blue',
    fillColor:'blue',
    fillOpacity:0.2
 }).addTo(mymap).bindPopup('Flood Danger')

 polygon.bindPopup('Flood Danger')
