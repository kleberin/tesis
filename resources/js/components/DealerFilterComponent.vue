<template>
  <div :class="[classProp, { 'preserve-block': true }]">
    <div class="form-check" v-for="dealer in list">
      <input class="form-check-input" type="checkbox" :value="dealer.id" :id="'check.dealer.' + dealer.id" v-model="dealer.checked" @change="changeFilter">
      <label class="form-check-label" :for="'check.dealer.' + dealer.id">{{ dealer.name }}</label>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        list: [],
        classProp: ''
      }
    },
    mounted() {
      axios.default.get('dealer/list')
        .then(response => {
          for (var i = 0; i < response.data.length; i++) {
            response.data[i].checked = true;
            this.list.push(response.data[i]);
          }
          this.changeFilter();
        })
        .catch(error => {
          console.log(error);
        })
    },
    methods: {
      changeFilter() {
        let selected = this.list.filter(e => e.checked).map(e => e.id);
        if (this.list.length == selected.length)
          this.$emit('dealer_filter_changed');
        else
          this.$emit('dealer_filter_changed', selected);
      }
    }
  }
</script>

<style>
  .preserve-block {
    display: block;
  }
</style>