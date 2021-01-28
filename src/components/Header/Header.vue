<template>
	<header>
		<h3><router-link to="/">Betafilter</router-link></h3>
		
		<span>
			<i :class="{'opacity-0':darkmode, fas:true, 'fa-sun': true}" @click="toggleDarkmode" ></i>
			<i :class="{'opacity-0':!darkmode, fas:true, 'fa-moon': true}"  @click="toggleDarkmode"></i>
		</span>
		

		<router-link to="/admin"><i class="fas fa-user-shield"></i></router-link>
		
		<router-link to="/account"><i class="fas fa-user-circle"></i></router-link>
	</header>
</template>

<script>

export default {
  components: {  },
	props: ['toggleDarkmode', 'darkmode'],
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

	span {
		
		
		position: relative;
		height: 30px;
	}

	span i {
		transition: opacity 0.2s linear;
		opacity: 1;
		position: absolute;
		top: 0;
		left: 0;
	}
</style>