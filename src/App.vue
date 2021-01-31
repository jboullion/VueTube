<template>
	<Header />
	<main class="container-fluid wrapper">
		<router-view v-slot="{ Component }">
			<keep-alive>
				<component :is="Component" />
			</keep-alive>
		</router-view>
		<!-- <FullVideo :video="video" /> -->
	</main>
</template>

<script>
import Header from './components/Header/Header';

export default {
	props: [],
	components: {
		Header,
		//FullVideo
	},
	data() {
		return {
		};
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
		color: #efefef;
	}

	/* @media (max-width: 1199px) {
		.container-fluid {
			padding: 0;
		}
	} */
</style>