<template>
  <div class="container container-2">
    <div class="row">
        <div class="col-6">
            <h2 class="h2-pre">{{description}}</h2>
        </div>
        <div class="panel-body">
            <span> Suba el archivo de WO </span>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file" ref="file" v-on:change="handleFileUpload()">
                <label class="custom-file-label" for="customFile">{{fileName}}</label>
            </div>
            <button class='btn btn-default' v-on:click="submitFile()">Submit</button>
            <div class="progress" v-if="loading">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
  export default {
    data(){
      return {
        file: '',
        fileName: 'Seleccione archivo...',
        loading:false,
        description: 'Suba el archivo para continuar'
      }
    },
    methods: {
      handleFileUpload(){
        this.file = this.$refs.file.files[0];
        this.fileName = this.$refs.file.files[0].name;
      },
      submitFile(){
        let formData = new FormData();
        formData.append('file', this.file);
        this.loading = true;
        axios.default.post( 'upload-receiver',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(response => {
                if (response.data.status === 'ok') {
                    this.description = 'Leidos ' + response.data.count + ' registros';
                    this.description += '\n Calculando distancias...'
                    axios.default.post('exec-sps',{})
                        .then(response => {
                            if (response.data.status === 'ok') {
                                this.description = 'Ordenes procesadas correctamente';
                                this.loading = false;
                            }
                            else {
                                this.loading = false;
                                this.description = 'Ocurrio un error intente nuavamente';
                            }
                        })
                        .catch(error => {
                             this.loading = false;
                             this.description = 'Ocurrio un error intente nuavamente';
                        })
                }
                else {
                    this.loading = false;
                    this.description = 'Ocurrio un error intente nuavamente';
                }
            })
            .catch(error => {
                this.loading = false;
                this.description = 'Ocurrio un error intente nuavamente';
            });
      },
    }
  }
</script>

<style>
  .progress {
    margin-top: 10px;
  }
  .h2-pre{
      white-space: pre;
  }
</style>