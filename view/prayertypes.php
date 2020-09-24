<h3 class="header-style">Prayer Types</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-6"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>prayers/savePrayerType/" autocomplte="on" id="frmPrayerType">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Prayer Type <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" name="prayerTypeId" id="prayerTypeId" value="0"/>
							<input type="text" name="prayerType" id="prayerType" required />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right input-wrapper">
								<input type="submit" class="btn btn-primary" name="Save" id="savePrayerTypeBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-6"><br/>
				<label>Prayer Types List</label>
				<div id="prayerTypesGridWrapper">
					Loading...
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#savePrayerTypeBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		savePrayerType();
	});
	$("#cancel").click(function(){
		clearPrayerTypes();
	});
	function clearPrayerTypes() {
		$("#prayerTypeId").val('0');
		$("#prayerType").val('');
	}
	function savePrayerType(){		
		var link =  __BASE_PATH + 'prayertypes/savePrayerType/';
		if($("#prayerType").val() != ''){
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#prayerTypeId").val() , "prayerType" : $("#prayerType").val()},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearPrayerTypes();
						loadPrayerTypes();
					}
				},
				dataType: 'json'
			});
		} else {
			showMessage("Please enter the prayer type.");
		}
	}
	function loadPrayerTypes(){		
		var link =  __BASE_PATH + 'prayertypes/getPrayerTypes/';
		$("#prayerTypesGridWrapper").html("Loading...");
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table'><tr><th>Prayer Type</th><th>Action</th></tr>";
					for(var index=0;index<response.length;index++){
						html+= "<tr id='" + response[index]["id"] + "'><td>" + response[index]["prayerType"] + "</td><td> " + 
							   "<a id='editPrayerType" + response[index]["id"] + "' data-id='" + response[index]["id"] + "' onclick='prayerTypeEditClicked(this);'>Edit</a> | " + 
							   "<a id='delPrayerType" + response[index]["id"]  + "' data-id='" + response[index]["id"] + "' onclick='prayerTypeDeleteClicked(this);'>Delete</a> " +
							   "</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='2' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#prayerTypesGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function prayerTypeEditClicked(sender){
		var prayerTypeId = $(sender).data("id");
		var prayerType = $(sender).parents("tr").children("td:first").html();
		$("#prayerTypeId").val(prayerTypeId);
		$("#prayerType").val(prayerType);
	}
	function prayerTypeDeleteClicked(sender){
		var link =  __BASE_PATH + 'prayertypes/deletePrayerTypes/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this prayer type?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearPrayerTypes();
						loadPrayerTypes();
					}
				},
				error:function(err){
					showMessage("An error occured while processing your request. Please verify if there is any record associated with it.");
				},
				dataType: 'json'
			});
		}
	}
	 
	$(document).ready(function(){
		loadPrayerTypes();
	});
</script>