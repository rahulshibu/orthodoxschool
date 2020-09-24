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
				<form method="post" action="<?php echo $BASE_PATH; ?>calendar/saveEvent/" autocomplete="on" id="frmCalendar">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Event <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="calendarId" name="calendarId"/>
							<input type="text" required name="title" id="title" placeholder="Enter event title" />
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
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Morning </label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="morning" id="morning" placeholder="Enter the details on morning" ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Evening </label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="evening" id="evening" placeholder="Enter the details on evening" ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Before Holy Qurbana </label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="beforeHolyQurbana" id="beforeHolyQurbana" placeholder="Enter the details on before holy qurbana." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Holy Qurbana </label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="holyQurbana" id="holyQurbana" placeholder="Enter the details on holy qurbana." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Blessing Of The Water </label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="blessingOfTheWater" id="blessingOfTheWater"
								placeholder="Enter the details on blessing of the water." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Start Date <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="text" name="startTime" id="startTime" required placeholder="Enter the start time." />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>End Date <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="text" name="endTime" id="endTime" required placeholder="Enter the end time." />
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
					<div class="col-lg-1"><label>Month</label></div>
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
					<div class="col-lg-1"><label>Year</label></div>
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
<link rel="stylesheet" type="text/css" href="<?php echo $BASE_PATH . 'assets/css/jquery.datetimepicker.css' ?>" />
<script src="<?php echo $BASE_PATH . 'assets/js/jquery.datetimepicker.full.min.js' ?>"></script>
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
		$("#title").val('');
		$("#description").val('');
		$("#morning").val('');
		$("#evening").val('');
		$("#beforeHolyQurbana").val('');
		$("#holyQurbana").val('');
		$("#blessingOfTheWater").val('');
		initDatePicker();
	}
	function saveEvent(){		
		var link =  __BASE_PATH + 'calendar/saveEvent/';
		if($("#title").val() != "" && $("#description").val() != '' && $("#startTime").val() != '' && $("#endTime").val() != ''){
			$.ajax({
				type: 'POST',
				url: link,
				data : { 
							"title"              : $("#title").val() , 
							"description"        : $("#description").val(), 
							"morning"            : $("#morning").val(),
							"evening"            : $("#evening").val(),
							"beforeHolyQurbana"  : $("#beforeHolyQurbana").val(),
							"holyQurbana"        : $("#holyQurbana").val(),
							"blessingOfTheWater" : $("#blessingOfTheWater").val(),
							"startTime"          : $("#startTime").val(),
							"endTime"            : $("#endTime").val(),
					   },
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearEvents();
					}
				},
				dataType: 'json'
			});
		} else {
			showMessage("Please enter all the fields");
		}
	}
	function loadEvents(){
		var month = $("#ddlMonth").val();
		var year = $("#ddlYear").val();
		if(month != "" && year != ""){
			var link =  __BASE_PATH + 'calendar/getCalendarByMonth/?month=' + month + "&year=" + year;
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						var html = "<br/><table class='table eventGridList'><tr><th style='width:25%;' class='center-text'>Event Date</th><th style='width:20%;' class='center-text'>Event</th><th>Description</th><th class='center-text'>Action</th></tr>";
						for(var index=0;index<response.length;index++){
							html+= "<tr id='" + response[index]["id"]    + "'><td> StartTime: " + response[index]["startTime"] + "<br/>EndTime: " + response[index]["endTime"] + "</td><td>" + 
												response[index]["title"] + "</td><td>" + response[index]["description"] + "</td><td class='center-text'> " + 								   
								   "<a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]   + "' onclick='eventDeleteClicked(this);'>Delete</a> " +
								   "</td></tr>";
						}
						if(response.length == 0){
							html += "<tr><td colspan='4' class='center-text'><i>No records to display.</i></td></tr>";
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
	function eventDeleteClicked(sender){
		var link =  __BASE_PATH + 'calendar/deleteEvent/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this event from the calendar?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearEvents();
						loadEvents();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		initDatePicker();
	});
	
	function initDatePicker(){
		var today = new Date();
		var year = today.getFullYear();
		var day = today.getDate();
		var month = today.getMonth();
		
		var startTime = year + "/" + (1 + month) + "/" + day + " 09:00";
		var endTime   = year + "/" + (1 + month) + "/" + day + " 18:00";
		
		$('#startTime').datetimepicker({
			dayOfWeekStart : 1,
			lang:'en'
		});
		$('#startTime').datetimepicker({value:startTime,step:30});
		
		$('#endTime').datetimepicker({
			dayOfWeekStart : 1,
			lang:'en'
		});
		$('#endTime').datetimepicker({value:endTime,step:30});
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