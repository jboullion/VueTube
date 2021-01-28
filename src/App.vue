<template>
	<Header :toggleDarkmode="toggleDarkmode" :darkmode="darkmode"/>
	<main class="container-fluid wrapper">
		<router-view></router-view>
	</main>
</template>

<script>
import Header from './components/Header/Header';

export default {
	components: {
		Header
	},
	data() {
		return {
			darkmode: false
		};
	},
	methods: {
		toggleDarkmode(){
			this.darkmode = !this.darkmode;
			if(this.darkmode){
				document.body.className = 'darkmode';
			}else{
				document.body.className = '';
			}
		}
	}
}
</script>

<style>
	* {
		box-sizing: border-box;
	}

	html {
		font-family: 'Roboto', sans-serif;
	}

	body {
		background-color: #f8f8f8;
		margin: 0;
		font-family: 'Roboto', sans-serif;
		transition: background-color 0.2s linear;
	}

	h1,h2,h3,h4,h5,h6, p {
		transition: color 0.2s linear;
		margin-top: 0;
	}

	.wrapper {
		padding-bottom: 50px;
	}

	body.darkmode {
		background-color: #111111;
	}

	body.darkmode h1,
	body.darkmode h2,
	body.darkmode h3,
	body.darkmode h4,
	body.darkmode h5,
	body.darkmode h6,
	body.darkmode p {
		color: #f8f8f8;
	}

	.opacity-0 {
		opacity: 0 !important;
	}
</style>