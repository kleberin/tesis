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
            <gmap-polyline
                    v-if="path.length > 0"
                    :path="path">
            </gmap-polyline>
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
                    <component
                            v-bind:is="currentComponent"
                            v-bind="currentComponentProps"
                            v-on:show-history="loadHistory"
                            v-on:pop-history="popHistory">
                    </component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import technicianComponent from './TechnicianComponent.vue';
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
                path: [],
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    },
                    content: ''
                },
                infoWindowPos: null,
                infoWinOpen: false,
                currentMarkerIdx: null,
                currentComponent: null,
                currentComponentProps: {},
                markersStack: []
            }
        },
        components: {
          technicianComponent
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
                            type: 'dealer',
                            name: response.data[i].name,
                            address: response.data[i].address
                        })
                    }
                })
                .catch(error => {
                    console.log(error)
                });
            axios.default.get('tracking/live')
                .then(response => {
                    for (var i = 0; i < response.data.length; i++) {
                        this.markers.push({
                            position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                            icon: {
                                url: 'img/tecnician.png'
                            },
                            type: 'technician',
                            id: response.data[i].user_id,
                            name: response.data[i].name,
                            last_location: moment.utc(response.data[i].reported_at)
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
                this.infoOptions.content = '';
                if (marker.name !== undefined)
                    this.infoOptions.content = '<div>' + marker.name + '</div>';
                if (marker.address !== undefined)
                    this.infoOptions.content += '<div>' + marker.address + '</div>';
                if (marker.last_location !== undefined)
                    this.infoOptions.content += '<div>' + marker.last_location.local().format('YYYY-MM-DD HH:mm:ss') + '</div>';

                //check if its the same marker that was selected if yes toggle
                if (this.currentMarkerIdx === index) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMarkerIdx = index;
                    switch (marker.type) {
                        case 'dealer':
                            this.currentComponent = null;
                            break;
                        case 'technician':
                            this.currentComponentProps = { 'id': marker.id };
                            this.currentComponent = technicianComponent;
                            break;
                    }
                }
            },
            loadHistory(userId) {
                axios.default.get('tracking/' + userId + '/history')
                    .then(response => {
                        console.log(response);
                        this.markersStack.push(this.markers);
                        this.infoWinOpen = false;
                        this.markers = [];
                        for (var i = 0; i < response.data.length; i++) {
                            this.markers.push({
                                position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                                type: 'history',
                                last_location: moment.utc(response.data[i].reported_at)
                            });
                            this.path.push({ lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) });
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            popHistory() {
                this.infoWinOpen = false;
                this.markers = this.markersStack.pop();
                this.path = [];
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
