<h3 class="header-style">Saints</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="saint-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>prayers/savesaint/" autocomplte="on" id="frmSaint">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Saint <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="saintId" name="saintId"/>
							<input type="text" name="saint" id="saint" value="" 
							 placeholder="Enter the saint name" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>About Saint <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="saintDescription" id="description"
								placeholder="Enter the saint description." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveSaintBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#saint-form-container');" href="#" 
					title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Saints</label>
				<div id="saintGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmSaint").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#saveSaintBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveSaint();
	});
	$("#cancel").click(function(){
		clearSaint();
	});
	function clearSaint() {
		$("#saintId").val('');
		$("#saint").val('');
		$("#description").Editor("setText","");
	}
	function saveSaint(){
		if($("#saint").val() != ''  && $("#description").Editor("getText") != ''){	
			var link =  __BASE_PATH + 'saint/saveSaint/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#saintId").val() , "saint" : $("#saint").val(), "description" : $("#description").Editor("getText")},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearSaint();
						loadSaint();
					}
				},
				dataType: 'json'
			});
		} else {
			alert("Please enter the mandatory fields.");
		}
	}
	function loadSaint(){		
		var link =  __BASE_PATH + 'saint/getSaint/';
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table saintGrid'><tr><th>saint</th><th>Description</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td>"  + response[index]["saint"] + "</td>" + 
								"<td title='Tooltip'>" + putLineBreak(response[index]["description"]) + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editSaint"   + response[index]["id"] + "' onclick='saintEditClicked(this);'>Edit</a> | " + 
								"<a data-id='"+ response[index]["id"] +"' id='deleteSaint" + response[index]["id"] + "' onclick='saintDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#saintGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function saintEditClicked(sender){
		var saintId = $(sender).data("id");
		var saint = $(sender).parents("tr").children("td:nth-child(1)").html();
		var description = $(sender).parents("tr").children("td:nth-child(2)").html();
		
		$("#saintId").val(saintId);
		$("#saint").val(saint);
		//$("#description").val(description);
		$("#description").Editor("setText", description);
		$("#saint").focus();
	}
	function saintDeleteClicked(sender){
		var link =  __BASE_PATH + 'saint/deleteSaint/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this saint?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearSaint();
						loadSaint();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadSaint();
		$("#description").Editor();
	});
</script>