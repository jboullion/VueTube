<template>
	<base-dialog v-if="inputIsInvalid" title="Invalid Input" @close="confirmError()">
		<template #default>
			<p>An input value is invalid</p>
		</template>
		<!-- <template #actions>
			<base-button @click="confirmError()" class="btn btn-primary">OK</base-button>
		</template> -->
	</base-dialog>
	<div id="add-channel">
		<h2>Add Channel</h2>
		<form  class="card" @submit.prevent="submitChannel">
			<div class="card-body">

				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" v-model.trim="title" >
				</div>

				<!-- <div v-for="input in inputs" :key="input.name">
					<BaseInput :title="inputObj.title" :name="inputObj.name" :type="input.type"  v-model="input.value"></BaseInput>
				</div> -->
				
				<!-- <BaseInput :title="'Title'" :name="'title'"  v-model="title"></BaseInput> -->

				<div class="form-group">
					<label for="channel_id">Channel ID</label>
					<input type="text" class="form-control" id="channel_id" name="channel_id"  v-model.trim="channel_id">
				</div>

				<!-- <div class="form-group">
					<label for="facebook">Facebook</label>
					<input type="text" class="form-control" id="facebook" name="facebook" ref="titleInput" >
				</div> -->

				<!-- <div class="form-group">
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
					<label for="type">Type</label>
					<select id="type" class="form-control" ref="typeInput">
						<option selected>Choose...</option>
						<option>Explainer</option>
						<option>Demonstration</option>
						<option>Interviews</option>
						<option>Podcast</option>
						<option>Professional</option>
						<option>Reviews</option>
						<option>Tutoirals</option>
						<option>Vlog</option>
					</select>
				</div>

				<div class="form-group">
					<label for="genre">Genre</label>
					<select id="genre" class="form-control" multiple ref="genreInput">
						<option selected>Choose...</option>
						<option>Art</option>
						<option>Comedy</option>
						<option>Food</option>
						<option>Gaming</option>
						<option>News</option>
						<option>Money</option>
						<option>Movies</option>
						<option>Science</option>
						<option>Philosophy</option>
						<option>Politics</option>
						<option>Technology</option>
					</select>
				</div>

				<div class="form-group">
					<label for="tags">Tags</label>
					<input type="text" class="form-control" id="tags" name="tags" ref="tagsInput"/>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="form-control" ref="descriptionInput">
					</textarea>
				</div> -->
			</div>
			<div class="card-footer">
				<!-- <div :class="{ error: v$.name.$errors.length }">
					<input v-model="name">
					<div class="input-errors" v-for="(error, index) of v$.name.$errors">
						<div class="error-msg">{{ error.$message }}</div>
					</div>
				</div> -->
				<base-button type="submit" class="btn btn-primary w-100">Add Channel</base-button>
			</div>
		</form>
	</div>
</template>

<script>
import BaseButton from '../UI/BaseButton.vue';
// import BaseInput from '../UI/BaseInput.vue';
//import BaseDialog from '../UI/BaseDialog.vue';
 
// import { required, maxLength  } from '@vuelidate/validators'

export default {
	inject: [ 'addChannel'], // 'channels',
	components: {
		BaseButton,
		//BaseInput
		//BaseDialog
	},
	data() {
		return {
			title: '',
			channel_id: '',
			inputIsInvalid: false,
			// inputs: [
			// 	{
			// 		title: 'Title',
			// 		name: 'title',
			// 		type: BaseInput,
			// 		value: '',
			// 		errors: []
			// 	},
			// 	{
			// 		title: 'Gescription',
			// 		name: 'description',
			// 		type: 'textarea',
			// 		value: '',
			// 		errors: []
			// 	},
			// 	{
			// 		title: 'Genre',
			// 		name: 'genre',
			// 		type: 'select',
			// 		value: '',
			// 		errors: []
			// 	}
			// ]
		};
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
			// console.log('title: '+this.title);
			// console.log(this.title);
			// //console.log(this.$v.$error);
			// console.log(this.$v.title.$errors);
			
			// if(this.$v.$error) return

			if(! this.title || this.title.length < 3){
				this.inputIsInvalid = true;
				return;
			}

			if(! this.channel_id || this.channel_id.length < 5){
				this.inputIsInvalid = true;
				return;
			}

			this.addChannel(this.title, this.channel_id); // enteredWebsite
		},
		confirmError(){
			this.inputIsInvalid = false;
		}
	}
}
</script>

<style scoped>

</style>