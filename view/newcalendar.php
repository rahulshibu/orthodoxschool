<style>
	#calendar-form-container .form-fields textarea{
		height:95px;
	}
</style>
<h3 class="header-style">Calendar</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="calendar-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>newcalendarsaveEvent/" autocomplete="on" id="frmCalendar">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Event <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="calendarId" name="calendarId"/>
							<input type="text" required name="name" id="name" placeholder="Enter event name" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Description <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea name="description" id="description" required row="10" col="10" placeholder="Enter the event description" required></textarea>
						</div>
					</div>
                    <div class="row form-fields">
                        <div class="col-lg-12">
                            <label>Venue <span class="red">*</span></label>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" value="0" id="calendarId" name="calendarId"/>
                            <input type="text" required name="venue" id="venue" placeholder="Enter venue" />
                        </div>
                    </div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Start Date <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
                            <input type="datetime-local" name="startTime" id="startTime"  placeholder="Enter the start time.">
                        </div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>End Date <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
                            <input type="datetime-local" name="endTime" id="endTime"  placeholder="Enter the end time." >
                        </div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveCalendarBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#calendar-form-container');" href="#" title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Calendar Events</label>
				<div class="row form-fields">
					<SPAN class="MsgTxt"><A HREF="javascript:openBible('Genesis 24:10 -20');">
Genesis 24: 10 -20</A></SPAN>
					<div class="col-lg-1"><label>Start Month</label></div>
					<div class="col-lg-2">
						<select id="ddlMonth">
							<option value="">Select</option>
							<option value="1">Jan</option>
							<option value="2">Feb</option>
							<option value="3">Mar</option>
							<option value="4">Apr</option>
							<option value="5">May</option>
							<option value="6">Jun</option>
							<option value="7">Jul</option>
							<option value="8">Aug</option>
							<option value="9">Sep</option>
							<option value="10">Oct</option>
							<option value="11">Nov</option>
							<option value="12">Dec</option>
						</select>
					</div>
					<div class="col-lg-1"><label>Start Year</label></div>
					<div class="col-lg-2">
						<select id="ddlYear">
							<option value="">Select</option>
							<?php
								$year = date("Y");
								for($index = -2;$index<5;$index++){
									$val = $year + $index;
									echo '<option value="'.$val.'">'.$val.'</option>';
								}
							?>
						</select>
					</div>
					<div class="col-lg-1"><input type="button" class="btn btn-primary" value="Search" onclick="loadEvents();"/></div>
				</div>
				<div id="calendarGridWrapper">

				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>

	$("#saveCalendarBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveEvent();
	});
	$("#cancel").click(function(){
		clearEvents();
	});
	function clearEvents() {
		$("#calendar").val('');
		$("#calendarId").val('0');
		$("#name").val('');
		$("#description").val('');
		$("#venue").val('');
		$("#startTime").val('');
		$("#endTime").val('');
		initDatePicker();
	}
	function saveEvent(){		
		var link =  __BASE_PATH + 'newcalendar/saveEvent/';
        let values = {
            "name"              : $("#name").val() ,
            "description"       : $("#description").val(),
            "venue"             : $("#venue").val(),
        }

		if($("#name").val() != "" && $("#description").val() != '' && $("#venue").val() != ''){

		    if (($("#startTime").val()!="" && $("#endTime").val() =="")||$("#endTime").val()!="" && $("#startTime").val() ==""){
                showMessage("Start and end date are required");
                return
            }
            if ($("#startTime").val()!="" && $("#endTime").val() !=""){
                if ($("#endTime").val() < $("#startTime").val()){
                    showMessage("Start date should be greater than end date");
                    return

                }
                values = {
                    "name"              : $("#name").val() ,
                    "description"       : $("#description").val(),
                    "venue"             : $("#venue").val(),
                    "startDate"         : ($("#startTime").val()=="")?null:$("#startTime").val(),
                    "endDate"           : ($("#endTime").val()=="")?null:$("#endTime").val(),
                }

            }
            let id = parseInt($("#calendarId").val());
            console.log(id)
            if (id>0){
                values["id"] =id
            }


			$.ajax({
				type: 'POST',
				url: link,
				data : values,
				success: function(response){					
					if(response){
                        showMessage("Your data has been saved successfully.");
                        clearEvents();
						loadIntialEvents();


                    }
				},
				dataType: 'json'
			});
		} else {
			showMessage("Please enter all the fields");
		}
	}

	function loadIntialEvents() {
        var month = ''
        var year = ''
        var link =  __BASE_PATH + 'newcalendar/getCalendarByMonth/?month=' + month + "&year=" + year;
        $.ajax({
            type: 'GET',
            url: link,
            success: function(response){
                if(response){
                    var html = "<br/><table class='table eventGridList'><tr><th style='width:25%;' class='center-text'>Event Date</th><th style='width:20%;' class='center-text'>Event</th><th>Description</th><th class='center-text'>Venue</th><th class='center-text'>Action</th></tr>";
                    for(var index=0;index<response.length;index++){
                        html+= "<tr id='" + response[index]["id"]    + "'><td> Start Date: " + response[index]["startDate"] + "<br/>End Date: " + response[index]["endDate"] + "</td><td>" +
                            response[index]["name"] + "</td><td>" + response[index]["description"] + "</td><td>" + response[index]["venue"] + "</td><td class='center-text'> " +
                            "<p><a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]   + "' onclick='eventEditClicked(this);'>Edit</a></p><a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]   + "' onclick='eventDeleteClicked(this);'>Delete</a> " +
                            "</td></tr>";
                    }
                    if(response.length == 0){
                        html += "<tr><td colspan='5' class='center-text'><i>No records to display.</i></td></tr>";
                    }
                    html += "</table>";
                    $("#calendarGridWrapper").html(html);
                }
            },
            error:function(){
                showMessage("An error occured while processing your request");
            },
            dataType: 'json'
        });
    }

	function loadEvents(){
		var month = $("#ddlMonth").val();
		var year = $("#ddlYear").val();
		if(month != "" && year != ""){
			var link =  __BASE_PATH + 'newcalendar/getCalendarByMonth/?month=' + month + "&year=" + year;
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						var html = "<br/><table class='table eventGridList'><tr><th style='width:25%;' class='center-text'>Event Date</th><th style='width:20%;' class='center-text'>Event</th><th>Description</th><th class='center-text'>Venue</th><th class='center-text'>Action</th></tr>";
						for(var index=0;index<response.length;index++){
							html+= "<tr id='" + response[index]["id"]    + "'><td> Start Date: " + response[index]["startDate"] + "<br/>End Date: " + response[index]["endDate"] + "</td><td>" +
												response[index]["name"] + "</td><td>" + response[index]["description"] + "</td><td>" + response[index]["venue"] + "</td><td class='center-text'> " +
                                "<p><a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]   + "' onclick='eventEditClicked(this);'>Edit</a></p><a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]   + "' onclick='eventDeleteClicked(this);'>Delete</a> " +
								   "</td></tr>";
						}
						if(response.length == 0){
							html += "<tr><td colspan='5' class='center-text'><i>No records to display.</i></td></tr>";
						}
						html += "</table>";
						$("#calendarGridWrapper").html(html);
					}
				},
				error:function(){
					showMessage("An error occured while processing your request");
				},
				dataType: 'json'
			});
		} else {
			alert("Please select both month and year to perform the search.");
		}
	}

    function eventEditClicked(sender){
        var calendarId = $(sender).data("id");
        console.log(calendarId)
        var link =  __BASE_PATH + 'newcalendar/getCalenderById/?id=' + calendarId;
        $.ajax({
            type: 'GET',
            url: link,
            success: function(response){
                if(response){
                   if (response[0]==undefined){
                       showMessage("Invalid event id");
                       return
                   }
                   $("#name").val(response[0]['name'])
                   $("#description").val(response[0]['description'])
                   $("#venue").val(response[0]['venue'])
                   $("#startTime").val(response[0]['startDate'])
                   $("#endTime").val(response[0]['endDate'])
                   $("#calendarId").val(response[0]['id'])
                }
            },
            error:function(){
                showMessage("An error occured while processing your request");
            },
            dataType: 'json'
        });
        $(window).scrollTop(0);
    }

	function eventDeleteClicked(sender){
		var link =  __BASE_PATH + 'newcalendar/deleteEvent/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this event from the calendar?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						// clearEvents();
						// loadEvents();
                        loadIntialEvents()
					}
				},
				dataType: 'json'
			});
		}
        $("#calendarGridWrapper").html("");
        loadIntialEvents()

    }


	$(document).ready(function(){
        loadIntialEvents();
        console.log(123)
		initDatePicker();
	});
    console.log(123)


    function initDatePicker(){
		var today = new Date();
		var year = today.getFullYear();
		var day = today.getDate();
		var month = today.getMonth();
		
		var startTime = year + "/" + (1 + month) + "/" + day + " 09:00";
		var endTime   = year + "/" + (1 + month) + "/" + day + " 18:00";


	}
	function openBible(biblePortion) {
		biblePortion = biblePortion.replace(/^III\s+/, "3 ");
		biblePortion = biblePortion.replace(/^II\s+/, "2 ");
		biblePortion = biblePortion.replace(/^I\s+/, "1 ");
		biblePortion = biblePortion.replace(/\s+/g, "%20");
		var a = null;
		var h = window.location.host;
		//if (document.forms[0].openmal.checked)
		//	a=window.open("http://"+h+"/cgi/mbible.cgi?verses="+biblePortion,"Bible","location=yes,toolbar=no,titlebar=no,scrollbars=yes,resizable=yes");
		//else
		a=window.open("http://bible.gospelcom.net/cgi-bin/bible?passage="+biblePortion,"Bible","location=no,toolbar=no,titlebar=no,scrollbars=yes,resizable=yes");
		a.focus();
	}
</script>