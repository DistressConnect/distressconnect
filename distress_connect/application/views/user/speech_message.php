<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Speech Messages</li>
        </ol>
    </nav>

    <div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h5>Speech Messages
			</div>
			<div class="card-body myspace">
				<?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
				<table class="table table-bordered table-striped table-hover table-sm dataTable display nowrap" style="width:100%">
					<thead>
						<tr>
							<th data-priority="1">#</th>
							<th data-priority="2">Node</th>
							<th data-priority="3">Message</th>
							<th data-priority="4">Play</th>
							<th data-priority="4" title="Using IBM Tone Analyzer (Model Accuracy Level will increase)">Tone Analyzer</th>
							<th data-priority="5">Posted On</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if(!empty($speech_msg_data)):
								foreach($speech_msg_data as $key=>$single_msg):
                                    $slno = $key + 1;
						?>
								<tr>
									<td class="text-center"><?php echo $slno; ?></td>
									<td><?php echo $single_msg['node_key']; ?></td>
									<td><?php echo $single_msg['speech_message']; ?></td>
									<td>
                                        <?php echo form_open(null, array('id'=>'new_speech_msg_form'.$slno)); ?>
                                            <input type="hidden" name="message" value="<?php echo $single_msg['speech_message']; ?>">
                                            <input type="submit" name="submit" value="Play">
                                        </form>
                                    </td>
                                    <td></td>
									<td><?php echo $single_msg['created_datetime']; ?></td>
								</tr>
						<?php
								endforeach;
							endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!--User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userDetailsModalLabel">User Info Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="user_details_modal_body">

			</div>
		</div>
	</div>
</div>
