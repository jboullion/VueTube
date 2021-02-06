<template>
	<Header />
	<main class="container-fluid wrapper">
		<router-view v-slot="{ Component }" >
			<transition name="route" mode="out-in" >
			<!-- <keep-alive> -->
				<component :is="Component" :key="$route.params.videoId" />
			<!-- </keep-alive> -->
			</transition>
		</router-view>
	</main>
</template>

<script>
import Header from './components/Header/Header';



export default {
	props: [],
	components: {
		Header,
	},
	methods: {
		
	}
}
</script>

<style>
	:root {
		--red: #c00;
		--white: #ffffff;
	}

	* {
		box-sizing: border-box;
	}

	html {
		font-family: "Open Sans", sans-serif;
	}

	body {
		background-color: #f8f8f8;
		margin: 0;
		font-family: "Open Sans", sans-serif;
		transition: background-color 0.2s linear;
		overflow-y: scroll;
	}

	h1,h2,h3,h4,h5,h6,p,a {
		color: #373737;
		text-decoration: none;
		transition: color 0.2s linear;
		margin-top: 0;
	}

	.wrapper {
		padding-bottom: 50px;
	}

	body.darkmode {
		background-color: #030303;
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


	body.darkmode .card h1,
	body.darkmode .card h2,
	body.darkmode .card h3,
	body.darkmode .card h4,
	body.darkmode .card h5,
	body.darkmode .card h6 {
		color: #373737;
	}


	.opacity-0 {
		opacity: 0 !important;
	}

	.container-fluid {
		max-width: 1750px;
	}

	.ellipsis {
		text-overflow: ellipsis;
		white-space: normal;
		overflow: hidden;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		display: -webkit-box;
	}

	.channel-social {
		display: inline-block;
		margin-right: 15px;
		padding: 5px 5px 5px 0;
	}

	.youtube i { color: var(--red); }
	.patreon i { color: #f96854; }
	.twitter i { color: #1DA1F2; }
	.website i { color: #55595c; }

	.website i,
	.delete-channel {
		transition: color 0.2s linear;
	}

	.darkmode .website i,
	.darkmode .delete-channel,
	.darkmode .channel-control i {
		color: #d7dadc;
	}

	header .abcRioButtonBlue,
	header .abcRioButtonIcon {
		border-radius: 50% !important;
	}

	/* 
	@media (max-width: 1199px) {
		.container-fluid {
			padding: 0;
		}
	} 
	*/

	.form-control {
		border-radius: 0;
	}

	.input-group span { 
		border-radius: 0;
	}
	


	.route-enter-active {
		animation: route 0.15s ease-out;
	}

	.route-leave-active {
		animation: route 0.15s ease-in reverse;
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