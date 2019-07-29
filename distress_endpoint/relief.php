<?php include_once("header.php"); ?>
<?php include_once("increment_options.php"); ?>
		<div class="main-screen">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2>Support</h2>
						<hr>
						<form action="" method="POST">
							<input type="hidden" name="op" value="POST_NODE_RELIEF_MESSAGE_DATA">
							<div class="form-group">
								<label for="no_food_packet">No of Food Packets Required</label>
								<select class="form-control" id="no_food_packet" name="no_food_packet" >
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="no_drinking_water">Number of Drinking water packets</label>
								<select class="form-control" id="no_drinking_water" name="no_drinking_water">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="no_polythenes">Number of Polythenes</label>								
								<select class="form-control" id="no_polythenes" name="no_polythenes">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="is_rescue_required">Urgent rescue team required</label>
								<select class="form-control" id="is_rescue_required" name="is_rescue_required">
									<option value="NO">NO</option>
									<option value="YES">YES</option>
								</select>
							</div>
							<div class="form-group">
								<label for="no_airlift">Number of People need to rescued from location - Need Airlift</label>
								<select class="form-control" id="no_airlift" name="no_airlift">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="no_ndrf_personale">Please Send NDRF Personale (Number)</label>
								<select class="form-control" id="no_ndrf_personale" name="no_ndrf_personale">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="SEND">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php include_once("footer.php"); ?>