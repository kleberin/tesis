<template>
  <div :class="[classProp, { 'preserve-block': true }]">
    <div class="form-check" v-for="dealer in list">
      <input class="form-check-input" type="checkbox" :value="dealer.id" :id="'check.dealer.' + dealer.id" v-model="dealer.checked" @change="changeFilter">
      <label class="form-check-label" :for="'check.dealer.' + dealer.id">{{ dealer.name }}</label>
    </div>
    <button type="button" class="btn btn-sm btn-primary" v-if="this.changed" @click="this.applyFilter">Aplicar filtro</button>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        list: [],
        classProp: '',
        current: [],
        changed: false
      }
    },
    mounted() {
      axios.default.get('dealer/list')
        .then(response => {
          for (var i = 0; i < response.data.length; i++) {
            response.data[i].checked = true;
            this.list.push(response.data[i]);
          }
          this.current = this.list.filter(e => e.checked).map(e => e.id);
          this.applyFilter();
        })
        .catch(error => {
          console.log(error);
        })
    },
    methods: {
      changeFilter() {
        let selected = this.list.filter(e => e.checked).map(e => e.id);
        if (!this.arraysEqual(selected, this.current))
          this.changed = true;
        else
          this.changed = false;
      },
      arraysEqual: function(_arr1, _arr2) {
        if (!Array.isArray(_arr1) || ! Array.isArray(_arr2) || _arr1.length !== _arr2.length)
          return false;
        var arr1 = _arr1.concat().sort();
        var arr2 = _arr2.concat().sort();
        for (var i = 0; i < arr1.length; i++) {
          if (arr1[i] !== arr2[i])
            return false;
        }
        return true;
      },
      applyFilter() {
        this.current = this.list.filter(e => e.checked).map(e => e.id);
        if (this.list.length == this.current.length)
          this.$emit('dealer_filter_changed');
        else
          this.$emit('dealer_filter_changed', this.current);
        this.changed= false;
      }
    }
  }
</script>

<style>
  .preserve-block {
    display: block;
  }
</style>