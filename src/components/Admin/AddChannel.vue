<template>
	<div id="add-channel">
		<h2>Add Channel</h2>
		<form  class="card" @submit.prevent="submitChannel">
			<div class="card-body">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" v-model.trim="title" >
				</div>

				<div class="form-group">
					<label for="youtube_id">Channel ID</label>
					<input type="text" class="form-control" id="youtube_id" name="youtube_id"  v-model.trim="youtube_id">
				</div>

				<div class="form-group">
					<label for="facebook">Facebook</label>
					<input type="text" class="form-control" id="facebook" name="facebook" ref="titleInput" >
				</div>

				<div class="form-group">
					<label for="instagram">Instagram</label>
					<input type="text" class="form-control" id="instagram" name="instagram" ref="instagramInput">
				</div>

				<div class="form-group">
					<label for="patreon">Patreon</label>
					<input type="text" class="form-control" id="patreon" name="patreon" ref="patreonInput">
				</div>

				<div class="form-group">
					<label for="tiktok">TikTok</label>
					<input type="text" class="form-control" id="tiktok" name="tiktok" ref="tiktokInput">
				</div>

				<div class="form-group">
					<label for="twitter">Twitter</label>
					<input type="text" class="form-control" id="twitter" name="twitter" ref="twitterInput">
				</div>

				<div class="form-group">
					<label for="twitch">Twitch</label>
					<input type="text" class="form-control" id="twitch" name="twitch" ref="twitchInput">
				</div>

				<div class="form-group">
					<label for="website">Website</label>
					<input type="text" class="form-control" id="website" name="website" ref="websiteInput">
				</div>

				<div class="form-group">
					<label for="style">Style</label>
					<select id="style" class="form-control" ref="styleInput">
						<option selected>Choose...</option>
						<option v-for="style in getStyles" :key="style.style_id" :value="style.style_id">{{ style.name }}</option>
					</select>
				</div>

				<div class="form-group">
					<label for="topic">Topic</label>
					<select id="topic" class="form-control" ref="topicInput">
						<option selected>Choose...</option>
						<option v-for="topic in getTopics" :key="topic.topic_id" :value="topic.topic_id">{{ topic.name }}</option>
					</select>
				</div>

				<div class="form-group">
					<label for="tags">Tags</label>
					<input type="text" class="form-control" id="tags" name="tags" ref="tagsInput"/>
				</div>
			</div>
			<div class="card-footer">
				<div :class="{ error: errors.length }">
					<div class="input-errors" v-for="(error, index) of errors" :key="index">
						<div class="error-msg">{{ error }}</div>
					</div>
				</div>
				<base-button type="submit" class="btn btn-primary w-100">Add Channel</base-button>
			</div>
		</form>
	</div>
	<ChannelCard v-if="channel" :channel="channel" />
</template>

<script>
import { mapGetters } from 'vuex';

import BaseButton from '../UI/BaseButton.vue';

import ChannelCard from '../Channel/ChannelCard';

export default {
	inject: ['addChannel'],
	components: {
		BaseButton,
		ChannelCard
	},
	data() {
		return {
			title: '',
			youtube_id: '',
			inputIsInvalid: false,
			channel: {},
			errors: [],
			styles: [],
			topics: [],
			focus: [],
		};
	},
	computed: {
		...mapGetters(["getStyles", "getTopics"])
	},
	created(){

	},
	// validations () {
	// 	return {
	// 		title: { required }, // Matches this.title
	// 		//lastName: { required }, // Matches this.lastName
	// 		// contact: {
	// 		// 	email: { required, email } // Matches this.contact.email
	// 		// }
	// 	}
	// },
	methods: {
		submitChannel(){
			if(! this.title || this.title.length < 3){
				this.inputIsInvalid = true;
				return;
			}

			if(! this.youtube_id || this.youtube_id.length < 5){
				this.inputIsInvalid = true;
				return;
			}

			this.addChannel(this.title, this.youtube_id); // enteredWebsite

			fetch(process.env.VUE_APP_URL+'channel/add.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ title: this.title, youtube_id: this.youtube_id })
			})
			.then(response => response.json())
			.then(data => {
				if(data.channel_id){
					this.channel.channel_id = data.channel_id;
				}
			})
			.catch(error => {
				this.errorMessage = error;
				console.error('There was an error!', error);
			});
			// description: ['description'],
			// img_url => $channel_img,
			// facebook: ['facebook'],
			// instagram: ['instagram'],
			// patreon: ['patreon'],
			// tiktok: ['tiktok'],
			// twitter: ['twitter'],
			// twitch: ['twitch'],
			// website: ['website'],
			// tags: ['tags'],
		},
		confirmError(){
			this.inputIsInvalid = false;
		}
	}
}
</script>

<style scoped>

</style>