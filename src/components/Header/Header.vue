<template>
	<header>
		<h3><router-link to="/"><i class="fas fa-home"></i></router-link></h3>

		<transition name="darkmode" mode="out-in">
			<i class="fas fa-sun fa-fw" @click="toggleDarkmode" v-if="!darkmode"></i>
			<i class="fas fa-moon fa-fw" @click="toggleDarkmode" v-else></i>
		</transition>

		<router-link to="/admin"><i class="fas fa-fw fa-user-shield"></i></router-link>
		
		<router-link to="/account"><i class="fas fa-fw fa-user-circle"></i></router-link>
	</header>
</template>

<script>

export default {
  components: {  },
	props: [],
	data() {
		return {
			darkmode: false,
		};
	},
	created(){
		this.darkmode = localStorage.getItem('darkmode');
		if(this.darkmode){
			document.body.className = 'darkmode';
		}else{
			document.body.className = '';
		}
	},
	methods: {
		toggleDarkmode(){
			this.darkmode = !this.darkmode;
			if(this.darkmode){
				document.body.className = 'darkmode';
				localStorage.setItem('darkmode', 1);
			}else{
				document.body.className = '';
				localStorage.removeItem('darkmode')
			}

			
		},

	}
}
</script>

<style scoped>
	header {
		align-items: center;
		background-color: #222222;
		color: white;
		display: flex;
		justify-content: space-between;
		padding: 10px 15px;
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
		font-size: 26px;
	}

	span {
		position: relative;
	}

	span i {
		transition: opacity 0.2s linear;
		opacity: 1;
		position: absolute;
		top: 0;
		left: 0;
	}

	button {
		background-color: transparent;
		border: 0;
		color: white;
	}

	button:active,
	button:focus {
		outline: 0;
	}

	a {
		color: white;
	}

	a:hover, 
	a:active,
	a.router-link-active {
		color: var(--bs-blue);
	}

	.darkmode-enter-from {

	}

	.darkmode-enter-active {
		animation: route 0.2s ease-out;
	}

	.darkmode-enter-to {
		
	}

	.darkmode-leave-from {
		
	}

	.darkmode-leave-active {
		animation: route 0.2s ease-in reverse;
	}

	.darkmode-leave-to {
		
	}

	@keyframes route {
		from {
			opacity: 0;
			/* transform: translateY(50px); */
		}

		to {
			opacity: 1;
			/* transform: translateY(0); */
		}
	}
</style>