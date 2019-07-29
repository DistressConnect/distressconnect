<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Configuration</li>
        </ol>
    </nav>

    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs mb-3 custom-tab-nav" id="nav-tab" role="tablist">
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_one'): echo "active"; endif; ?>" id="nav-disaster-type-tab" data-toggle="tab" href="#nav-disaster-type" role="tab" aria-controls="nav-disaster-type" aria-selected="true">Disaster Type</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_two'): echo "active"; endif; ?>" id="nav-disaster-message-tab" data-toggle="tab" href="#nav-disaster-message" role="tab" aria-controls="nav-disaster-message" aria-selected="false">Disaster Message</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_three'): echo "active"; endif; ?>" id="nav-alert-type-tab" data-toggle="tab" href="#nav-alert-type" role="tab" aria-controls="nav-disaster-alert-type" aria-selected="false">Alert Type</a>
                <a class="nav-item nav-link <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_four'): echo "active"; endif; ?>" id="nav-alert-message-tab" data-toggle="tab" href="#nav-alert-message" role="tab" aria-controls="nav-alert-message" aria-selected="false">Alert Message</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_one'): echo "show active"; endif; ?>" id="nav-disaster-type" role="tabpanel" aria-labelledby="nav-disaster-type-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Disaster Type</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup>
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Disaster Type</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($disaster_type)):
        								foreach($disaster_type as $key=>$single_disaster_type):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_disaster_type['disaster_type']; ?></td>
                                            <td class="text-right"><a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-info update_form_link" data-action-name="DISASTER_TYPE" data-info='<?php echo trim(json_encode($single_disaster_type)); ?>'>Edit</a></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="disaster_type_panel_heading">Add Disaster Type</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'disaster_type_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_disaster_type">
        					<input type="hidden" name="disaster_type_id" value="">
                            <div class="form-group">
                                <label for="disaster_type">Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="disaster_type" name="disaster_type">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="DISASTER_TYPE">
                            <input type="submit" class="btn btn-primary" value="Add" id="disaster_type_button">
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_two'): echo "show active"; endif; ?>" id="nav-disaster-message" role="tabpanel" aria-labelledby="nav-disaster-message-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Disaster Message</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup>
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">Disaster Type</th>
                                    <th data-priority="3">Disaster Message</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($disaster_message)):
        								foreach($disaster_message as $key=>$single_disaster_message):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_disaster_message['disaster_type']; ?></td>
                                            <td><?php echo $single_disaster_message['disaster_message']; ?></td>
                                            <td class="text-right"><button class="btn btn-info btn-sm update_form_link" data-action-name="DISASTER_MESSAGE" data-info='<?php echo trim(json_encode($single_disaster_message)); ?>'>Edit</button></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="disaster_message_panel_heading">Add Disaster Message</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'disaster_message_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_disaster_message">
                            <input type="hidden" name="disaster_message_id" value="">
                            <div class="form-group">
                                <label for="fk_disaster_type_id">Disaster Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="fk_disaster_type_id" id="fk_disaster_type_id">
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($disaster_type)):
            								foreach($disaster_type as $key=>$single_disaster_type):
            						?>
                                        <option value="<?php echo $single_disaster_type['disaster_type_id']; ?>"><?php echo $single_disaster_type['disaster_type']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="disaster_message">Message <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="disaster_message" name="disaster_message">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="DISASTER_MESSAGE">
                            <input type="submit" class="btn btn-primary" value="Add" id="disaster_message_button">
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_three'): echo "show active"; endif; ?>" id="nav-alert-type" role="tabpanel" aria-labelledby="nav-alert-type-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Disaster Type</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup>
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="2">Alert Type</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($alert_type)):
        								foreach($alert_type as $key=>$single_alert_type):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_alert_type['alert_type']; ?></td>
                                            <td class="text-right"><a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-info update_form_link" data-action-name="ALERT_TYPE" data-info='<?php echo trim(json_encode($single_alert_type)); ?>'>Edit</a></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="alert_type_panel_heading">Add Alert Type</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'alert_type_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_alert_type">
        					<input type="hidden" name="alert_type_id" value="">
                            <div class="form-group">
                                <label for="alert_type">Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="alert_type" name="alert_type">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="ALERT_TYPE">
                            <input type="submit" class="btn btn-primary" value="Add" id="alert_type_button">
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php if($this->session->flashdata('tab_choosen') && $this->session->flashdata('tab_choosen') == 'tab_four'): echo "show active"; endif; ?>" id="nav-alert-message" role="tabpanel" aria-labelledby="nav-alert-message-tab">
                <div class="row">
                    <div class="col-sm-9">
                        <h4>All Alert Message</h4>
                        <hr>
                        <table class="table table-bordered table-sm dataTable display nowrap" style="width:100%">
                            <colgroup>
                                <col style="width:35pt">
                                <col style="width:200pt">
                                <col style="width:200pt">
                                <col style="width:50pt">
                            </colgroup>
                            <thead class="thead-grey">
                                <tr>
                                    <th data-priority="1">#</th>
                                    <th data-priority="4">Alert Type</th>
                                    <th data-priority="3">Alert Message</th>
                                    <th class="text-right" data-priority="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
        							if(!empty($alert_message)):
        								foreach($alert_message as $key=>$single_alert_message):
                                            $slno = $key + 1;
        						?>
        								<tr>
        									<td><?php echo $slno; ?></td>
                                            <td><?php echo $single_alert_message['alert_type']; ?></td>
                                            <td><?php echo $single_alert_message['alert_message']; ?></td>
                                            <td class="text-right"><button class="btn btn-info btn-sm update_form_link" data-action-name="ALERT_MESSAGE" data-info='<?php echo trim(json_encode($single_alert_message)); ?>'>Edit</button></td>
        								</tr>
        						<?php
        								endforeach;
        							endif;
        						?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <h4 id="alert_message_panel_heading">Add Alert Message</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'alert_message_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="add_alert_message">
                            <input type="hidden" name="alert_message_id" value="">
                            <div class="form-group">
                                <label for="fk_alert_type_id">Alert Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="fk_alert_type_id" id="fk_alert_type_id">
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($alert_type)):
            								foreach($alert_type as $key=>$single_alert_type):
            						?>
                                        <option value="<?php echo $single_alert_type['alert_type_id']; ?>"><?php echo $single_alert_type['alert_type']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alert_message">Message <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="alert_message" name="alert_message">
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="ALERT_MESSAGE">
                            <input type="submit" class="btn btn-primary" value="Add" id="alert_message_button">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
