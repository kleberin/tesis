<template>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Dealers</span>
                    </h6>
                    <dealer-filter class="nav" @dealer_filter_changed="updateDealerFilter"></dealer-filter>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Work Order Status</span>
                    </h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="woStatRadios" id="radio.wostat.1" value="asigned" v-model="workOrderStatus">
                        <label class="form-check-label" for="radio.wostat.1">Asignada</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="woStatRadios" id="radio.wostat.2" value="scheduled" v-model="workOrderStatus">
                        <label class="form-check-label" for="radio.wostat.2">Agendada</label>
                    </div>
                </div>
            </nav>
            <main role="main" id="wrapper" class="col-md-9 ml-sm-auto col-lg-10 py-4 h-100">
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
                            @closeclick="closeWindow">
                    </gmap-info-window>
                </gmap-map>
                <div class="col-md-4 floating">
                    <div class="card card-default">
                        <div class="card-header">{{cardTitle}}</div>

                        <div class="card-body" v-if="currentComponent != null">
                            <component
                                    v-bind:is="currentComponent"
                                    v-bind="currentComponentProps"
                                    v-on:show-history="loadHistory"
                                    v-on:pop-history="popHistory"
                                    v-on:show-created="loadCreated"
                                    v-on:show-asigd="loadAsigd">
                            </component>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
    import technicianComponent from './TechnicianComponent.vue';

    export default {
        data() {
            return {
                cardTitle: 'En Vivo',
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
                currentComponentProps: null,
                currentComponent: null,
                markersStack: [],
                dealerFilter: '',
                workOrderStatus: 'scheduled'
            }
        },
        components: {
          technicianComponent
        },
        mounted() {
          //  
        },
        methods: {
            updateDealerFilter: function(dealerIds) {
                let dealerFilter = '';
                if (dealerIds !== undefined) {
                    dealerFilter = '?';
                    if (dealerIds.length === 0)
                        dealerFilter += 'dealerIds[0]=-1';
                    for (let i = 0; i < dealerIds.length; i++) {
                        let qps = i === 0 ? '' : '&'; 
                        dealerFilter += `${qps}dealerIds[${i}]=${dealerIds[i]}`;
                    }
                }
                this.dealerFilter = dealerFilter;
                this.loadMapData();
            },
            loadMapData: function(dealerIds) {
                this.markers = [];
                axios.default.get(`home/live${this.dealerFilter}`)
                    .then(response => {
                        for (var i = 0; i < response.data.length; i++) {
                            this.markers.push({
                                position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                                icon: {
                                    url: 'img/building_blue.png',
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
                axios.default.get(`tracking/live${this.dealerFilter}`)
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
                    });
                this.loadWorkOrders();
            },
            toggleInfoWindow: function(marker, index) {
                this.infoWindowPos = marker.position;
                this.infoOptions.content = '';
                if (marker.name !== undefined)
                    this.infoOptions.content = '<div>' + marker.name + '</div>';
                if (marker.address !== undefined)
                    this.infoOptions.content += '<div>' + marker.address + '</div>';
                if (marker.last_location !== undefined)
                    this.infoOptions.content += '<div>' + marker.last_location.local().format('YYYY-MM-DD HH:mm:ss') + '</div>';
                if (marker.date !== undefined)
                    this.infoOptions.content += '<div>' + marker.date.local().format('YYYY-MM-DD HH:mm:ss') + '</div>';

                //check if its the same marker that was selected if yes toggle
                if (this.currentMarkerIdx === index) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMarkerIdx = index;
                    switch (marker.type) {
                        case 'technician':
                            this.cardTitle = 'Técnico';
                            this.currentComponentProps = { 'id': marker.id };
                            this.currentComponent = technicianComponent;
                            break;
                    }
                }
            },
            loadHistory(userId) {
                this.cardTitle = 'Historial';
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
            popHistory(title) {
                title = title != undefined ? 'Técnico' : title;
                this.cardTitle = title;
                this.infoWinOpen = false;
                this.markers = this.markersStack.pop();
                this.path = [];
            },
            closeWindow: function(a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);
                this.infoWinOpen=false;
                this.currentComponent = null;
                this.currentComponentProps = null;
            },
            loadWorkOrders: function() {
                switch (this.workOrderStatus) {
                    case 'asigned':
                        this.loadAsigd();
                        break;
                    case 'scheduled':
                        this.loadScheduled();
                        break;
                }
            },
            loadCreated() {
                this.cardTitle = 'Work Order Creadas';
                axios.default.get('work-order/created')
                    .then(response => {
                        for (var i = 0; i < response.data.length; i++) {
                            this.markers.push({
                                position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                                icon: {
                                    url: 'img/home_yellow.png'
                                },
                                type: 'work_order_c',
                                id: response.data[i].id,
                                name: response.data[i].status,
                                date: moment.utc(response.data[i].date)
                            })
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            loadAsigd() {
                this.cardTitle = 'Work Order Asignadas';
                axios.default.get(`work-order/asigd${this.dealerFilter}`)
                    .then(response => {
                        for (var i = 0; i < response.data.length; i++) {
                            this.markers.push({
                                position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                                icon: {
                                    url: 'img/home_red.png'
                                },
                                type: 'work_order_as',
                                id: response.data[i].id,
                                name: response.data[i].status,
                                date: moment.utc(response.data[i].date)
                            })
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            loadScheduled() {
                this.cardTitle = 'En Vivo';
                axios.default.get(`work-order/live${this.dealerFilter}`)
                    .then(response => {
                        console.log(response.data.length);
                        for (var i = 0; i < response.data.length; i++) {
                            this.markers.push({
                                position: { lat: parseFloat(response.data[i].latitude), lng: parseFloat(response.data[i].longitude) },
                                icon: {
                                    url: 'img/home_gris.png'
                                },
                                type: 'work_order',
                                id: response.data[i].id,
                                name: response.data[i].status,
                                date: moment.utc(response.data[i].date)
                            })
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        watch: {
            workOrderStatus: function() {
                this.loadMapData();
            }
        }
    }
</script>

<style>
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
        left: 30px;
        padding: 0 !important;
    }
</style>
