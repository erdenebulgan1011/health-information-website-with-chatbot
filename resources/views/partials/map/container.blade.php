<!-- Map Component (Compact Version) -->
<div id="map-container" class="w-full flex flex-col md:flex-row bg-white rounded shadow-sm relative" style="height: 300px; max-height: 300px; overflow: hidden;">
    <!-- Sidebar -->
    @include('partials.map.sidebar')

    <!-- Map -->
    @include('partials.map.canvas')
</div>

<!-- Loading indicator -->
@include('partials.map.loading')

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />

<!-- Custom Styles -->
<style>
    /* Fix for map overlap issues */
    #map-container {
        position: relative;
        z-index: 10;
    }

    #sidebar {
        position: relative;
        z-index: 20; /* Higher than map */
        background-color: white;
    }

    #map {
        position: relative;
        z-index: 15;
    }

    .leaflet-pane {
        z-index: 16;
    }

    .leaflet-control {
        z-index: 25 !important;
    }

    /* Original styles */
    .place-item {
        padding: 4px 6px;
        border-bottom: 1px solid #e2e8f0;
        cursor: pointer;
        font-size: 0.7rem;
    }

    .place-item:hover {
        background-color: #f7fafc;
    }

    .place-item.nearest {
        background-color: #e6f7ff;
        border-left: 2px solid #38b2ac;
    }

    .place-name {
        font-weight: 600;
        color: #2d3748;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .place-address {
        font-size: 0.65rem;
        color: #4a5568;
        margin-top: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .place-distance {
        font-size: 0.65rem;
        color: #718096;
    }

    .place-type {
        display: inline-block;
        font-size: 0.6rem;
        padding: 1px 4px;
        border-radius: 8px;
        margin-top: 1px;
    }

    .place-type.hospital {
        background-color: #c6f6d5;
        color: #22543d;
    }

    .place-type.pharmacy {
        background-color: #feebc8;
        color: #723b13;
    }

    .leaflet-container {
        font-size: 12px;
    }

    /* Make popup smaller */
    .leaflet-popup-content {
        margin: 8px;
        font-size: 0.75rem;
        line-height: 1.3;
    }

    .leaflet-popup-content h3 {
        font-size: 0.85rem;
        margin: 0 0 3px 0;
    }

    .leaflet-popup-content p {
        margin: 2px 0;
    }
</style>

<!-- Leaflet JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script>
    // Initialize map variables
    let map;
    let markers = [];
    let userMarker;
    let currentLocation = [47.9184, 106.9173]; // Default to Ulaanbaatar, Mongolia

    // Custom icons
    const hospitalIcon = L.icon({
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        iconSize: [20, 33],
        iconAnchor: [10, 33],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        shadowSize: [33, 33],
        shadowAnchor: [10, 33]
    });

    const pharmacyIcon = L.icon({
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        iconSize: [20, 33],
        iconAnchor: [10, 33],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        shadowSize: [33, 33],
        shadowAnchor: [10, 33]
    });

    const nearestIcon = L.icon({
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        iconSize: [24, 39],
        iconAnchor: [12, 39],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        shadowSize: [33, 33],
        shadowAnchor: [10, 33]
    });

    // Initialize the map
    function initMap() {
        // Ensure the map element is fully rendered before initializing
        if (!document.getElementById('map').offsetWidth) {
            setTimeout(initMap, 100);
            return;
        }

        map = L.map('map', {
            zoomControl: false, // Remove zoom control
            renderer: L.canvas() // Use canvas renderer for better performance
        }).setView(currentLocation, 13);

        // Add zoom control to top-right
        L.control.zoom({
            position: 'topright'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        // Force a resize after initialization
        setTimeout(function() {
            map.invalidateSize(true);
        }, 200);

        // Set up event listeners
        document.getElementById("use-my-location").addEventListener("click", getUserLocation);
        document.getElementById("search-button").addEventListener("click", searchLocation);
        document.getElementById("search-address").addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                searchLocation();
            }
        });
        document.getElementById("show-hospitals").addEventListener("change", filterPlaces);
        document.getElementById("show-pharmacies").addEventListener("change", filterPlaces);

        // Try to get user's location right away
        getUserLocation();
    }

    // Calculate distance between two points
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        const d = R * c; // Distance in km
        return d;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    // Format distance for display
    function formatDistance(distance) {
        if (distance < 1) {
            return (distance * 1000).toFixed(0) + "м";
        } else {
            return distance.toFixed(1) + "км";
        }
    }

    // Function to get user's location with high accuracy
    function getUserLocation() {
        document.getElementById("loading").style.display = "flex";

        if (navigator.geolocation) {
            const options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            };

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    currentLocation = [position.coords.latitude, position.coords.longitude];

                    // Update view to user location with close zoom
                    map.setView(currentLocation, 15);

                    // If user marker exists, remove it
                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }

                    // Add a marker for the user's location
                    userMarker = L.circleMarker(currentLocation, {
                        radius: 8,
                        fillColor: "#4285F4",
                        color: "#FFFFFF",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map).bindPopup("<strong>Таны байршил</strong>").openPopup();

                    // Search for nearby places
                    searchNearbyPlaces();
                },
                (error) => {
                    document.getElementById("loading").style.display = "none";
                    console.error("Geolocation error:", error);
                    alert("Таны байршлыг тогтоож чадсангүй. Байршлын үйлчилгээг идэвхжүүлнэ үү эсвэл хайлтаар хайна уу.");
                    // Use default location
                    searchNearbyPlaces();
                },
                options
            );
        } else {
            document.getElementById("loading").style.display = "none";
            alert("Энэ хөтөч байршил тогтоох үйлчилгээг дэмждэггүй.");
            // Use default location
            searchNearbyPlaces();
        }
    }

    // Function to search for a location
    function searchLocation() {
        const address = document.getElementById("search-address").value;
        if (!address) return;

        document.getElementById("loading").style.display = "flex";

        // Use Nominatim API for geocoding (free)
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    currentLocation = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                    map.setView(currentLocation, 15);

                    // If user marker exists, remove it
                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }

                    // Add a marker for the searched location
                    userMarker = L.circleMarker(currentLocation, {
                        radius: 8,
                        fillColor: "#4285F4",
                        color: "#FFFFFF",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map).bindPopup("<strong>Хайсан байршил</strong>").openPopup();

                    // Search for nearby places
                    searchNearbyPlaces();
                } else {
                    document.getElementById("loading").style.display = "none";
                    alert("Байршил олдсонгүй. Өөр хайлт хийнэ үү.");
                }
            })
            .catch(error => {
                document.getElementById("loading").style.display = "none";
                console.error("Error searching for location:", error);
                alert("Байршил хайхад алдаа гарлаа. Дахин оролдоно уу.");
            });
    }

    // Function to search for nearby places
    function searchNearbyPlaces() {
        clearMarkers();

        const showHospitals = document.getElementById("show-hospitals").checked;
        const showPharmacies = document.getElementById("show-pharmacies").checked;

        // Use Overpass API (free) to search for hospitals and pharmacies
        // Increase search radius to 5km (5000 meters) to reduce data
        const overpassQuery = `
            [out:json];
            (
                ${showHospitals ? `node["amenity"="hospital"](around:5000,${currentLocation[0]},${currentLocation[1]});
                way["amenity"="hospital"](around:5000,${currentLocation[0]},${currentLocation[1]});
                relation["amenity"="hospital"](around:5000,${currentLocation[0]},${currentLocation[1]});` : ''}

                ${showPharmacies ? `node["amenity"="pharmacy"](around:5000,${currentLocation[0]},${currentLocation[1]});
                way["amenity"="pharmacy"](around:5000,${currentLocation[0]},${currentLocation[1]});
                relation["amenity"="pharmacy"](around:5000,${currentLocation[0]},${currentLocation[1]});` : ''}
            );
            out body;
            >;
            out skel qt;
        `;

        const overpassUrl = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(overpassQuery)}`;

        fetch(overpassUrl)
            .then(response => response.json())
            .then(data => {
                if (data && data.elements) {
                    let nearestHospitalDistance = Infinity;
                    let nearestPharmacyDistance = Infinity;
                    let nearestHospitalMarker = null;
                    let nearestPharmacyMarker = null;

                    // Limit to 20 places for performance
                    let hospitals = [];
                    let pharmacies = [];

                    data.elements.forEach(element => {
                        if (element.type === "node" && element.tags) {
                            const distance = calculateDistance(
                                currentLocation[0],
                                currentLocation[1],
                                element.lat,
                                element.lon
                            );

                            if (element.tags.amenity === "hospital" && showHospitals) {
                                hospitals.push({element, distance});
                            } else if (element.tags.amenity === "pharmacy" && showPharmacies) {
                                pharmacies.push({element, distance});
                            }
                        }
                    });

                    // Sort by distance and take only the 10 closest of each type
                    hospitals.sort((a, b) => a.distance - b.distance);
                    pharmacies.sort((a, b) => a.distance - b.distance);

                    hospitals = hospitals.slice(0, 10);
                    pharmacies = pharmacies.slice(0, 10);

                    // Create markers for the filtered places
                    hospitals.forEach(({element, distance}) => {
                        const marker = createMarker(element, "hospital", distance);

                        if (distance < nearestHospitalDistance) {
                            nearestHospitalDistance = distance;
                            nearestHospitalMarker = marker;
                        }
                    });

                    pharmacies.forEach(({element, distance}) => {
                        const marker = createMarker(element, "pharmacy", distance);

                        if (distance < nearestPharmacyDistance) {
                            nearestPharmacyDistance = distance;
                            nearestPharmacyMarker = marker;
                        }
                    });

                    // Highlight nearest facilities
                    if (nearestHospitalMarker) {
                        nearestHospitalMarker.setIcon(nearestIcon);
                        nearestHospitalMarker.isNearest = true;
                    }

                    if (nearestPharmacyMarker) {
                        nearestPharmacyMarker.setIcon(nearestIcon);
                        nearestPharmacyMarker.isNearest = true;
                    }

                    updatePlacesList();
                }
                document.getElementById("loading").style.display = "none";
            })
            .catch(error => {
                document.getElementById("loading").style.display = "none";
                console.error("Error fetching places:", error);
                alert("Байгууллагуудыг татахад алдаа гарлаа. Дахин оролдоно уу.");
            });
    }

    // Function to create a marker for a place
    function createMarker(place, type, distance) {
        const placeLatLon = [place.lat, place.lon];
        const marker = L.marker(placeLatLon, {
            icon: type === "hospital" ? hospitalIcon : pharmacyIcon
        }).addTo(map);

        const name = place.tags.name || (type === "hospital" ? "Эмнэлэг" : "Эмийн сан");
        const address = [
            place.tags["addr:street"],
            place.tags["addr:housenumber"],
            place.tags["addr:city"],
            place.tags["addr:postcode"]
        ].filter(Boolean).join(", ");

        marker.bindPopup(`
            <div>
                <h3>${name}</h3>
                <p>${address || "Хаяг мэдээлэл байхгүй"}</p>
                <p>Төрөл: ${type === "hospital" ? "Эмнэлэг" : "Эмийн сан"}</p>
                <p>Зай: ${formatDistance(distance)}</p>
            </div>
        `);

        marker.placeType = type;
        marker.placeData = {
            name: name,
            address: address,
            lat: place.lat,
            lon: place.lon,
            distance: distance
        };

        markers.push(marker);
        return marker;
    }

    // Function to clear all markers
    function clearMarkers() {
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        document.getElementById("place-list").innerHTML = "";
    }

    // Function to filter places
    function filterPlaces() {
        searchNearbyPlaces();
    }

    // Function to update the places list
    function updatePlacesList() {
        const showHospitals = document.getElementById("show-hospitals").checked;
        const showPharmacies = document.getElementById("show-pharmacies").checked;
        const placesList = document.getElementById("place-list");

        placesList.innerHTML = "";

        const visibleMarkers = markers.filter(marker =>
            (marker.placeType === "hospital" && showHospitals) ||
            (marker.placeType === "pharmacy" && showPharmacies)
        );

        // Sort by distance
        visibleMarkers.sort((a, b) => {
            return a.placeData.distance - b.placeData.distance;
        });

        visibleMarkers.forEach(marker => {
            const place = marker.placeData;
            const div = document.createElement("div");
            div.className = marker.isNearest ? "place-item nearest" : "place-item";
            div.innerHTML = `
                <div class="place-name">${place.name}</div>
                <div class="place-address">${place.address || "Хаяг мэдээлэл байхгүй"}</div>
                <div class="flex justify-between items-center">
                    <div class="place-distance">${formatDistance(place.distance)}</div>
                    <div class="place-type ${marker.placeType}">${marker.placeType === "hospital" ? "Эмнэлэг" : "Эмийн сан"}</div>
                </div>
            `;
            div.addEventListener("click", () => {
                map.setView([place.lat, place.lon], 16);
                marker.openPopup();
            });
            placesList.appendChild(div);
        });
    }

    // Initialize the map when the component loads
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('map')) {
            // Small delay to ensure DOM is fully rendered
            setTimeout(function() {
                initMap();

                // Force map to recalculate size after initialization
                setTimeout(function() {
                    if (map) {
                        map.invalidateSize(true);
                    }
                }, 300);
            }, 100);
        }
    });

    // Handle resize events
    window.addEventListener('resize', function() {
        if (map) {
            map.invalidateSize(true);
        }
    });
</script>
