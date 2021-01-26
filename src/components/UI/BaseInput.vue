<template>
	<div class="form-group">
		<label for="{{ name }}">{{ title }}</label>
		<input type="text" class="form-control" id="{{ name }}" name="{{ name }}" v-bind:value="value">
	</div>
</template>

<script>
export default {
	props: {
		title: {
			type: String,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		value: {
			required: true
		}
	},
	data() {
		return {
		}
	}
}
</script>

<style scoped>
	

</style>