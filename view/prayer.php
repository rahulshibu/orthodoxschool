<h3 class="header-style">Prayers</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="prayers-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>prayers/savePrayer/" autocomplte="on" id="frmPrayer">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Prayer Type <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="prayerId" name="prayerId"/>
							<select name="prayerTypeId" id="prayerTypeId" required>
								<option value=""> - Select Prayer Type - </option>
								<?php
									for($index =0;$index<count($model["prayerTypes"]);$index++){
										echo "<option value='". $model["prayerTypes"][$index]["id"] ."'>". $model["prayerTypes"][$index]["prayerType"] ."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Prayer <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea name="prayer" class="classy-editor" id="prayer" row="20" col="12" placeholder="Enter the prayer" required></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="savePrayerBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#prayers-form-container');" href="#" title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Prayers</label>
				<div id="prayerGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#savePrayerBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		savePrayer();
	});
	$("#cancel").click(function(){
		clearPrayer();
	});
	function clearPrayer() {
		$("#prayerTypeId").val('');
		$("#prayer").Editor("setText","");
		$("#prayerId").val('0');
	}
	function savePrayer(){		
		var link =  __BASE_PATH + 'prayer/savePrayer/';
		if($("#prayerTypeId").val() != "" && $("#prayer").Editor("getText") != ''){
			$.ajax({
				type: 'POST',
				url: link,
				data : { "prayerTypeId" : $("#prayerTypeId").val() , "prayer" : $("#prayer").Editor("getText"), "id" : $("#prayerId").val()},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearPrayer();
						loadPrayers();
					}
				},
				dataType: 'json'
			});
		} else {
			showMessage("Please enter all the fields");
		}
	}
	function loadPrayers(){		
		var link =  __BASE_PATH + 'prayer/getPrayer/';
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table prayerGridList'><tr><th class='center-text'>Prayer Type</th><th style='width:50%;' class='center-text'>Prayer</th><th class='center-text'>Action</th></tr>";
					for(var index=0;index<response.length;index++){
						html+= "<tr id='" + response[index]["id"] + "'><td>" + response[index]["prayerTypeText"] + "</td><td>" + 
																		 putLineBreak(response[index]["prayer"]) + "</td><td class='center-text'> " + 
							   "<a id='editPrayer" + response[index]["id"] + "' data-prayertypeid='" + response[index]["prayerType"] + 
							   "' data-id='" + response[index]["id"]     + "' onclick='prayerEditClicked(this);'>Edit</a> | " + 
							   "<a id='delPrayer" + response[index]["id"] + "' data-id='" + response[index]["id"]     + "' onclick='prayerDeleteClicked(this);'>Delete</a> " +
							   "</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#prayerGridWrapper").html(html);
				}
			},
			error:function(){
				showMessage("An error occured while processing your request");
			},
			dataType: 'json'
		});
	}
	function prayerEditClicked(sender){
		var prayerId = $(sender).data("id");
		var prayerTypeId = $(sender).data("prayertypeid");
		var prayer = putNewLine($(sender).parents("tr").children("td:nth-child(2)").html());
		$("#prayerId").val(prayerId);
		//$('#prayerTypeId option[value=' + prayerTypeId +']').attr('selected', 'selected');
		$('#prayerTypeId').val(prayerTypeId);
		$("#prayer").Editor("setText", prayer);
		$('#prayerTypeId').focus();
	}
	function prayerDeleteClicked(sender){
		var link =  __BASE_PATH + 'prayer/deletePrayer/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this prayer?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearPrayer();
						loadPrayers();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadPrayers();
		$("#prayer").Editor();
	});
</script>