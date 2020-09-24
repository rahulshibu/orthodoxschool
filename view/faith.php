<h3 class="header-style">Faith Of The Church</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="faith-form-container">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>prayers/saveFaith/" autocomplte="on" id="frmFaith">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Faith <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="faithId" name="faithId"/>
							<input type="text" name="faith" id="faith" value="" 
							 placeholder="Enter the faith" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Faith Description <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="faithDescription" id="description"
								placeholder="Enter the faith description." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveFaithBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#faith-form-container');" href="#" title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Faith</label>
				<div id="faithGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmFaith").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#saveFaithBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveFaith();
	});
	$("#cancel").click(function(){
		clearFaith();
	});
	function clearFaith() {
		$("#faithId").val('');
		$("#faith").val('');
		$("#description").Editor("setText","");
	}
	function saveFaith(){
		if($("#faith").val() != ''  && $("#description").Editor("getText") != ''){	
			var link =  __BASE_PATH + 'faith/saveFaith/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#faithId").val() , "faith" : $("#faith").val(), "description" : $("#description").Editor("getText")},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearFaith();
						loadFaith();
					}
				},
				dataType: 'json'
			});
		} else {
			alert("Please enter the mandatory fields.");
		}
	}
	function loadFaith(){		
		var link =  __BASE_PATH + 'faith/getFaith/';
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table faithGrid'><tr><th>Faith</th><th>Description</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td>"  + response[index]["faith"] + "</td>" + 
								"<td title='Tooltip'>" + putLineBreak(response[index]["description"]) + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editFaith"   + response[index]["id"] + "'  onclick='faithEditClicked(this);'>Edit</a> | " + 
								"<a data-id='"+ response[index]["id"] +"' id='deleteFaith" + response[index]["id"] + "' onclick='faithDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#faithGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function faithEditClicked(sender){
		var faithId = $(sender).data("id");
		var faith = $(sender).parents("tr").children("td:nth-child(1)").html();
		var description = $(sender).parents("tr").children("td:nth-child(2)").html();
		
		$("#faithId").val(faithId);
		$("#faith").val(faith);
		//$("#description").val(description);
		$("#description").Editor("setText", description);
		$("#faith").focus();
	}
	function faithDeleteClicked(sender){
		var link =  __BASE_PATH + 'faith/deleteFaith/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this faith?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearFaith();
						loadFaith();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadFaith();
		$("#description").Editor();
	});
</script>