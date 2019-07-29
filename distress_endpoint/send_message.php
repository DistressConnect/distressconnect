<?php include_once("header.php"); ?>
<?php include_once("increment_options.php"); ?>
		<div class="main-screen">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2>Send Message</h2>
						<hr>
						<form action="data_service.php" method="POST">
							<input type="hidden" name="op" value="SEND_MESSAGE_TO_ADMIN">
							<div class="form-group">
								<label for="node_message">Message</label>
								<input type="text" class="form-control" id="node_message" name="node_message" required />
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