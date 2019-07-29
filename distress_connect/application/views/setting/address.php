<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master Data</li>
        </ol>
    </nav>

    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs mb-3 custom-tab-nav" id="nav-tab" role="tablist">
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_one'): echo "active"; endif; ?>" id="nav-district-tab" data-toggle="tab" href="#nav-district" role="tab" aria-controls="nav-district" aria-selected="true">District</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_two'): echo "active"; endif; ?>" id="nav-block-tab" data-toggle="tab" href="#nav-block" role="tab" aria-controls="nav-block" aria-selected="false">Block</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_three'): echo "active"; endif; ?>" id="nav-gp-tab" data-toggle="tab" href="#nav-gp" role="tab" aria-controls="nav-gp" aria-selected="false">GP</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_four'): echo "active"; endif; ?>" id="nav-village-tab" data-toggle="tab" href="#nav-village" role="tab" aria-controls="nav-village" aria-selected="false">Village</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_one'): echo "show active"; endif; ?>" id="nav-district" role="tabpanel" aria-labelledby="nav-district-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Districts</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <!--colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup-->
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">District Name</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($districts)):
        								foreach($districts as $key=>$single_district):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_district['district_name']; ?></td>
                                            <td class="text-right"><a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-info update_form_link" data-action-name="DISTRICT" data-info='<?php echo trim(json_encode($single_district)); ?>'>Edit</a></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="district_panel_heading">Add District</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'district_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_district">
        					<input type="hidden" name="district_id" value="">
                            <div class="form-group">
                                <label for="district_name">District <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="district_name" name="district_name">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="DISTRICT">
                            <input type="submit" class="btn btn-primary" value="Add" id="district_button">
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_two'): echo "show active"; endif; ?>" id="nav-block" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Blocks</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <!--colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup-->
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">District Name</th>
                                    <th data-priority="3">Block Name</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($blocks)):
        								foreach($blocks as $key=>$single_block):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_block['district_name']; ?></td>
                                            <td><?php echo $single_block['block_name']; ?></td>
                                            <td class="text-right"><button class="btn btn-info btn-sm update_form_link" data-action-name="BLOCK" data-info='<?php echo trim(json_encode($single_block)); ?>'>Edit</button></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="block_panel_heading">Add Block</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'block_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_block">
                            <input type="hidden" name="block_id" value="">
                            <div class="form-group">
                                <label for="fk_district_id">District <span class="text-danger">*</span></label>
                                <select class="form-control" name="fk_district_id" id="fk_district_id">
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($address_master_options)):
            								foreach($address_master_options as $key=>$single_option_district):
            						?>
                                        <option value="<?php echo $single_option_district['district_id']; ?>" data-value="<?php echo json_encode($single_option_district); ?>"><?php echo $single_option_district['district_name']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="block_name">Block <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="block_name" name="block_name">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="BLOCK">
                            <input type="submit" class="btn btn-primary" value="Add" id="block_button">
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_three'): echo "show active"; endif; ?>" id="nav-gp" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All GPs</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <!--colgroup>
                                <col style="width:35pt">
                                <col style="width:100pt">
                                <col style="width:100pt">
                                <col style="width:100pt">
                                <col style="width:50pt">
                            </colgroup-->
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="5">District </th>
                                    <th data-priority="4">Block </th>
                                    <th data-priority="3">GP </th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($gps)):
        								foreach($gps as $key=>$single_gp):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_gp['district_name']; ?></td>
                                            <td><?php echo $single_gp['block_name']; ?></td>
                                            <td><?php echo $single_gp['gp_name']; ?></td>
                                            <td class="text-right"><button class="btn btn-info btn-sm update_form_link" data-action-name="GP" data-info='<?php echo trim(json_encode($single_gp)); ?>'>Edit</button></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="gp_panel_heading">Add GP</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'gp_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_gp">
                            <input type="hidden" name="gp_id" value="">
                            <div class="form-group">
                                <label for="fk_district_id">District <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="GP_DISTRICT" data-form-name="gp_form" name="fk_district_id" id="fk_district_id">
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($address_master_options)):
            								foreach($address_master_options as $key=>$single_option_district):
            						?>
                                        <option value="<?php echo $single_option_district['district_id']; ?>" data-value='<?php echo json_encode($single_option_district); ?>'><?php echo $single_option_district['district_name']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fk_block_id">Block <span class="text-danger">*</span></label>
                                <select class="form-control" name="fk_block_id" id="fk_block_id">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gp_name">GP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gp_name" name="gp_name">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="gp">
                            <input type="submit" class="btn btn-primary" value="Add" id="gp_button">
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_four'): echo "show active"; endif; ?>" id="nav-village" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Villages</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <!--colgroup>
                                <col style="width:35pt">
                                <col style="width:100pt">
                                <col style="width:100pt">
                                <col style="width:100pt">
                                <col style="width:100pt">
                                <col style="width:50pt">
                            </colgroup-->
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="6">District</th>
                                    <th data-priority="5">Block</th>
                                    <th data-priority="4">GP</th>
                                    <th data-priority="3">Village</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($villages)):
        								foreach($villages as $key=>$single_village):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_village['district_name']; ?></td>
                                            <td><?php echo $single_village['block_name']; ?></td>
                                            <td><?php echo $single_village['gp_name']; ?></td>
                                            <td><?php echo $single_village['village_name']; ?></td>
                                            <td class="text-right"><button class="btn btn-info btn-sm update_form_link" data-action-name="VILLAGE" data-info='<?php echo trim(json_encode($single_village)); ?>'>Edit</button></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="village_panel_heading">Add Village</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'village_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_village">
                            <input type="hidden" name="village_id" value="">
                            <div class="form-group">
                                <label for="fk_district_id">District <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="VILLAGE_DISTRICT" data-form-name="village_form" name="fk_district_id" id="fk_district_id">
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($address_master_options)):
            								foreach($address_master_options as $key=>$single_option_district):
            						?>
                                        <option value="<?php echo $single_option_district['district_id']; ?>" data-value='<?php echo json_encode($single_option_district); ?>'><?php echo $single_option_district['district_name']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fk_block_id">Block <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="VILLAGE_BLOCK" data-form-name="village_form"  name="fk_block_id" id="fk_block_id">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fk_gp_id">GP <span class="text-danger">*</span></label>
                                <select class="form-control" name="fk_gp_id" id="fk_gp_id">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="village_name">Village <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="village_name" name="village_name">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="VILLAGE">
                            <input type="submit" class="btn btn-primary" value="Add" id="village_button">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
