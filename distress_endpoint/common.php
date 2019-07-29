<?php include_once("header.php"); ?>
<?php include_once("increment_options.php"); ?>
		<div class="main-screen">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2>Information</h2>
						<hr>
						<form action="" method="POST">
							<input type="hidden" name="op" value="POST_NODE_COMMON_MESSAGE_DATA">
							<div class="form-group">
								<label for="death">How Many People Died</label>
								<select class="form-control" id="death" name="death" >
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="casualty">Human casulaities Number</label>
								<select class="form-control" id="casualty" name="casualty">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="house_damaged">Number of House Damaged</label>								
								<select class="form-control" id="house_damaged" name="house_damaged">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="is_road_blocked">Is Road Blocked</label>
								<select class="form-control" id="is_road_blocked" name="is_road_blocked">
									<option value="NO">NO</option>
									<option value="YES">YES</option>
								</select>
							</div>
							<div class="form-group">
								<label for="animal_death">Number of Animal Death</label>
								<select class="form-control" id="animal_death" name="animal_death">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="animal_casualty">Animal casulaities Number</label>
								<select class="form-control" id="animal_casualty" name="animal_casualty">
									<?php echo $increment_options; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="electric_pole_destroyed">Number of Electric Pole Destroyed</label>
								<select class="form-control" id="electric_pole_destroyed" name="electric_pole_destroyed">
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