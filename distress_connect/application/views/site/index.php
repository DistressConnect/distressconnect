  <!--script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script->
    <!--====== Banner PART START ======-->
    <div class="banner">
        <div id="map"></div>
        <div class="card message-box">
            <div class="card-header">
                Live Alert
                <button class="float-right cu-icon-toggle collapsed" type="button" data-toggle="collapse" data-target="#collapseStatus" aria-expanded="false" aria-controls="collapseStatus">
                    <i class="cu-icon"></i>
                </button>
                <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Launch demo modal
              </button-->
            </div>
            <div class="card-body collapse" id="collapseStatus">
                <ul>
                    <li id="wheather_info_data_display_cont" class="weather-block">Loading...</li>
                    <li id="wheather_alert_data_display_cont" class="alert-block">Loading...</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-primary text-white">
                <div class="modal-body">
                    <h1 class="text-center">Alert !</h1>
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="<?php echo site_url(); ?>public/assets/images/alert.png" alt="Alert" class="img-fluid flashit">
                        </div>
                        <div class="col-sm-8">
                            <p>
                                Flash Message
                            </p>
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Got It</button>
                            <button type="button" class="btn btn-danger">More Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
