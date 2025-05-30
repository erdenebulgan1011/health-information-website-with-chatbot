<!DOCTYPE html>
<html>
<head>
    <title>Healthcare Facility Finder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        #map-container {
            display: flex;
            height: 100vh;
        }
        #sidebar {
            width: 300px;
            padding: 15px;
            background: #f8f9fa;
            overflow-y: auto;
        }
        #map {
            flex: 1;
        }
        .controls {
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        .filter-section {
            margin-top: 10px;
            padding: 5px;
            border-top: 1px solid #eee;
        }
        .filter-title {
            font-weight: bold;
            margin: 5px 0;
        }
        .place-list {
            margin-top: 10px;
        }
        .place-item {
            padding: 10px;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            cursor: pointer;
        }
        .place-item:hover {
            background: #f1f1f1;
        }
        .place-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .place-address {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }
        .place-specialties {
            font-size: 0.85em;
            color: #3a658b;
            font-style: italic;
            margin-bottom: 5px;
        }
        .place-distance {
            font-size: 0.9em;
            color: #007bff;
            font-weight: bold;
        }
        .place-type {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8em;
            margin-top: 5px;
        }
        .hospital {
            background: #f8d7da;
            color: #721c24;
        }
        .pharmacy {
            background: #d4edda;
            color: #155724;
        }
        .general {
            background: #cce5ff;
            color: #004085;
        }
        .emergency {
            background: #f93154;
            color: white;
        }
        .clinic {
            background: #fbf3d5;
            color: #856404;
        }
        .specialty {
            background: #e0cffc;
            color: #5a2c82;
        }
        .nearest {
            border: 2px solid #ffc107;
            position: relative;
        }
        .nearest::after {
            content: "NEAREST";
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ffc107;
            color: #000;
            padding: 2px 5px;
            font-size: 0.7em;
            border-radius: 3px;
        }
        .button {
            padding: 8px 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .button:hover {
            background: #0069d9;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 1000;
            display: none;
        }
    </style>
</head>
<body>
    <div id="map-container">
        <div id="sidebar">
            <h2>Healthcare Facilities</h2>
            <div class="controls">
                <label><input type="checkbox" id="show-hospitals" checked> Show Hospitals</label><br>
                <label><input type="checkbox" id="show-pharmacies" checked> Show Pharmacies</label><br>
                
                <div class="filter-section" id="hospital-filters">
                    <div class="filter-title">Hospital Types:</div>
                    <label><input type="checkbox" class="hospital-type" data-type="general" checked> General</label><br>
                    <label><input type="checkbox" class="hospital-type" data-type="emergency" checked> Emergency</label><br>
                    <label><input type="checkbox" class="hospital-type" data-type="clinic" checked> Clinic</label><br>
                    <label><input type="checkbox" class="hospital-type" data-type="specialty" checked> Specialty</label><br>
                </div>
                
                <input type="text" id="search-address" placeholder="Enter location or address">
                <button id="search-button" class="button">Search</button>
                <button id="use-my-location" class="button">Use My Location</button>
            </div>
            <div class="place-list" id="place-list">
                <!-- Places will be listed here -->
            </div>
        </div>
        <div id="map"></div>
    </div>
    <div class="loading" id="loading">Loading...</div>

    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
        let map;
        let markers = [];
        let userMarker;
        let currentLocation = [40.7128, -74.0060]; // Default to New York
        
        // Custom icons
        const hospitalIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });
        
        const pharmacyIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });
        
        const nearestIcon = L.icon({
            iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
            iconSize: [30, 49], // Slightly larger to indicate nearest
            iconAnchor: [15, 49],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41],
            shadowAnchor: [12, 41]
        });

        // Initialize the map
        function initMap() {
            map = L.map('map').setView(currentLocation, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

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
            
            // Add event listeners for hospital type filters
            document.querySelectorAll('.hospital-type').forEach(checkbox => {
                checkbox.addEventListener('change', filterPlaces);
            });

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
                return (distance * 1000).toFixed(0) + " meters";
            } else {
                return distance.toFixed(2) + " km";
            }
        }

        // Function to get user's location with high accuracy
        function getUserLocation() {
            document.getElementById("loading").style.display = "block";
            
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
                            radius: 10,
                            fillColor: "#4285F4",
                            color: "#FFFFFF",
                            weight: 3,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map).bindPopup("<strong>Your Location</strong>").openPopup();
                        
                        // Use reverse geocoding to get address of user's location
                        reverseGeocode(currentLocation[0], currentLocation[1]);
                        
                        // Search for nearby places
                        searchNearbyPlaces();
                    },
                    (error) => {
                        document.getElementById("loading").style.display = "none";
                        console.error("Geolocation error:", error);
                        alert("Could not get your location. Please enable location services or search for a location manually.");
                        // Use default location
                        searchNearbyPlaces();
                    },
                    options
                );
            } else {
                document.getElementById("loading").style.display = "none";
                alert("Geolocation is not supported by this browser.");
                // Use default location
                searchNearbyPlaces();
            }
        }

        // Function to reverse geocode coordinates to address
        function reverseGeocode(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        userMarker.bindPopup(`<strong>Your Location</strong><br>${data.display_name}`).openPopup();
                    }
                })
                .catch(error => {
                    console.error("Error in reverse geocoding:", error);
                });
        }

        // Function to search for a location
        function searchLocation() {
            const address = document.getElementById("search-address").value;
            if (!address) return;
            
            document.getElementById("loading").style.display = "block";
            
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
                            radius: 10,
                            fillColor: "#4285F4",
                            color: "#FFFFFF",
                            weight: 3,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map).bindPopup(`<strong>Searched Location</strong><br>${data[0].display_name}`).openPopup();
                        
                        // Search for nearby places
                        searchNearbyPlaces();
                    } else {
                        document.getElementById("loading").style.display = "none";
                        alert("Location not found. Please try a different search.");
                    }
                })
                .catch(error => {
                    document.getElementById("loading").style.display = "none";
                    console.error("Error searching for location:", error);
                    alert("Error searching for location. Please try again.");
                });
        }

        // Determine hospital type based on tags
        function determineHospitalType(tags) {
            if (tags.emergency === "yes") return "emergency";
            if (tags.healthcare === "clinic" || tags.amenity === "clinic") return "clinic";
            if (tags.healthcare_speciality || tags.speciality) return "specialty";
            return "general";
        }

        // Function to search for nearby places
        function searchNearbyPlaces() {
            clearMarkers();
            
            const showHospitals = document.getElementById("show-hospitals").checked;
            const showPharmacies = document.getElementById("show-pharmacies").checked;
            
            // Use Overpass API (free) to search for hospitals and pharmacies
            // Include additional tags for better classification
            const overpassQuery = `
                [out:json];
                (
                    ${showHospitals ? `
                    // Hospitals with all relevant tags
                    node["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["amenity"="hospital"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    
                    // Clinics
                    node["healthcare"="clinic"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["healthcare"="clinic"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["healthcare"="clinic"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    
                    // Doctor's offices
                    node["amenity"="doctors"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["amenity"="doctors"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["amenity"="doctors"](around:10000,${currentLocation[0]},${currentLocation[1]});` : ''}
                    
                    ${showPharmacies ? `
                    node["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    way["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});
                    relation["amenity"="pharmacy"](around:10000,${currentLocation[0]},${currentLocation[1]});` : ''}
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
                        
                        data.elements.forEach(element => {
                            if (element.type === "node" && element.tags) {
                                const distance = calculateDistance(
                                    currentLocation[0], 
                                    currentLocation[1], 
                                    element.lat, 
                                    element.lon
                                );
                                
                                if ((element.tags.amenity === "hospital" || 
                                     element.tags.healthcare === "clinic" || 
                                     element.tags.amenity === "clinic" || 
                                     element.tags.amenity === "doctors") && showHospitals) {
                                    
                                    const hospitalType = determineHospitalType(element.tags);
                                    const marker = createMarker(element, "hospital", distance, hospitalType);
                                    
                                    if (distance < nearestHospitalDistance) {
                                        nearestHospitalDistance = distance;
                                        nearestHospitalMarker = marker;
                                    }
                                } else if (element.tags.amenity === "pharmacy" && showPharmacies) {
                                    const marker = createMarker(element, "pharmacy", distance);
                                    
                                    if (distance < nearestPharmacyDistance) {
                                        nearestPharmacyDistance = distance;
                                        nearestPharmacyMarker = marker;
                                    }
                                }
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
                    alert("Error fetching places. Please try again.");
                });
        }

        // Function to create a marker for a place
        function createMarker(place, type, distance, subtype = null) {
            const placeLatLon = [place.lat, place.lon];
            const marker = L.marker(placeLatLon, {
                icon: type === "hospital" ? hospitalIcon : pharmacyIcon
            }).addTo(map);
            
            const name = place.tags.name || (type === "hospital" ? getHospitalDefaultName(subtype) : "Pharmacy");
            
            // Build address from available components
            let addressParts = [];
            if (place.tags["addr:street"] && place.tags["addr:housenumber"]) {
                addressParts.push(place.tags["addr:housenumber"] + " " + place.tags["addr:street"]);
            } else if (place.tags["addr:street"]) {
                addressParts.push(place.tags["addr:street"]);
            } else if (place.tags["addr:housenumber"]) {
                addressParts.push(place.tags["addr:housenumber"]);
            }
            
            if (place.tags["addr:city"]) {
                addressParts.push(place.tags["addr:city"]);
            }
            
            if (place.tags["addr:postcode"]) {
                addressParts.push(place.tags["addr:postcode"]);
            }
            
            const address = addressParts.length > 0 ? addressParts.join(", ") : "Address not available";
            
            // Get specialties or services if available
            let specialties = [];
            if (place.tags.healthcare_speciality) {
                specialties = place.tags.healthcare_speciality.split(';').map(s => s.trim());
            } else if (place.tags.speciality) {
                specialties = place.tags.speciality.split(';').map(s => s.trim());
            }
            
            // Phone number
            const phone = place.tags.phone || place.tags["contact:phone"] || null;
            
            let popupContent = `
                <div>
                    <h3>${name}</h3>
                    <p>${address}</p>
                    <p>Type: ${type.charAt(0).toUpperCase() + type.slice(1)}${subtype ? ` (${subtype.charAt(0).toUpperCase() + subtype.slice(1)})` : ''}</p>
                    <p>Distance: ${formatDistance(distance)}</p>
            `;
            
            if (specialties.length > 0) {
                popupContent += `<p>Specialties: ${specialties.join(', ')}</p>`;
            }
            
            if (phone) {
                popupContent += `<p>Phone: ${phone}</p>`;
            }
            
            popupContent += `</div>`;
            
            marker.bindPopup(popupContent);
            
            marker.placeType = type;
            marker.subType = subtype;
            marker.placeData = {
                name: name,
                address: address,
                lat: place.lat,
                lon: place.lon,
                distance: distance,
                specialties: specialties,
                phone: phone
            };
            
            markers.push(marker);
            return marker;
        }

        // Get a default name for hospital types
        function getHospitalDefaultName(subtype) {
            if (!subtype) return "Hospital";
            switch(subtype) {
                case "emergency": return "Emergency Hospital";
                case "clinic": return "Medical Clinic";
                case "specialty": return "Specialty Hospital";
                default: return "General Hospital";
            }
        }

        // Function to clear all markers
        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            document.getElementById("place-list").innerHTML = "";
        }

        // Function to filter places
        function filterPlaces() {
            // If it's just hospital type filtering, we can avoid refetching data
            if (markers.length > 0) {
                updatePlacesList();
            } else {
                searchNearbyPlaces();
            }
        }

        // Function to update the places list
        function updatePlacesList() {
            const showHospitals = document.getElementById("show-hospitals").checked;
            const showPharmacies = document.getElementById("show-pharmacies").checked;
            const placesList = document.getElementById("place-list");
            
            // Get enabled hospital types
            const enabledHospitalTypes = Array.from(document.querySelectorAll('.hospital-type:checked'))
                .map(checkbox => checkbox.dataset.type);
            
            placesList.innerHTML = "";

            const visibleMarkers = markers.filter(marker => {
                // Filter by main type (hospital/pharmacy)
                if (marker.placeType === "hospital" && !showHospitals) return false;
                if (marker.placeType === "pharmacy" && !showPharmacies) return false;
                
                // If it's a hospital, also filter by subtype
                if (marker.placeType === "hospital" && !enabledHospitalTypes.includes(marker.subType)) {
                    // Hide the marker on the map
                    map.removeLayer(marker);
                    return false;
                } else {
                    // Make sure the marker is on the map
                    if (!map.hasLayer(marker)) {
                        marker.addTo(map);
                    }
                    return true;
                }
            });

            // Sort by distance
            visibleMarkers.sort((a, b) => {
                return a.placeData.distance - b.placeData.distance;
            });

            visibleMarkers.forEach(marker => {
                const place = marker.placeData;
                const div = document.createElement("div");
                div.className = marker.isNearest ? "place-item nearest" : "place-item";
                
                let html = `
                    <div class="place-name">${place.name}</div>
                    <div class="place-address">${place.address}</div>
                `;
                
                if (place.specialties && place.specialties.length > 0) {
                    html += `<div class="place-specialties">Specialties: ${place.specialties.join(', ')}</div>`;
                }
                
                html += `
                    <div class="place-distance">Distance: ${formatDistance(place.distance)}</div>
                `;
                
                if (marker.placeType === "hospital" && marker.subType) {
                    html += `<div class="place-type ${marker.placeType} ${marker.subType}">${marker.subType.charAt(0).toUpperCase() + marker.subType.slice(1)} ${marker.placeType.charAt(0).toUpperCase() + marker.placeType.slice(1)}</div>`;
                } else {
                    html += `<div class="place-type ${marker.placeType}">${marker.placeType.charAt(0).toUpperCase() + marker.placeType.slice(1)}</div>`;
                }
                
                div.innerHTML = html;
                
                div.addEventListener("click", () => {
                    map.setView([place.lat, place.lon], 16);
                    marker.openPopup();
                });
                placesList.appendChild(div);
            });
        }

        // Initialize the map when the page loads
        window.onload = initMap;
    </script>
</body>
</html>