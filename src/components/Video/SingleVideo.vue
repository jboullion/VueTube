<template>
	<a href="#" class="card video h-100 yt-video">
		<div class="card-img-back">
			<img loading="lazy" class="lazy" width="320" height="180" :src="'https://img.youtube.com/vi/'+video.video_id+'/mqdefault.jpg'" style="">
			<i class="fas fa-play-circle"></i>
		</div>
		<div class="card-body">
			<p class="ellipsis">{{ video.title }}</p>
			<span class="date">{{ video.date }}</span>
		</div>
	</a>
</template>

<script>
export default {
	props: ['video'],
	data() {
		return {
			
		};
	}
}
</script>

<style scoped>
	.card.video {
		border: 0;
		background-color: transparent;
		display: block;
		transition: background-color 0.1s;
		width: 320px;
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
		color: white;
		opacity: 0;
		box-shadow: 0px 0px 5px 3px rgba(0,0,0,0.25);
		transition: opacity 0.1s linear;
		width: 74px;
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
</style>