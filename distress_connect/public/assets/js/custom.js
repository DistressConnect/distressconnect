var app = app || {}
app.config = jQuery.extend(true, {}, app.config || {}, {
    baseURL:  "/distress_connect",
	siteUrl: "http://localhost/distress_connect"
});
var floatingui = (function(){

    function _floatingui(){
        var _this = this,
        et = $("#root");

        this.init = function (){
            initEventHandlers();
        };

        var initEventHandlers = function (){
            $(window).bind("load", onWindowLoad);
        };


        /** events that triggers after the page get completely loaded
        */
        onWindowLoad = function (){
            FormValidation.init();

			//Initialize Data table
			if(et.find(".dataTable")[0]) {
				$('.dataTable').DataTable({
					stateSave: true,
					responsive: true
				});
			}

			//Initialize Daetime picker
			if(et.find(".datetimepicker")[0]) {
				$('.datetimepicker').datetimepicker({
					format: 'YYYY-MM-DD',
					ignoreReadonly: true
				});
			}

            //Yes No toggle
            $(".toggleContent").hide();
            et.delegate(".toggler", "change", function(evt){
                $('.toggler').each(function(){
                    var $input = $(this);
                    if ($("[name='" + $input.prop("name") + "'][value='YES']:checked").length != 0) {
                        var toggleID = $(this).data('toggle');
                        $('.toggleContent[data-toggle=' + toggleID + ']').show();
                    }else{
                        var toggleID = $(this).data('toggle');
                        $('.toggleContent[data-toggle=' + toggleID + ']').hide();
                    }

                });
            });

            // Show Password on click
            et.delegate("#show_password", "click", function(evt){
                if($("#show_password:checked").length < 1)
                {
                    $(".view_pass").attr('type', 'password');
                }
                else
                {
                    $(".view_pass").attr('type', 'text');
                }
            });

			// populate data for update action for all forms
			et.delegate(".update_form_link", "click", function(evt){
				var action = $(this).attr('data-action-name');
				var info = $(this).attr('data-info');
				console.log(info);
                var infoj = JSON.parse(info);
				$("#userAddModal").modal('show');
				if(infoj == null)
				{
					alert("Error! Contact support team");
					return false;
				}
				switch(action)
                {
                    case 'USER':
						$("#user_panel_heading").html("Update User Info");
						$("#user_button").val("Update");
						$("#edit_user_reset_btn").attr('data-info', info).addClass('update_users').attr('type', 'button');
						$("#new_user_form input[name='op']").val("edit");
						$("#new_user_form input[name='user_id']").val(infoj.user_id);
						$("#new_user_form input[name='email']").val(infoj.email).attr('disabled', 'disabled');
						$("#new_user_form input[name='fullname']").val(infoj.fullname);
						$("#new_user_form input[name='phone']").val(infoj.phone);
						$("#new_user_form input[name='latitude']").val(infoj.latitude);
						$("#new_user_form input[name='longitude']").val(infoj.longitude);
						$("#new_user_form input[name='passkey']").val(infoj.passkey);
						$("#new_user_form input[name='pincode']").val(infoj.pincode);
						$("#status option[value='"+infoj.status+"']").prop('selected', true);
						$("#role option[value='"+infoj.fk_role_id+"']").prop('selected', true);
					break;
                    case 'DISASTER_TYPE':
						$("#disaster_type_panel_heading").html("Update Disaster Type");
						$("#disaster_type_button").val("Update");
						$("#disaster_type_form input[name='op']").val("edit_disaster_type");
						$("#disaster_type_form input[name='disaster_type_id']").val(infoj.disaster_type_id);
						$("#disaster_type_form input[name='disaster_type']").val(infoj.disaster_type);
					break;
                    case 'DISASTER_MESSAGE':
						$("#disaster_message_panel_heading").html("Update Message");
						$("#disaster_message_button").val("Update");
						$("#disaster_message_form input[name='op']").val("edit_disaster_message");
						$("#disaster_message_form input[name='disaster_message_id']").val(infoj.disaster_message_id);
						$("#disaster_message_form input[name='disaster_message']").val(infoj.disaster_message);
						$("#fk_disaster_type_id option[value='"+infoj.fk_disaster_type_id+"']").prop('selected', true);
					break;
                    case 'ALERT_TYPE':
						$("#alert_type_panel_heading").html("Update Alert Type");
						$("#alert_type_button").val("Update");
						$("#alert_type_form input[name='op']").val("edit_alert_type");
						$("#alert_type_form input[name='alert_type_id']").val(infoj.alert_type_id);
						$("#alert_type_form input[name='alert_type']").val(infoj.alert_type);
					break;
                    case 'ALERT_MESSAGE':
						$("#alert_message_panel_heading").html("Update Message");
						$("#alert_message_button").val("Update");
						$("#alert_message_form input[name='op']").val("edit_alert_message");
						$("#alert_message_form input[name='alert_message_id']").val(infoj.alert_message_id);
						$("#alert_message_form input[name='alert_message']").val(infoj.alert_message);
						$("#fk_alert_type_id option[value='"+infoj.fk_alert_type_id+"']").prop('selected', true);
					break;
				}
			});

            // populate data for Sensor Data
            et.delegate(".sensor_data", "click", function(evt){
                var action = $(this).attr('data-action-name');
				var info = $(this).attr('data-info');
				$("#user_sensor_data_modal_body").html('');
                console.log(info);
                var infoj = JSON.parse(info);
                if(infoj == null)
                {
                    alert("Error! Contact support team");
                    return false;
                }
                switch(action)
                {
                    case 'USER':
                        $("#userSensorDataModalLabel").html("Sensor Data");
                        $("#user_sensor_data_modal_body").html('');
						$("#userSensorDataModal").modal('show');
						if('weather_data' in infoj)
						{
							weather_data = "<table class='table table-sm table-striped'><tbody><thead><th>Temperature</th><th>Humidity</th><th>Recorded On</th></thead>";
							$.each(infoj.weather_data, function(key, value){
								weather_data += "<tr><td>"+ value['temperature']+"</td><td>"+value['humidity']+"</td><td>"+value['created_datetime']+"</td></tr>";
							});
							weather_data += "</tbody></table>";
							$("#user_sensor_data_modal_body").html(weather_data);
						}
                    break;
                }
            });

			// display details data based on clicked module
			et.delegate(".display_details", "click", function(evt){
				var action = $(this).attr('data-action-name');
				var info = $(this).attr('data-info');
				console.log(info);
				var infoj = JSON.parse(info);
				if(infoj == null)
				{
					alert("Error! Contact support team");
					return false;
				}
				switch(action)
				{
					case 'USER':
						var user_status = "Active";
						if(infoj.status == 0)
							user_status = "Inactive";
						var user_details = "<div class='row'>"+
												"<div class='col-sm-6'>"+
													"<label>Username</label>"+
													"<p>"+is_null_check(infoj.username)+"</p>"+
												"</div>"+
												"<div class='col-sm-6'>"+
													"<label>Full Name</label>"+
													"<p>"+is_null_check(infoj.fullname)+"</p>"+
												"</div>"+
												"<div class='col-sm-6'>"+
													"<label>Email</label>"+
													"<p>"+is_null_check(infoj.email)+"</p>"+
												"</div>"+
												"<div class='col-sm-6'>"+
													"<label>Phone Number</label>"+
													"<p>"+is_null_check(infoj.phone)+"</p>"+
                                                "</div>"+
                                                "<div class='col-sm-6'>"+
													"<label>Latitude</label>"+
													"<p>"+is_null_check(infoj.latitude)+"</p>"+
                                                "</div>"+
                                                "<div class='col-sm-6'>"+
													"<label>Longitude</label>"+
													"<p>"+is_null_check(infoj.longitude)+"</p>"+
                                                "</div>"+
                                                "<div class='col-sm-6'>"+
													"<label>Passkey</label>"+
													"<p>"+is_null_check(infoj.passkey)+"</p>"+
                                                "</div>"+
                                                "<div class='col-sm-6'>"+
													"<label>Pincode</label>"+
													"<p>"+is_null_check(infoj.pincode)+"</p>"+
												"</div>";

								user_details +=
												"<div class='col-sm-6'>"+
													"<label>Role</label>"+
													"<p>"+is_null_check(infoj.role)+"</p>"+
												"</div>";
								user_details += "<div class='col-sm-6'>"+
													"<label>Status</label>"+
													"<p>"+is_null_check(user_status)+"</p>"+
												"</div>"+
											"</div>";
						$("#user_details_modal_body").html(user_details);
						$("#userDetailsModal").modal('show');
					break;

				}
			});

			// Onchange of option box events for all forms
			et.delegate(".option_change", "change", function(evt){
				if($(this).val() != "")
				{
					var action 		= $(this).attr('data-action-name');
					var info 		= $(this).find(':selected').attr('data-value');
					var infoj 		= JSON.parse(info);
					var form_name 	= $(this).attr('data-form-name');;
					if(infoj == null)
					{
						alert("Error! Contact support team");
						return false;
					}
					switch(action)
					{
						case 'NODE_STATUS_CDCU': case 'SEND_ALERT_CDCU':
							$("#"+form_name+" #dcu_id").html('');
							if('dcu_data' in infoj)
							{
								dcu_options = "<option value=''>Select</option>";
								$.each(infoj.dcu_data, function(key, value){
									dcu_options += "<option value="+value['passkey']+" data-value='"+JSON.stringify(value)+"'>"+ value['fullname']+"</option>";
								});
								$("#"+form_name+" #dcu_id").html(dcu_options);
							}
						break;

						case 'NODE_STATUS_DCU': case 'SEND_ALERT_DCU':
							$("#"+form_name+" #node_checkboxes").html('');
							if('node_data' in infoj)
							{
								node_checkboxes = "";
								$.each(infoj.node_data, function(key, value){
									node_checkboxes += "<input type='checkbox' value="+value['passkey']+" name='node_id[]'>"+ value['fullname']+"</option>";
								});
								$("#"+form_name+" #node_checkboxes").html(node_checkboxes);
							}
						break;

						case 'NODE_STATUS_DIS_TYPE':
							$("#"+form_name+" #dis_msg").html('');
							if('dis_msg_data' in infoj)
							{
								msg_options = "<option value=''>Select</option>";
								$.each(infoj.dis_msg_data, function(key, value){
									msg_options += "<option value="+value['response_code']+">"+ value['disaster_message']+"</option>";
								});
								$("#"+form_name+" #dis_msg").html(msg_options);
							}
						break;

						case 'SEND_ALERT_ALERT_TYPE':
							$("#"+form_name+" #alert_msg").html('');
							if('alert_msg_data' in infoj)
							{
								msg_options = "<option value=''>Select</option>";
								$.each(infoj.alert_msg_data, function(key, value){
									msg_options += "<option value="+value['response_code']+">"+ value['alert_message']+"</option>";
								});
								$("#"+form_name+" #alert_msg").html(msg_options);
							}
						break;

					}
				}
			});

            // reset to default state of forms
            et.delegate(".reset-default-form", "click", function(evt){
                var action = $(this).attr('data-reset-default');
                switch(action)
                {
                    case 'USER':
						$("#user_panel_heading").html("Add User Info");
						$("#user_button").val("Add");
					break;
                }
            });

            //Reset Forms on close
            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
                $(this).find('form .form-control').prop("disabled", false);
                $(this).find('form .form-group').removeClass("has-error");

                $(this).find(".toggleContent").hide();
                $('.toggler').each(function(){
                    var $input = $(this);
                    if ($("[name='" + $input.prop("name") + "'][value='YES']:checked").length != 0) {
                        var toggleID = $(this).data('toggle');
                        $('.toggleContent[data-toggle=' + toggleID + ']').show();
                    }else{
                        var toggleID = $(this).data('toggle');
                        $('.toggleContent[data-toggle=' + toggleID + ']').hide();
                    }

                });
            });

			et.delegate(".delete_category", "click", function(evt) {
				var category_type = $(this).attr('data-category-type');
				switch(category_type)
				{
					case 'delete_user_added_to_dcu':
						if(!window.confirm('Do you really want to delete this user added to dcu?'))
							return false;
					break;

					case 'delete_user_added_to_cdcu':
					if(!window.confirm('Do you really want to delete this user added to cdcu?'))
							return false;
					break;

					default:
						if(!window.confirm('Do you really want to delete this?'))
							return false;
				}
			});

			et.delegate(".tone_analyzer", "click", function(evt) {
				var key_val = $(this).attr('data-key');
				var message = $(this).attr('data-value');
				$.ajax({
					type    : 'GET',
					url     : app.config.baseURL + "/service/get",
					data    : {'op':'GET_EMOTION_OF_SPEECH_MESSAGE', 'message':message},
					dataType: 'json',
					async   : true,
					success : function(response){
						if(response.status == 1)
						{
							$("#message_"+key_val).html(response.msg);
						}
						else
						{
							alert(response.msg);
						}
					},
					error: function(x,t,e){
						console.log(t);
					}
				});
			});

			if ($('#wheather_alert_data_display_cont').length){
				$.ajax({
					type    : 'GET',
					url     : app.config.baseURL + "/site/get",
					data    : {'op':'GET_WHEATHER_DATA'},
					dataType: 'json',
					async   : true,
					success : function(response){
						if(response.status == 1)
						{
							var infoj = JSON.parse(response.wheather_info_msg);
							$("#wheather_info_data_display_cont").html("It will be <b>"+infoj.cloudCoverPhrase+"</b>, Temperature <b>"+infoj.temperatureDewPoint+"</b> Degree, Humidity <b>"+infoj.relativeHumidity+"</b>, wind Direction <b>"+infoj.windDirectionCardinal+"</b> with Speed <b>"+infoj.windSpeed+"</b>");

							var alertj = JSON.parse(response.wheather_alert_msg);
							$("#wheather_alert_data_display_cont").html(alertj.forecast.terse_phrase);
						}
						else
						{
							console.log("No Records found");
						}
					},
					error: function(x,t,e){
						console.log(t);
					}
				});
			}

            if ($('#map').length){
				//$("#map").html('');
				$.ajax({
					type    : 'GET',
					url     : app.config.baseURL + "/site/get",
					data    : {'op':'GET_MAP_NODE_POINTS_DATA'},
					dataType: 'json',
					async   : true,
					success : function(response){
						if(response.status == 1)
						{
                            var map;
                            function initMap() {
                            map = new google.maps.Map(
                              document.getElementById('map'),
                              {
                                  center: new google.maps.LatLng(20.289723, 85.842752), zoom: 13
                              });

                            var iconBase = app.config.baseURL + '/public/assets/images/mapIcon/';
                            var icons = {
                              2: {
                              icon: iconBase + 'n1.png'
                              },
                              3: {
                              icon: iconBase + 'n2.png'
                               },
                              4: {
                              icon: iconBase + 'n3.png'
                               }
                            };

                            var features = [];
                            $.each(response.features, function(k, single_node){
                                features.push({
                                    position: new google.maps.LatLng(single_node.latitude, single_node.longitude), //CRP
                                    type: single_node.fk_role_id,
                                    fullname: single_node.fullname
                                });
                            });

                            // Create markers.
                            for (var i = 0; i < features.length; i++) {
                              var marker = new google.maps.Marker({
                              position: features[i].position,
                              icon: icons[features[i].type].icon,
                              title: features[i].fullname,
                              map: map
                              });
                            };
                            }
                            initMap();
						}
						else
						{
							console.log("No Records found");
						}
					},
					error: function(x,t,e){
						console.log(t);
					}
				});
			}

            function is_null_check(val)
			{
				if(val == null || val == "")
				{
					val = "-";
				}
				return val;
			}

			function is_null_present(val)
			{
				if(val == null || val == "")
				{
					val = "";
				}
				return val;
			}

        }
        return this;
    }
    return new _floatingui;
})();

//JS entry point
$(function () {
    floatingui.init();
});
