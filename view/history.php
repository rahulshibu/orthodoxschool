<h3 class="header-style">Church History</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="churchHistory-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>churchHistory/savechurchHistory/" autocomplte="on" id="frmchurchHistory">
					<div class="row form-fields hidden">
						<div class="col-lg-12">
							<label>Church History <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="churchHistoryId" name="churchHistoryId"/>
							<input type="text" name="churchHistory" id="title" value="Church History" 
							 placeholder="Enter the churchHistory name" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label id="historyLabel">History <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="churchHistoryDescription" id="description"
								placeholder="Enter the Church History." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="savechurchHistoryBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#churchHistory-form-container');" href="#" 
					title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Church History</label>
				<div id="churchHistoryGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmchurchHistory").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#savechurchHistoryBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		savechurchHistory();
	});
	$("#cancel").click(function(){
		clearchurchHistory();
	});
	function clearchurchHistory() {
		$("#churchHistoryId").val('');
		$("#title").val('Church History');
		$("#description").Editor("setText","");
	}
	function savechurchHistory() {
		if($("#title").val() != ''  && $("#description").Editor("getText") != ''){	
			var link =  __BASE_PATH + 'churchHistory/saveChurchHistory/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#churchHistoryId").val() , "title" : $("#title").val(), "description" : $("#description").Editor("getText")},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearchurchHistory();
						loadchurchHistory();
					}
				},
				dataType: 'json'
			});
		} else {
			alert("Please enter the mandatory fields.");
		}
	}
	function loadchurchHistory(){		
		var link =  __BASE_PATH + 'churchHistory/getChurchHistory/';
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table churchHistoryGrid'><tr><th class='hidden'>Title</th><th>History</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td class='hidden'>"  + response[index]["title"] + "</td>" + 
								"<td title='Tooltip'>" + putLineBreak(response[index]["description"]) + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editchurchHistory"   + response[index]["id"] + "' onclick='churchHistoryEditClicked(this);'>Edit</a> | " + 
								"<a data-id='"+ response[index]["id"] +"' id='deletechurchHistory" + response[index]["id"] + "' onclick='churchHistoryDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#churchHistoryGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function churchHistoryEditClicked(sender){
		var churchHistoryId = $(sender).data("id");
		var churchHistory = $(sender).parents("tr").children("td:nth-child(1)").html();
		var description = $(sender).parents("tr").children("td:nth-child(2)").html();
		
		$("#churchHistoryId").val(churchHistoryId);
		$("#title").val(churchHistory);
		$("#description").Editor("setText", description);
		$(window).scrollTop(0);
	}
	function churchHistoryDeleteClicked(sender){
		var link =  __BASE_PATH + 'churchHistory/deleteChurchHistory/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this churchHistory?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearchurchHistory();
						loadchurchHistory();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadchurchHistory();
		$("#description").Editor();
	});
</script>