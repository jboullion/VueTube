<template>
	<button :type="type" :class="classes">
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: ['type', 'classes'],
	data() {
		return {
		}
	}
}
</script>

<style scoped>
	button {
		border-radius: 0;
	}
</style>