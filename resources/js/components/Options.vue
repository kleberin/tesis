<template>
	<div>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'live'" v-on:click="showCreated">Asignadas</a>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'created'" v-on:click="backToLive">Work Order Status</a>
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