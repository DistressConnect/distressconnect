<!-- Main content -->
<section class="myscreen">
	<div class="container">
		<div class="card">
			<div class="card-header"><h5>My Profile <a href="<?php echo site_url('user/profile'); ?>" class="btn btn-raised btn-primary btn-sm float-sm-right"><i class="fa fa-edit"></i> Edit</a></h5></div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-2">
						<div class="dp-holder" style="background-image:url(<?php echo base_url() .'public/uploads/users/'.$user_data['photo']; ?>); background-position:center; background-size:cover;"></div>
					</div>
					<div class="col-sm-10">
						<div class="row grey-50 pt-2">
							<div class="col-sm-4">
								<label>Full Name : </label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['fullname']; ?>
							</div>
							<div class="col-sm-4">
								<label>Email</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['email']; ?>
							</div>
							<div class="col-sm-4">
								<label>Date of Birth</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['dob']; ?>
							</div>
							<div class="col-sm-4">
								<label>Class</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['class_name']; ?>
							</div>
							<div class="col-sm-4">
								<label>Branch</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['branch_name']; ?>
							</div>
							<div class="col-sm-4">
								<label>Service No.</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['service_no']; ?>
							</div>
							<div class="col-sm-4">
								<label>Suffix</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['off_suffix'];?>
							</div>
							<div class="col-sm-4">
								<label>Join Date</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['entry_date_to_navy']; ?>
							</div>
							<div class="col-sm-4">
								<label>Discharge Date</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['date_of_retirement']; ?>
							</div>
							<div class="col-sm-4">
								<label>Last Rank</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['last_rank']; ?>
							</div>
							<div class="col-sm-4">
								<label>Job Title</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['title_curr_last']; ?>
							</div>
							<div class="col-sm-4">
								<label>Organization</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['org_curr_last']; ?>
							</div>
						</div>
						<div class="row pt-2">
							<div class="col-sm-4">
								<label>Wife Name</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['spouse_name']; ?>
							</div>
							<div class="col-sm-4">
								<label>Wife's DOB</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['spouse_dob']; ?>
							</div>
							<div class="col-sm-4">
								<label>Wife Mobile no</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['spouse_mobile_no']; ?>
							</div>
							<div class="col-sm-4">
								<!--<input type="checkbox" class="form-check-input" id="is_demised_spouse" name="is_demised_spouse">-->
								<label for="is_demised_spouse" class="form-check-label">Wife Demised :</label>
							</div>
							<div class="col-sm-8">
								<?php echo ($user_data['is_demised_spouse'] == 1) ? "YES" : "NO"; ?>
							</div>
						<?php if($user_data['is_demised_spouse'] == 1): ?>
							<div class="col-sm-4">
								<label>Wife Demised Date</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['spouse_demise_date']; ?>
							</div>
						<?php endif; ?>
							<div class="col-sm-4">
								<label>No of Son</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['no_of_son']; ?>
							</div>
							<div class="col-sm-4">
								<label>No of Daughter</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['no_of_daughter']; ?>
							</div>
							<div class="col-sm-4">
								<label>Residing City</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['res_city']; ?>
							</div>
						</div>
						<div class="row grey-50 pt-2">
							<div class="col-sm-4">
								<label>ISD-Code</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['phone_no_country_code']; ?>
							</div>
							<div class="col-sm-4">
								<label>STD-Code</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['phone_no_area_code']; ?>
							</div>
							<div class="col-sm-4">
								<label>Land Phone</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['contact_no_one']; ?>
							</div>
							<div class="col-sm-4">
								<label>Mobile-ISD</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['mobile_no_country_code']; ?>
							</div>
							<div class="col-sm-4">
								<label>Mobile</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['contact_no_two']; ?>
							</div>
							<div class="col-sm-4">
								<label>Whatsapp</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['contact_no_three']; ?>
							</div>
						</div>
						<div class="row pt-2">
							<div class="col-sm-4">
								<label>Office address</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['address_line_one']; ?>
								<?php echo $user_data['address_line_two']; ?>
								<?php echo $user_data['address_line_three']; ?>
							</div>
							<div class="col-sm-4">
								<label>Present address</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['present_address']; ?>
								<?php echo $user_data['present_zip']; ?>
							</div>
							<div class="col-sm-4">
								<label>Permanent address</label>
							</div>
							<div class="col-sm-8">
								<?php echo $user_data['permanent_address']; ?>
								<?php echo $user_data['per_zip']; ?>
							</div>
						</div>
						<div class="row grey-50 pt-2">
							<div class="col-sm-4">
								<label>Account Locked</label>
							</div>
							<div class="col-sm-8">
								<?php
									if($user_data['acct_lock'] == 1){
										echo ("Yes");
									}elseif ($user_data['acct_lock'] == 0) {
											echo ("No");
										}
								 ?>
							</div>
							<div class="col-sm-4">
								<label>Last Logged In</label>
							</div>
							<div class="col-sm-8">
								<?php echo date('Y-m-d', $user_data['last_login']); ?>
							</div>
							<div class="col-sm-4">
								<label>Profile Last Updated</label>
							</div>
							<div class="col-sm-8">
								<?php echo date('Y-m-d', $user_data['updated_on']); ?>
							</div>
							<div class="col-sm-4">
								<label>Member Since</label>
							</div>
							<div class="col-sm-8">
								<?php echo date('Y-m-d', $user_data['created_on']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
