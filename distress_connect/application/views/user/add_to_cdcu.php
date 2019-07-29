<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/users/all'); ?>">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add To Cdcu</li>
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
                        <h4>Previous Added To Cdcu</h4>
                        <hr>
                        <?php if(isset($user_data['cdcu_data'])):
                            $url = site_url("user/users/delete_user_added_to_cdcu/".$user_data['user_id']."/".$user_data['cdcu_data']['user_id']);

                            echo $user_data['cdcu_data']['fullname'] . '<a href="'.$url.'" data-category-type="delete_user_added_to_cdcu" class="btn btn-danger btn-sm float-right perform_action_warning delete_category"><i class="fa fa-trash"></i></a>';
                            endif;
                        ?>
                        <?php if(!isset($user_data['cdcu_data'])): ?>
                            <?php echo form_open(null, array('id'=>'add_to_dcu_form')); ?>
                                <input type="hidden" name="op" value="user_add_to_cdcu">
                                <input type="hidden" name="dcu_id" value="<?php echo $user_data['user_id']; ?>">
                                <h4>Add To Cdcu</h4>
                                <?php
                                    if(!empty($all_cdcu)):
                                        $all_cdcu_options = "";
                                        foreach($all_cdcu as $key=>$single_cdcu):
                                            $all_cdcu_options .= "<option value='".$single_cdcu['user_id']."'>".$single_cdcu['fullname']."</option>";
                                        endforeach;
                                    endif;
                                ?>
                                <select class="form-control" id="cdcu_id" name="cdcu_id" required>
                                    <?php echo $all_cdcu_options; ?>
                                </select>
                                <input type="submit" class="btn btn-primary float-right" id="add_user_to_cdcu_btn" value="Add User To Cdcu">
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
