<template>
	<div class="row mt-4">
		<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
			<form class="form-inline d-flex" method="get" action="" @submit.prevent="searchChannels()">
				<div class="form-flex">
					<div class="mt-style">
						<select name="type" class="form-control" @change="searchChannels()">
							<option value="">Type</option>
							<option value="channel">Channel</option>
							<option value="video">Video</option>
							<!-- <?php 
								foreach( $subsites as $subsite ) {
									//jb_print($subsite);
									if($subsite->blog_id == 1) continue;
									$subsite_details = get_blog_details($subsite->blog_id);
									echo '<option value="http://'.$subsite->domain.'" '.($current_blog_id == $subsite->blog_id?'selected="selected"':'').'>'.$subsite_details->blogname.'</option>';
								}
							?> -->
						</select>
					</div>
				</div>
				<div class="form-flex">
					<div class="mt-style">
						<select name="topic" class="form-control" @change="searchChannels()">
							<option value="">Topic</option>
							<option value="1">Space</option>
							<option value="2">Phyisics</option>
							<option value="3">Math</option>
							<option value="4">AI</option>
							<!-- <?php 
								foreach( $subsites as $subsite ) {
									//jb_print($subsite);
									if($subsite->blog_id == 1) continue;
									$subsite_details = get_blog_details($subsite->blog_id);
									echo '<option value="http://'.$subsite->domain.'" '.($current_blog_id == $subsite->blog_id?'selected="selected"':'').'>'.$subsite_details->blogname.'</option>';
								}
							?> -->
						</select>
					</div>
				</div>
				<div class="form-flex">
					<div class="mt-style">
						<select name="style" class="form-control"  @change="searchChannels()">
							<option value="">Style</option>
							<option value="1">Explainer</option>
							<option value="2">Interview</option>
							<option value="3">Podcast</option>
							<option value="4">Review</option>
							<option value="5">Wonder</option>
							<!-- <?php 
								if(! empty($focuses)){
									foreach($focuses as $focus){
										// /focus/tech/
										echo '<option value="'.$focus->term_id.'" '.($focus_id == $focus->term_id?'selected="selected"':'').'>'.$focus->name.'</option>';
									}
								}
							?> -->
						</select>
					</div>
				</div>
				<div class="form-flex form-flex-2">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search" aria-label="search" name="s" v-model.trim="search" @change="searchChannels()" />
						<div class="input-group-append">
							<i class="fas fa-search" @click="searchChannels()"></i>
						</div>
					</div>
				</div>
				<!-- <div class="col-md-6 col-lg-5th mb-3">
					<button type="button" class="active btn btn-primary" name="order" value=""><span>Title</span></button>
				</div> -->
				<!-- <div class="col-lg-3">
					<button type="submit" class="active btn btn-primary" name="find" value="1"><span>Find</span></button>
				</div> -->
			</form>
		
		</div>
	</div>
</template>


<script>

export default {
	props: [],
	components: {
		
	},
	data() {
		return {
			channelsLoading: false,
			channelsPage: 0,
			channels: [],
			search: ''
		};
	},
	mounted(){

	},
	methods: {
		searchChannels(){

			this.channelsLoading = true;
			
			let searchString = '?';

			if(this.order){
				searchString += '&offset='+this.channelsPage+'&order='+this.order;
			}else{
				searchString += '&orderby=title&order=asc';
			}

			if(this.search){
				searchString += '&s='+this.search;
			}

			if(this.style){
				searchString += '&style='+this.style;
			}

			if(this.topic){
				searchString += '&topic='+this.topic;
			}
			

			fetch('http://science.narrative.local/api/channel/search.php'+searchString, {
				//mode: 'no-cors',
				method: 'GET',
				headers: { 'Content-Type': 'application/json' }
			})
			.then(response => {
				if(response.ok){
					this.channelsPage++;
					return response.json();
				}
			})
			.then(data => { 
				this.channelsLoading = false;

				this.$store.dispatch('updateChannels', data);

			})
			.catch(error => {
				//this.errorMessage = error;
				this.channelsLoading = false;
				console.error('There was an error!', error);
			});
		},
		// queryUpdate() {
		// 	this.$router.push({
		// 		name: 'Home',
		// 		query: {
		// 			order: 'asc',
		// 			search: 'search',
		// 			style: '',
		// 			topic: ''
		// 		}
		// 	});
		// }
	}
}
</script>

<style scoped>

	.btn {
		display: inline-block;
		width: 110px;
	}
	
	.btn svg {
		margin-right: 10px;
		width: 19px;
		margin-top: -2px;
		display: inline-block;
	}

	.btn span {
		font-weight: bold;
		display: inline-block;
	}

	.input-group {
		flex: 1;
		margin: 0;
	}

	.input-group-append {
		background-color: #272729;
		color: #818384;
		padding: 0 20px;
		line-height: 38px;
		cursor: pointer;
	}

	.form-flex {
		height: 100%;
		padding: 0 5px;
		flex: 1;
	}

	.form-flex-2 {
		flex: 0 1 35%;
		width: 35%;
	}

	/* .input-group .input-group-text {
		// background-color: white
	} */

	.mt-style {
		position: relative;
	}

	.mt-style:before { 
		content:'\f0dd';
		color: #dedede; 
		font-size: 16px; 
		font-weight: bold;
		line-height:1; 
		font-family: "Font Awesome 5 Free"; 
		pointer-events: none; 
		position: absolute; 
		right: 10px;
		top: 7px;
		z-index:1;
	}

	.input-group svg {
		width: 18px;
		color: black;
	}

	.form-control {
		background-color: #606060;
		border: 0;
		color: #fefefe;
	}

	.form-control::placeholder {
		color: #dedede;
	}

	.input-group .form-control {
		height: auto;
	}


	@media (max-width: 1199px) {

		form.form-inline {
			flex-wrap: wrap;
		}

		.form-flex,
		.form-flex-2 {
			flex: 0 1 50%;
			width: 50%;
			margin-bottom: 10px
		}

	}
</style>