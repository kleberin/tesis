<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header">{{title}}</div>

                    <div class="card-body">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
          'title'
        ],
        mounted() {
            console.log('Component mounted.');
            axios.default.get('/klever/public/api/user')
              .then(response => {
                console.log(response)
              })
              .catch(error => {

              })
        }
    }
</script>
