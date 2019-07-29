<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Node Request</li>
        </ol>
    </nav>

    <div class="container-fluid">
		<div class="card">
			<div class="card-body">
                <?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Node Request</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'get_node_status_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="GET_NODE_STATUS">
                            <div class="form-group">
                                <label for="cdcu_id">Cdcu <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="NODE_STATUS_CDCU" data-form-name="get_node_status_form" name="cdcu_id" id="cdcu_id" required>
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($all_cdcu)):
            								foreach($all_cdcu as $key=>$single_cdcu):
            						?>
                                        <option value="<?php echo $single_cdcu['passkey']; ?>" data-value='<?php echo json_encode($single_cdcu); ?>'><?php echo $single_cdcu['fullname']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dcu_id">Dcu <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="NODE_STATUS_DCU" data-form-name="get_node_status_form"  name="dcu_id" id="dcu_id" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="node_id">Node <span class="text-danger">*</span></label>
                                <div id="node_checkboxes">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dis_type">Disaster Type <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="NODE_STATUS_DIS_TYPE" data-form-name="get_node_status_form" name="dis_type" id="dis_type" required>
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($disaster_types)):
            								foreach($disaster_types as $key=>$single_dis_type):
            						?>
                                        <option value="<?php echo $single_dis_type['disaster_type_id']; ?>" data-value='<?php echo json_encode($single_dis_type); ?>'><?php echo $single_dis_type['disaster_type']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dis_msg">Disaster Message <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="NODE_STATUS_DIS_MSG" data-form-name="get_node_status_form"  name="dis_msg" id="dis_msg" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="NODE_STATUS">
                            <input type="submit" class="btn btn-primary" value="Send Request" id="node_status_button">
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4>Node Request - Response Statistics</h4>
                        <hr>
                        <table class="table table-sm table-striped">
                            <colgroup>
                                <col style="width:100pt"></col>
                                <col style="width:100pt"></col>
                                <col style="width:100pt"></col>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Disaster Type</th>
                                    <th>Node (End Point)</th>
                                    <th>No of Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($node_request_data)):
                                        foreach($node_request_data as $key=>$single_node_request):
                                            foreach($single_node_request['count_details'] as $single_req_count):
                                ?>
                                                <tr>
                                                    <td><?php echo $single_node_request['disaster_type']; ?></td>
                                                    <td><?php echo $node_names_data[$single_req_count['node_key']]; ?></td>
                                                    <td><?php echo $single_req_count['req_count']; ?></td>
                                                </tr>
                                <?php
                                            endforeach;
                                        endforeach;
                                    endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
