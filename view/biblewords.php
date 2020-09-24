<h3 class="header-style">Bible Words</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-10" id="bible-words-form-container"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>prayers/saveBibleWords/" autocomplte="on" id="frmBibleWords">
					<div class="row form-fields">
						<div class="col-lg-12">
							<label>Bible Portion <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="bibleWordId" name="bibleWordId"/>
							<input type="text" name="biblePortion" id="biblePortion" value="" 
							 placeholder="Enter the bible portion. Eg Psalms 23:4" required />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Bible Words <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="text" name="bibleWords" id="bibleWords"
								placeholder="Enter the bible word." value="" required />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label>Meditative Thoughts <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="bibleWordsDescription" id="description"
								placeholder="Enter the meditative thoughts." required ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">	
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveBibleWordsBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>			
		</div>
		<div class="row">
			<div class="col-lg-12 center-text">
				<a onclick="toggleFormSection('#bible-words-form-container');" href="#" title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Bible Words</label>
				<div id="bibleWordsGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmBibleWords").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#saveBibleWordsBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveBibleWords();
	});
	$("#cancel").click(function(){
		clearBibleWords();
	});
	function clearBibleWords() {
		$("#bibleWordId").val('');
		$("#biblePortion").val('');
		$("#bibleWords").val('');
		$("#description").Editor("setText","");
	}
	function saveBibleWords(){
		if($("#biblePortion").val() != '' && $("#bibleWords").val() != '' && $("#description").Editor("getText") != ''){	
			var link =  __BASE_PATH + 'bibleWords/saveBibleWords/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#bibleWordId").val() , "portion" : $("#biblePortion").val(), "bibleWords" : $("#bibleWords").val(), "description" : $("#description").Editor("getText")},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearBibleWords();
						loadBibleWords();
					}
				},
				dataType: 'json'
			});
		} else {
			var validity = $('#frmBibleWords')[0].checkValidity();
			console.log(validity);
			alert("Please enter the mandatory fields.");
		}
	}
	function loadBibleWords(){		
		var link =  __BASE_PATH + 'bibleWords/getBibleWords/';
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){					
				if(response){
					var html = "<table class='table bibleWordsGrid'><tr><th>Bible Portion</th><th>Bible Words</th><th>Meditative Thoughts</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td>"  + response[index]["portion"] + "</td><td>" + response[index]["bibleWords"] + 
								"</td><td>" + response[index]["description"] + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editBibleWords"   + response[index]["id"] + "'  onclick='bibleWordsEditClicked(this);'>Edit</a> | " + 
								"<a data-id='"+ response[index]["id"] +"' id='deleteBibleWords" + response[index]["id"] + "' onclick='bibleWordsDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='4' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#bibleWordsGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function bibleWordsEditClicked(sender){
		var bibleWordsId = $(sender).data("id");
		var portion = $(sender).parents("tr").children("td:nth-child(1)").html();
		var bibleWords = $(sender).parents("tr").children("td:nth-child(2)").html();
		var thoughts = $(sender).parents("tr").children("td:nth-child(3)").html();
		
		$("#bibleWordId").val(bibleWordsId);
		$("#bibleWords").val(bibleWords);
		$("#biblePortion").val(portion);
		$("#description").Editor("setText", thoughts); //$("#description").val(thoughts);
		$("#biblePortion").focus();
	}
	function bibleWordsDeleteClicked(sender){
		var link =  __BASE_PATH + 'bibleWords/deleteBibleWords/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this bible word?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearBibleWords();
						loadBibleWords();
					}
				},
				dataType: 'json'
			});
		}
	}	
	$(document).ready(function(){
		loadBibleWords();
		$("#description").Editor();
	});
</script>