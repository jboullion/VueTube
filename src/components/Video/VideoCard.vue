<template>
	<div class="card video yt-video">
		<router-link :to="'/video/'+ video.youtube_id" class="card-img-back">
			<img loading="lazy" class="lazy" width="320" height="180" :src="'https://img.youtube.com/vi/'+ video.youtube_id+'/mqdefault.jpg'" style="">
			<i class="fas fa-play-circle"></i>
		</router-link>
		<div class="card-body">
			<router-link :to="'/channel/'+video.channel_youtube">
				<p class="ellipsis">{{ video.title }}</p>
			</router-link>
			<span class="date">{{ video.date }}</span>
		</div>
	</div>
</template>

<script>
export default {
	props: ['video'],
	data() {
		return {
			
		};
	},
	mounted(){
		console.log(this.video);
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
		width: 320px;
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
		width: 320px;
		height: 180px;
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
	}

	.card-body span {
		position: absolute;
		bottom: 10px;
		left: 10px;
		font-size: 14px;
	}

	.darkmode .card-body span {
		color: #aaa;
	}
</style>