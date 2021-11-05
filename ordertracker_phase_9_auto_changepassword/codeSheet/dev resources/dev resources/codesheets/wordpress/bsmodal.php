<!-- put this code in external stylesheet to avoid conflict  -->
<style type="text/css">

	.modal-header {
		background-color: #007bff;
		min-height: 50px;
	}

	.modal-body {
		padding: 18px;
	}

	.modal-body img {
		float: left;
		margin-right: 20px;
	}

	.modal-body h5 {
		font-size: 18px;
		font-weight: 600;
		margin-bottom: 10px;
	}

	.modal-body p {
		text-align: justify;
	}

	/*modal scroll/padding fix*/
	#order-details-modal.modal {
		overflow-y: auto;
	}

	body.modal-open {
		width: 100% !important;
		padding-right: 0 !important;
		overflow-y: scroll !important;
	}

</style>

<?php
function action_name1() {

	$id = $_POST['id'];

	$args = array(
		'post_type' => 'program',
		'post__in' => array($id)
		);

	$posts = get_posts($args);
	?>

	
	<div class="modal fade" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered" role="document" >
			<div class="modal-content">
				<div class="modal-header"></div>
				<div class="modal-body">
					<img src="<?php echo get_field('field_5b45678bce9b1', $id); ?>" width="200" height="auto">
					<h5><?php echo $posts[0]->post_title; ?></h5>
					<p><?php echo $posts[0]->post_excerpt; ?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="closeModal()">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function closeModal() {
			jQuery('#details-modal').modal('hide');
			setTimeout(function() {
				jQuery('#details-modal').remove();
				jQuery('.modal-backdrop').remove();
			},500);
		}
	</script>

	<?php

	die();
}
add_action('wp_ajax_action_name1', 'action_name1');
add_action('wp_ajax_nopriv_action_name1', 'action_name1');
