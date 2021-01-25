<template>
	<header>
		<h3><a href="#">Betafilter</a></h3>
		<base-button classes="btn btn-primary">
			<i class="fas fa-sun"></i>
		</base-button>

		
		<i class="fas fa-user-shield"></i>
		<!-- <i class="fas fa-moon"></i> -->
		<i class="fas fa-user-circle"></i>
	</header>
</template>

<script>
import BaseButton from '../UI/BaseButton.vue';

export default {
  components: { BaseButton },
	props: [],
	data() {
		return {
			
		};
	}
}
</script>

<style scoped>
	header {
		align-items: center;
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

	i {
		cursor: pointer;
		font-size: 30px;
	}
</style>