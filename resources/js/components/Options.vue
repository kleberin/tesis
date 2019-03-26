<template>
	<div>
		<a class="btn btn-primary btn-sm" href="upload-work-order">Cargar Work Orders</a>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'live'" v-on:click="showCreated">Creadas</a>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'created'" v-on:click="backToLive">En Vivo</a>
	</div>
</template>

<script>
	export default {
		data() {
			return {}
		},
		props: [
			'state'
		],
		methods: {
			showCreated() {
				this.$emit('show-created');
			},
			backToLive() {
				this.$emit('pop-history', 'En Vivo');
			}
		}
	}
</script>