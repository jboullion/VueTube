<template>
	<div class="row mt-4">
		<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
			<form class="form-inline row" method="get" action="">
				<div class="col-lg-4">
					<select name="topic" class="form-control">
						<option>Option 1</option>
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
				<div class="col-lg-4">
					<select name="focus" class="form-control">
						<option>Option 1</option>
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
				<div class="col-lg-4">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="Search" aria-label="search" name="s" value="" />
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

		};
	},
}
</script>

<style scoped>
	
</style>