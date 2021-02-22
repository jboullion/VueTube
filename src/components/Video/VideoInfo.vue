<template>
	<div class="video-info">
		<div v-if="tags" class="tags">
			<span v-for="tag in tags" :key="tag">{{ tag }}</span>
		</div>
		<h3>{{ video.title }}</h3>
		<p>{{ videoDate }}</p>
		<div class="video-actions">
			<WatchLater :video="video" />
			<LikedIcon :video="video" />
		</div>
		<div class="video-description" v-html="video.content"></div>
	</div>
</template>


<script>
import { useToast } from "vue-toastification";

import moment from 'moment'

import LikedIcon from '../UI/LikedIcon.vue';
import WatchLater from '../UI/WatchLater.vue';


export default {
	props: ['video'],
	components: {
		LikedIcon,
		WatchLater
	},
	data() {
		return {
			showUserError: false,
			tags: '',
			toast: null,
		};
	},
	created() {
		this.tags = this.video.tags?this.video.tags.split(','):'';
		
		this.videoDate = moment(this.video.date).format('MMM D, YYYY');

		this.toast = useToast();
	},
	methods: {
		confirmError(){
			this.showUserError = false;
		}
	}
}
</script>

<style scoped>
	.video-info {
		border-bottom: 1px solid #ccc;
		margin: 15px 0;
		padding-bottom: 15px;
		position: relative;
		padding-right: 80px;
	}

	.video-actions {
		font-size: 24px;
		position: absolute;
		top: 0;
		right: 15px;
	}

	.video-actions i {
		cursor: pointer;
		transition: color 0.2s linear;
		margin-left: 15px;
	}

	.tags span {
		color: var(--bs-blue);
		margin-right: 10px;
	}

	@media (max-width: 1199px) {
		.video-info {
			padding: 0 90px 15px 15px;
		}
		
		.video-actions {
			line-height: 1;
		}
	}
</style>