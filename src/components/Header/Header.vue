<template>
	<header>
		<h3><a href="#">Betafilter</a></h3>
		<i class="fas fa-sun"></i>
		<!-- <i class="fas fa-moon"></i> -->
		<button class="btn btn-primary"><i class="fas fa-ellipsis-v"></i></button>
	</header>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			
		};
	}
}
</script>

<style scoped>
	header {
		background-color: #353535;
		color: white;
		display: flex;
		justify-content: space-between;
		padding: 15px;
	}

	h3 {
		margin-bottom: 0;
	}

	h3 a {
		color: white;
		text-decoration: none;
	}
</style>