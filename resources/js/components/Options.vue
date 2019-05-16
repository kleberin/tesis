<template>
	<div>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'live'" v-on:click="showAsigd">Asignadas</a>
		<a class="btn btn-primary btn-sm" href="#"
			v-if="this.state == 'asigd'" v-on:click="backToLive">En Vivo</a>
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
			showAsigd() {
				this.$emit('show-asigd');
			},			
			backToLive() {
				this.$emit('pop-history', 'En Vivo');
			}
		}
	}
</script>