<template>
	<div v-if="video.youtube_id" class="card video yt-video">
		<router-link :to="'/video/'+ video.youtube_id" class="card-link" >
			<div class="card-img-back">
				<img loading="lazy" width="320" height="180" 
				:src="'https://img.youtube.com/vi/'+video.youtube_id+'/mqdefault.jpg'" 
				class="lazyload"
				:alt="video.title">
			<!-- <i class="fas fa-play-circle"></i> -->
			</div>
		</router-link>
		<div class="card-body">
			<p class="ellipsis">{{ video.title }}</p>
			<a :href="'/channel/'+video.channel_youtube" v-if="showChannel">
				<span class="channel">{{ video.channel_title }}</span>
			</a>
			<span class="date">{{ videoDate }}</span>
		</div>
	</div>
</template>

<script>
// 'https://www.youtube.com/channel/'+video.channel_youtube
// :src="'https://img.youtube.com/vi/'+ video.youtube_id+'/sddefault.jpg'"
import moment from 'moment'

export default {
	props: ['video', 'showChannel'],
	data() {
		return {
			videoDate: null
		};
	},
	created(){
		this.videoDate = moment(this.video.date).format('MMM D, YYYY');
	},
	computed: {
		
	},
	methods: {

	}
}
</script>

<style scoped>
	.card.video {
		border: 0;
		background-color: transparent;
		box-shadow: none;
		display: flex;
		transition: background-color 0.1s;
		height: 100%;
	}

	.card.video:hover {
		text-decoration: none;
	}

	.card.video:hover .card-img-back i {
		opacity: 1;
	}

	.card-img-back {
		background-color: #eceeef;
		position: relative;
	}

	.card-img-back img {
		position: absolute;
		top: 0;
		left: 0;
	}

	.card-img-back i {
		border-radius: 50%;
		color: rgba(255,255,255,0.85);
		opacity: 0;
		box-shadow: 0px 0px 5px 3px rgba(0,0,0,0.25);
		transition: opacity 0.1s linear;
		font-size: 74px;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

	.card-img-back i.fa-primary {
		color: #373737;
	}

	.card-body {
		height: 103px;
		padding: 10px;
		position: relative;
		color: #55595c;
		transition: color 0.2s linear;
	}

	.card-body p {
		font-weight: bold;
		margin-bottom: 4px;
	}

	.card-body span.channel {
		margin-bottom: 0;
		font-size: 14px;
	}

	.card-body span.date {
		position: absolute;
		bottom: 10px;
		left: 10px;
		font-size: 14px;
		transition: color 0.2s linear;
	}

	.darkmode .card-body span {
		color: #aaa;
	}
</style>