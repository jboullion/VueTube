<template>
	<div id="add-channel">
		<h2>Add Channel</h2>
		<form  class="card" @submit.prevent="submitChannel">
			<div class="card-body">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" v-model.trim="channel.title" required>
				</div>

				<div class="form-group">
					<label for="youtube_id">Channel ID</label>
					<input type="text" class="form-control" id="youtube_id" name="youtube_id"  v-model.trim="channel.youtube_id" required>
				</div>

				<div class="form-group">
					<label for="facebook">Facebook</label>
					<input type="url" class="form-control" id="facebook" name="facebook"  v-model.trim="channel.facebook" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="instagram">Instagram</label>
					<input type="url" class="form-control" id="instagram" name="instagram"  v-model.trim="channel.instagram" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="patreon">Patreon</label>
					<input type="url" class="form-control" id="patreon" name="patreon"  v-model.trim="channel.patreon" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="tiktok">TikTok</label>
					<input type="url" class="form-control" id="tiktok" name="tiktok"  v-model.trim="channel.tiktok" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="twitter">Twitter</label>
					<input type="url" class="form-control" id="twitter" name="twitter"  v-model.trim="channel.twitter" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="twitch">Twitch</label>
					<input type="url" class="form-control" id="twitch" name="twitch"  v-model.trim="channel.twitch" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="website">Website</label>
					<input type="url" class="form-control" id="website" name="website"  v-model.trim="channel.website" placeholder="https://" />
				</div>

				<div class="form-group">
					<label for="style">Style</label>
					<select id="style" class="form-control" multiple v-model.trim="channel.styles">
						<option selected>Choose...</option>
						<option v-for="style in getStyles" :key="style.style_id" :value="style.style_id">{{ style.name }}</option>
					</select>
				</div>

				<div class="form-group">
					<label for="topic">Topic</label>
					<select id="topic" class="form-control" multiple v-model.trim="channel.topics">
						<option selected>Choose...</option>
						<option v-for="topic in getTopics" :key="topic.topic_id" :value="topic.topic_id">{{ topic.name }}</option>
					</select>
				</div>

				<!-- <div class="form-group">
					<label for="tags">Tags</label>
					<input type="text" class="form-control" id="tags" name="tags" v-model.trim="tags" placeholder="#example1,#example2" />
				</div> -->
			</div>
			<div class="card-footer">
				<div :class="{ error: errors.length }">
					<div class="input-errors" v-for="(error, index) of errors" :key="index">
						<div class="error-msg">{{ error }}</div>
					</div>
				</div>
				<base-button type="submit" class="btn btn-primary w-100">Add Channel</base-button>
				<LoadingIcon v-if="insertLoading" />
			</div>
		</form>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';

import BaseButton from '../UI/BaseButton.vue';
import LoadingIcon from '../UI/LoadingIcon.vue';

export default {
	inject: ['addChannel'],
	components: {
		BaseButton,
		LoadingIcon
	},
	data() {
		return {
			channel: {
				title: '',
				youtube_id: '',
				facebook: '',
				instagram: '',
				patreon: '',
				tiktok: '',
				twitter: '',
				twitch: '',
				website: '',
				//tags: '',
				styles: [],
				topics: [],
				focus: [],
			},
			inputIsInvalid: false,
			errors: [],
			insertLoading: false
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
			if(! this.channel.title || this.channel.title.length < 3){
				this.inputIsInvalid = true;
				this.errors.push("Title is Invalid");
			}

			if(! this.channel.youtube_id || this.channel.youtube_id.length < 5){
				this.inputIsInvalid = true;
				this.errors.push("Channel ID is Invalid");
			}

			if(this.channel.facebook && ! this.isValidUrl(this.channel.facebook)){
				this.inputIsInvalid = true;
				this.errors.push("Facebook is Invalid");
			}

			if(this.channel.instagram && ! this.isValidUrl(this.channel.instagram)){
				this.inputIsInvalid = true;
				this.errors.push("Instagram is Invalid");
			}

			if(this.channel.patreon && ! this.isValidUrl(this.channel.patreon)){
				this.inputIsInvalid = true;
				this.errors.push("Patreon is Invalid");
			}

			if(this.channel.tiktok && ! this.isValidUrl(this.channel.tiktok)){
				this.inputIsInvalid = true;
				this.errors.push("Tiktok is Invalid");
			}

			if(this.channel.twitter && ! this.isValidUrl(this.channel.twitter)){
				this.inputIsInvalid = true;
				this.errors.push("Twitter is Invalid");
			}

			if(this.channel.twitch && ! this.isValidUrl(this.channel.twitch)){
				this.inputIsInvalid = true;
				this.errors.push("Twitch is Invalid");
			}

			if(this.channel.website && ! this.isValidUrl(this.channel.website)){
				this.inputIsInvalid = true;
				this.errors.push("Website is Invalid");
			}
			
			this.insertLoading = true;

			fetch(process.env.VUE_APP_URL+'channel/add.php', {
				//mode: 'no-cors',
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({ channel: this.channel })
			})
			.then(response => response.json())
			.then(data => {
				this.insertLoading = false;
				if(data.channel_id){
					this.channel.channel_id = data.channel_id;
				}
			})
			.catch(error => {
				this.insertLoading = false;
				this.errorMessage = error;
				console.error('There was an error!', error);
			});

		},
		confirmError(){
			this.inputIsInvalid = false;
		}
	}
}
</script>

<style scoped>
	.darkmode .loading-icon {
		color: #111111;
	}
</style>