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
                        <h4>Send Alerts</h4>
                        <hr>
                        <?php echo form_open(null, array('id'=>'send_alerts_form', 'class'=>'mb-3')); ?>
        					<input type="hidden" name="op" value="SEND_ALERTS">
                            <div class="form-group">
                                <label for="cdcu_id">Cdcu <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="SEND_ALERT_CDCU" data-form-name="send_alerts_form" name="cdcu_id" id="cdcu_id" required>
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
                                <select class="form-control option_change" data-action-name="SEND_ALERT_DCU" data-form-name="send_alerts_form"  name="dcu_id" id="dcu_id" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="node_id">Node <span class="text-danger">*</span></label>
                                <div id="node_checkboxes">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alert_type">Alert Type <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="SEND_ALERT_ALERT_TYPE" data-form-name="send_alerts_form" name="alert_type" id="alert_type" required>
                                    <option value="">Select</option>
                                    <?php
            							if(!empty($alert_types)):
            								foreach($alert_types as $key=>$single_alert_type):
            						?>
                                        <option value="<?php echo $single_alert_type['alert_type_id']; ?>" data-value='<?php echo json_encode($single_alert_type); ?>'><?php echo $single_alert_type['alert_type']; ?></option>
            						<?php
            								endforeach;
            							endif;
            						?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alert_msg">Alert Message <span class="text-danger">*</span></label>
                                <select class="form-control option_change" data-action-name="SEND_ALERT_ALERT_MSG" data-form-name="send_alerts_form"  name="alert_msg" id="alert_msg" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <input type="reset" class="btn btn-secondary reset-default-form" value="Reset" data-reset-default="SEND_ALERTS">
                            <input type="submit" class="btn btn-primary" value="Send Alert" id="send_alerts_button">
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4>Alert Sent Statistics (LoRa End point)</h4>
                        <hr>
                        <table class="table table-sm table-striped">
                            <colgroup>
                                <col style="width:100pt"></col>
                                <col style="width:100pt"></col>
                                <col style="width:100pt"></col>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Alert Type</th>
                                    <th>Node (End Point)</th>
                                    <th>No of Alert</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($node_alert_data)):
                                        foreach($node_alert_data as $key=>$single_node_alert):
                                            foreach($single_node_alert['count_details'] as $single_alert_count):
                                ?>
                                                <tr>
                                                    <td><?php echo $single_node_alert['alert_type']; ?></td>
                                                    <td><?php echo $node_names_data[$single_alert_count['node_key']]; ?></td>
                                                    <td><?php echo $single_alert_count['alert_count']; ?></td>
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
