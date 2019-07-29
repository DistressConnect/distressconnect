<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/users/all'); ?>">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add To Dcu</li>
        </ol>
    </nav>

    <div class="container-fluid">
		<div class="card">
			<div class="card-body">
                <?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
                <div class="row">
                    <div class="col-sm-6">
                        <h4><?php echo $user_data['fullname']; ?></h4>
                    </div>
                    <div class="col-sm-6">
                        <h4>Previous Added To Dcu</h4>
                        <hr>

                        <ul class="chips">
                            <?php if(isset($user_data['dcu_data'])):
                                $url = site_url("user/users/delete_user_added_to_dcu/".$user_data['user_id']."/".$user_data['dcu_data']['user_id']);

                                echo "<li>".$user_data['dcu_data']['fullname'] . " - ". $user_data['cdcu_data']['fullname'] . '<a href="'.$url.'" data-category-type="delete_user_added_to_dcu" class="close float-right perform_action_warning delete_category"><i class="fa fa-times"></i></a>'."</li>";
                                endif;
                            ?>
                        </ul>
                        <?php if(!isset($user_data['dcu_data'])): ?>
                            <?php echo form_open(null, array('id'=>'add_to_dcu_form')); ?>
                                <input type="hidden" name="op" value="user_add_to_dcu">
                                <input type="hidden" name="node_id" value="<?php echo $user_data['user_id']; ?>">
                                <h4>Add To Dcu</h4>
                                <?php
                                    if(!empty($all_dcu)):
                                        $all_dcu_options = "";
                                        foreach($all_dcu as $key=>$single_dcu):
                                            $all_dcu_options .= "<option value='".$single_dcu['user_id']."'>".$single_dcu['fullname']."</option>";
                                        endforeach;
                                    endif;
                                ?>
                                <select class="form-control" id="dcu_id" name="dcu_id" required>
                                    <?php echo $all_dcu_options; ?>
                                </select>
                                <input type="submit" class="btn btn-primary float-right" id="add_user_to_dcu_btn" value="Add User To Dcu">
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
