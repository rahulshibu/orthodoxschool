<h3 class="title-style">Notification</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="notification-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>notification/saveNotification/" autocomplte="on" id="frmnotification">
                    <div class="row form-fields">
                        <div class="col-lg-12">
                            <label>Title <span class="red">*</span></label>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" value="0" id="notificationId" name="notificationId"/>
                            <input type="text" name="title" id="title" value=""
                                   placeholder="Enter the title" required />
                        </div>
                    </div>
					<div class="row form-fields hidden">
						<div class="col-lg-12">
							<label>Description <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="notificationId" name="notificationId"/>
							<input type="text" name="notification" id="title" value="Description"
							 placeholder="Enter the notificationDescription" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label id="historyLabel">Description <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="body" id="body"
								placeholder="Enter the Description." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveNoficationBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#notification-form-container');" href="#"
					title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Notification</label>
				<div id="notificationGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmnotification").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#saveNoficationBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveNotification();
	});
	$("#cancel").click(function(){
		clearnotification();
	});
	function clearnotification() {
		$("#notificationId").val('');
		$("#title").val('');
		$("#body").val('');
	}
	function saveNotification() {
		if($("#title").val() != ''  && $("#body").val() != ''){
			var link =  __BASE_PATH + 'notification/saveNotification/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#notificationId").val() , "title" : $("#title").val(), "description" : $("#body").val()},
				success: function(response){
					if(response){
						showMessage("Your data has been saved successfully.");
						clearnotification();
						loadnotification();
					}
				},
				dataType: 'json'
			});
		} else {
			alert("Please enter the mandatory fields.");
		}
	}
	function loadnotification(){
		var link =  __BASE_PATH + 'notification/getNotification/';
		console.log(link)
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){
				if(response){
				    console.log(response)
					var html = "<table class='table notificationGrid'><tr><th class='hidden'>Title</th><th>Title</th><th>Description</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td class='hidden'>"  + response[index]["title"] + "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["title"]) + "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["description"]) + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editnotification"   + response[index]["id"] + "' onclick='notificationEditClicked(this);'>Edit</a> | " +
								"<a data-id='"+ response[index]["id"] +"' id='deletenotification" + response[index]["id"] + "' onclick='notificationDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#notificationGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function notificationEditClicked(sender){
		var notificationId = $(sender).data("id");
		var notification = $(sender).parents("tr").children("td:nth-child(1)").html();
		var title = $(sender).parents("tr").children("td:nth-child(1)").html();
		var notificationDescription = $(sender).parents("tr").children("td:nth-child(3)").html();
		console.log(notificationId,title,notificationDescription)
		$("#notificationId").val(notificationId);
		$("#title").val(title);
		$("#body").val(notificationDescription);
		$(window).scrollTop(0);
	}
	function notificationDeleteClicked(sender){
		var link =  __BASE_PATH + 'notification/deleteNotification/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this notification?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){
					if(response){
						clearnotification();
						loadnotification();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadnotification();
		$("#notificationDescription").Editor();
	});
</script>