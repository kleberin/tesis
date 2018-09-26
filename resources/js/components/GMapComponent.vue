<template>
    <div id="wrapper">
        <gmap-map
                :center="center"
                :zoom="12"
                :options="options">
            <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :icon="m.icon"
                    @click="toggleInfoWindow(m, index)">
            </gmap-marker>
            <gmap-info-window
                    :options="infoOptions"
                    :position="infoWindowPos"
                    :opened="infoWinOpen"
                    @closeclick="infoWinOpen=false">
            </gmap-info-window>
        </gmap-map>
        <div class="col-md-4 floating">
            <div class="card card-default">
                <div class="card-header">Búsqueda</div>

                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                center: {lat: -0.202499, lng: -78.499637},
                options: {
                    mapTypeControl: false,
                    fullscreenControl: false,
                    streetViewControl: false
                },
                markers: [],
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    },
                    content: ''
                },
                infoWindowPos: null,
                infoWinOpen: false,
                currentMarkerIdx: null
            }
        },
        mounted() {
            axios.default.get('home/live')
                .then(response => {
                    for (var i = 0; i < response.data.length; i++) {
                        this.markers.push({
                            position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                            icon: {
                                url: 'img/building.png',
                            },
                            name: response.data[i].name,
                            address: response.data[i].address
                        })
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        methods: {
            toggleInfoWindow: function(marker, index) {
                this.infoWindowPos = marker.position;
                this.infoOptions.content = '<div>' + marker.name + '</div>'
                    + '<div>' + marker.address + '</div>';

                //check if its the same marker that was selected if yes toggle
                if (this.currentMarkerIdx === index) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMarkerIdx = index;
                }
            }
        }
    }
</script>

<style>
    #wrapper,
    .vue-map-container,
    .vue-map {
        height: 100%;
    }
    #wrapper {
        position: relative;
    }
    .floating {
        position: absolute;
        top: 10px;
        left: 15px;
        padding: 0 !important;
    }
</style>
