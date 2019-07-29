<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Role Matrix</li>
        </ol>
    </nav>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Manage Role Matrix</div>
            <div class="card-body">
                <?php include_once(dirname(dirname(__FILE__)) . '/templates/alerts.php');?>
                <?php echo form_open(null, array('id'=>'new_role_matrix_form')); ?>
                    <div class="accordion mb-3" id="accordionRoleMatrix">
                        <?php
                            if(!empty($permission_data)):
                                $role_permission_matrix = "";
                                $category_count         = 0;
                                foreach($permission_data as $key=>$single_category):
                                    $category_count = $category_count + 1;
                                    if($category_count == 1): $area_expand = true; $collapse = "show"; else: $area_expand = false; $collapse = ""; endif;
                                    $role_permission_matrix .= '<div class="card">
                                        <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#'.$key.'" aria-expanded="'.$area_expand.'" aria-controls="'.$key.'">
                                           '.$key.'
                                            </button>
                                        </h2>
                                        </div>

                                        <div id="'.$key.'" class="collapse '.$collapse.'" aria-labelledby="headingOne" data-parent="#accordionRoleMatrix">
                                        <div class="card-body">';
                                        if(!empty($single_category)):
                                            $role_permission_matrix .= '<table class="table table-sm">
                                                <colgroup>
                                                    <col style="width:100pt">
                                                    <col style="width:100pt">
                                                    <col style="width:50pt">
                                                    <col style="width:50pt">
                                                    <col style="width:50pt">
                                                    <col style="width:50pt">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>MODULE</th>
                                                        <th>OPERATION</th>
                                                        <th>ADMIN</th>
                                                        <th>NODE</th>
                                                        <th>DCU</th>
                                                        <th>CDCU</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                foreach($single_category as $permission_key=>$single_permission):
                                                    $role_permission_matrix .= '<tr>
                                                    <th>'.$single_permission['module_name'].'</th>
                                                    <th>'.strtoupper($single_permission['operation_name']).'<input type="hidden" name="role_id[]" value="'.$single_permission['rp_id'].'"></th>';
                                                    foreach($all_roles as $idk=>$single_role):
                                                    //foreach($this->config->item('role_types') as $idk=>$role):
                                                        $is_disabled = ($single_role['role'] == "admin") ? " disabled " : "";
                                                        $is_checked = ($single_permission[$single_role['role']] == 1) ? "checked" : "";
                                                        $role_permission_matrix .= '<td><input type="checkbox" '.$is_checked.' '.$is_disabled.' class="" id="" name="'.$single_role['role'].'_'.$single_permission['rp_id'].'"></td>';
                                                    endforeach;
                                                    $role_permission_matrix .= '</tr>';
                                                endforeach;
                                            $role_permission_matrix .= '</tbody>
                                                                        </table>';
                                        endif;
                                        $role_permission_matrix .= '</div>
                                            </div>
                                        </div>';
                                endforeach;
                                echo $role_permission_matrix;
                            endif;
                        ?>
                    </div>
                    <div class="form-group">
    					<!--input type="reset"  class="btn btn-dark" id="edit_role_matrix_btn" value="Reset">-->
                        <input type="submit" class="btn btn-primary" id="role_matrix_button" data-form-name="new_role_matrix_form" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
