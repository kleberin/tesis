<template>
    <div class="container">
        <div class="progress" v-if="showProgress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
        <div class="row" v-if="!showProgress">
            <div class="col">
                <p><b>Nombre</b> {{name}}</p>
                <p><b>Email</b> {{email}}</p>
                <a href="#" v-on:click="showHistory" v-if="!historyShown">Ver historial</a>
                <a href="#" v-on:click="backToLive" v-if="historyShown">Ver en vivo</a>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        showProgress: false,
        name: '',
        email: '',
        historyShown: false
      }
    },
    props: [
      'id'
    ],
    watch: {
      'id': function (newId) {
        this.loadTecnicianInfo(newId);
      }
    },
    mounted() {
       this.loadTecnicianInfo(this.id);
    },
    methods: {
      loadTecnicianInfo(id) {
        axios.default.get('technician/' + id)
          .then(response => {
            this.name = response.data['name'];
            this.email = response.data['email'];
            this.showProgress = false;
          })
          .catch(error => {
            console.log(error);
            this.showProgress = false;
          });
        this.showProgress = true;
      },
      showHistory() {
        this.$emit('show-history', this.id);
        this.historyShown = true;
      },
      backToLive() {
        this.$emit('pop-history', 'En Vivo');
        this.historyShown = false;
      }
    }
  }
</script>

<style scoped>

</style>