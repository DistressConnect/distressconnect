<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
        </ol>
    </nav>

    <div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h5>Users
				<?php
					if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "USER", "operation_name", "CREATE_USER", $this->session->userdata('role')) == 1):
				?>
                    <a href="javascript:void(0)" class="btn btn-raised btn-primary btn-sm float-sm-right reset-default-form"  data-reset-default="USER" data-toggle="modal" data-target="#userAddModal"><i class="fa fa-plus"></i> Add User</a>
				<?php endif; ?>
				</h5>
			</div>
			<div class="card-body myspace">
				<?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
				<table class="table table-bordered table-striped table-hover table-sm dataTable display nowrap" style="width:100%">
					<!--colgroup>
						<col style="width:35pt">
						<col style="width:150pt">
						<col style="width:150pt">
						<col style="width:150pt">
						<col style="width:100pt">
						<col style="width:100pt">
						<col style="width:25pt">
					</colgroup-->
					<thead>
						<tr>
							<th data-priority="1">#</th>
							<th data-priority="2">Full Name</th>
							<th data-priority="7">Email</th>
							<th data-priority="6">Phone</th>
							<th data-priority="4">Role</th>
							<th data-priority="4">Latitude</th>
							<th data-priority="4">Longitude</th>
							<th data-priority="4">pincode</th>
							<th data-priority="5">Status</th>
							<th data-priority="6">Sensor Data</th>
							<th class="text-right" data-priority="3"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							if(!empty($all_user)):
								foreach($all_user as $key=>$single_user):
                                    $slno = $key + 1;
									if($single_user['user_id'] == 1)
										break;
						?>
								<tr>
									<td class="text-center"><?php echo $slno; ?></td>
									<td><?php echo $single_user['fullname']; ?></td>
									<td><?php echo $single_user['email']; ?></td>
									<td><?php echo $single_user['phone']; ?></td>
									<td><?php echo $single_user['role']; ?></td>
									<td><?php echo $single_user['latitude']; ?></td>
									<td><?php echo $single_user['longitude']; ?></td>
									<td><?php echo $single_user['pincode']; ?></td>
									<td><?php echo ($single_user['status'] == 1) ? "Active" : "Inactive"; ?></td>
                                    <td><a title="View Details" href="javascript:void(0)" class="sensor_data" data-action-name="USER" data-info='<?php echo trim(json_encode($single_user)); ?>'>View</a></td>
									<td class="text-right">
                                        <div class="dropdown mr-1">
                                            <button type="button" class="kebab-menu" id="dropdownMenu<?php echo $slno; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Options">
                                            <figure></figure><figure></figure><figure></figure>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu<?php echo $slno; ?>">
												<?php
													if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "USER", "operation_name", "DISPLAY_USER", $this->session->userdata('role')) == 1):
												?>
                                                <a title="View Details" href="javascript:void(0)" class="dropdown-item display_details" data-action-name="USER" data-info='<?php echo trim(json_encode($single_user)); ?>'>View</a>
												<?php endif; ?>
												<?php
													if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "USER", "operation_name", "EDIT_USER", $this->session->userdata('role')) == 1):
												?>
                                                <a href="javascript:void(0)" title="Edit User" class="dropdown-item update_form_link" data-action-name="USER" data-info='<?php echo trim(json_encode($single_user)); ?>'>Edit User</a>
												<?php endif; ?>
												<?php
													if(searchPermissionArray($this->session->userdata('role_permission'), "module_name", "USER", "operation_name", "DELETE_USER", $this->session->userdata('role')) == 1):
												?>
        										<a href="<?php echo site_url('user/users/delete_user/'.$single_user['user_id']); ?>" title="Delete" class="dropdown-item perform_action_warning" data-category-type='delete_user'>Delete</a>
												<?php endif; ?>
												<?php
													if($single_user['role'] == "node"):
												?>
												<a href="<?php echo site_url('user/users/add_to_dcu/'.$single_user['user_id']); ?>" title="Add To Dcu" class="dropdown-item">Add To Dcu</a>
												<?php endif; ?>
												<?php
													if($single_user['role'] == "dcu"):
												?>
												<a href="<?php echo site_url('user/users/add_to_cdcu/'.$single_user['user_id']); ?>" title="Add To Cdcu" class="dropdown-item">Add To Cdcu</a>
												<?php endif; ?>
                                            </div>
                                        </div>
									</td>
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


<!--User Add Modal -->
<div class="modal fade" id="userAddModal" tabindex="-1" role="dialog" aria-labelledby="userAddModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="user_panel_heading">Add User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo form_open(null, array('id'=>'new_user_form')); ?>
					<input type="hidden" name="op" value="add">
					<input type="hidden" name="user_id" value="">
					<div class="form-group">
						<label>Full Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="fullname" placeholder="">
					</div>
					<div class="form-group">
						<label>Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control" name="email" placeholder="">
					</div>
					<div class="form-group">
						<label>Phone Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="phone" placeholder="">
					</div>
					<div class="row">
                        <div class="col-sm-6">
							<div class="form-group">
								<label>Latitude <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="latitude" placeholder="">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Longitude <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="longitude" placeholder="">
							</div>
						</div>
					</div>
					<div class="row">
                        <div class="col-sm-6">
							<div class="form-group">
								<label>Pincode <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="pincode" placeholder="">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Passkey <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="passkey" placeholder="">
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-sm-6">
        					<div class="form-group">
        						<label>Status</label>
        						<select class="form-control" id="status" name="status">
        							<option value="1">Active</option>
        							<option value="0">Inactive</option>
        						</select>
        					</div>
    					</div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="form-control" id="role" name="role">
                                    <option value="">Select</option>

        							<?php
        								if(!empty($all_roles)):
        									foreach($all_roles as $single_role):
        										echo "<option value=".$single_role['role_id'].">".$single_role['description']."</option>";
        									endforeach;
        								endif;
        							?>
                                </select>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<input type="reset"  class="btn btn-dark" id="edit_user_reset_btn" value="Reset">
						<input type="submit" class="btn btn-primary" id="user_button" data-form-name="new_user_form" value="Create">
					</div>
				</form>
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

<!--Sensor Data Modal -->
<div class="modal fade" id="userSensorDataModal" tabindex="-1" role="dialog" aria-labelledby="userSensorDataModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userSensorDataModalLabel">Sensor Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="user_sensor_data_modal_body">

			</div>
		</div>
	</div>
</div>
