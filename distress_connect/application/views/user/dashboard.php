<div class="main-screen">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0;">
            <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7">
                <div class="row">
                    <div id="map"></div>
                </div>
            </div>
            <!--
                The below stastics based on our node cluster (Zone), Zone category is hard coded(current code commit scope), it will be dynamic.
            -->
            <div class="col-sm-5">            
                <h3>Post Disaster Impact Information</h3>
                <table class="table table-sm table-striped">
                    <colgroup>
                        <col style="width:150pt"></col>
                        <col style="width:50pt"></col>
                        <col style="width:50pt"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th></th>
                            <th class='text-center' title='Zone Wise'><?php if(isset($dcu_data[0]['fullname'])): echo $dcu_data[0]['fullname']; endif; ?></th>
                            <th class='text-center' title='Zone Wise'><?php if(isset($dcu_data[1]['fullname'])): echo $dcu_data[1]['fullname']; endif; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $labels_array = array('How Many People Died', 'Human casulaities Number', 'Number of House Damaged', 'Is Road Blocked', 'Number of Animal Death', 'Animal casulaities Number', 'Number of Electric Pole Destroyed');

                        $labels_array1 = array('No of Food Packets Required', 'Number of Drinking water packets', 'Number of Polythenes', 'Urgent rescue team required', 'Number of People need to rescued from location - Need Airlift', 'Please Send NDRF Personal (Number)');

                        $total_dcu_info_data = "";
                        foreach($labels_array as $key=>$single_array):
                            if(!empty($dcu_data))
                            {   
                                $total_dcu_info_data .= "<tr><th>".$single_array."</th><td class='text-center'><span>". $dcu_data[0]['info_arr'][$single_array]."</td><td class='text-center'>". $dcu_data[1]['info_arr'][$single_array]."</td></tr>";
                            }
                        endforeach;
                        
                        echo $total_dcu_info_data;
                    ?>
                    </tbody>
                </table>
                <h3>Post Disaster Required Index</h3>
                <table class="table table-sm table-striped">
                    <colgroup>
                        <col style="width:150pt"></col>
                        <col style="width:50pt"></col>
                        <col style="width:50pt"></col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th></th>
                            <th class='text-center' title='Zone Wise'><?php if(isset($dcu_data[0]['fullname'])): echo $dcu_data[0]['fullname']; endif; ?></th>
                            <th class='text-center' title='Zone Wise'><?php if(isset($dcu_data[1]['fullname'])): echo $dcu_data[1]['fullname']; endif; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_dcu_support_data = "";
                            foreach($labels_array1 as $key=>$single_array1):
                                if(!empty($dcu_data))
                                {
                                    $total_dcu_support_data .= "<tr><th>".$single_array1."</th><td class='text-center'><span>". $dcu_data[0]['support_arr'][$single_array1]."</td><td class='text-center'>". $dcu_data[1]['support_arr'][$single_array1]."</td></tr>";
                                }
                            endforeach;
                            echo $total_dcu_support_data;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
