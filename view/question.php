<h3 class="header-style">Bible Q & A</h3>
<div class="row">
	<div class="col-lg-12">
		<div class="row" id="faq-form-container" style="display: none;">
			<div class="col-lg-10"><br/>
				<form method="post" action="<?php echo $BASE_PATH; ?>faq/saveFaq/" autocomplte="on" id="frmfaq">
                    <div class="row form-fields">
                        <div class="col-lg-12">
                            <label>Question <span class="red">*</span></label>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" value="0" id="faqId" name="faqId"/>
                            <input type="text" disabled name="question" id="question" value=""
                                   placeholder="Enter the question" required />
                        </div>
                    </div>
					<div class="row form-fields hidden">
						<div class="col-lg-12">
							<label>Answer <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<input type="hidden" value="0" id="faqId" name="faqId"/>
							<input type="text" name="faq" id="title" value="Answer"
							 placeholder="Enter the answer" />
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<label id="historyLabel">Answer <span class="red">*</span></label>
						</div>
						<div class="col-lg-12">
							<textarea type="text" name="faqAnswer" id="answer"
								placeholder="Enter the Answer." ></textarea>
						</div>
					</div>
					<div class="row form-fields"><br/>
						<div class="col-lg-12">
							<span class="pull-right">
								<input type="submit" class="btn btn-primary" name="Save" id="saveFaqBtn" value="Save"/>
								<input type="button" class="btn btn-danger" name="cancel" id="cancel" value="Cancel"/>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
<!--			<div class="col-lg-12 center-text">-->
<!--				<a onclick="toggleFormSection('#faq-form-container');" href="#" -->
<!--					title="Click to expand or collapse."><i class="fa fa-bars" aria-hidden="true" ></i></a>-->
<!--			</div>-->
		</div>
		<div class="row">
			<div class="col-lg-12"><br/>
				<label>Bible Q & A</label>
				<div id="faqGridWrapper">
					Loading...
				</div><br/><br/>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmfaq").on("submit", function (event) {
		event.preventDefault();
		// your code...
	});
	$("#saveFaqBtn").click(function(event){
		event.preventDefault(); // Prevent form submit
		saveFAQ();
	});
	$("#cancel").click(function(){
		clearfaq();
        $('#faq-form-container').hide();

    });
	function clearfaq() {
		$("#faqId").val('');
		$("#question").val('');
		$("#answer").val('');
	}
	function saveFAQ() {
		if($("#answer").val() != ''){
			var link =  __BASE_PATH + 'question/saveQuestion/';
			$.ajax({
				type: 'POST',
				url: link,
				data : { "id" : $("#faqId").val() ,"answer" : $("#answer").val(),"sendEmail" :true},
				success: function(response){					
					if(response){
						showMessage("Your data has been saved successfully.");
						clearfaq();
						loadfaq();
                        $('#faq-form-container').hide();

                    }
				},
				dataType: 'json'
			});
		} else {
			alert("Please enter the mandatory fields.");
		}
	}
	function loadfaq(){		
		var link =  __BASE_PATH + 'question/getQuestion/';
		console.log(link)
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){
			    console.log(response)
				if(response){
				    console.log(response)
					var html = "<table class='table faqGrid'><tr><th class='hidden'>Title</th><th>Person's Details</th><th>Question</th><th>Answer</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){
						html += "<tr><td class='hidden'>"  + response[index]["question"] + "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["name"]) +
                                "<br>"+putLineBreak(response[index]["phone"])+
                                "<br>"+putLineBreak(response[index]["email"])+
                                "<br>"+putLineBreak(response[index]["address"])+
                                "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["question"]) + "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["answer"]) + "</td><td>" +
								"<a data-id='"+ response[index]["id"] +"' id='editfaq"   + response[index]["id"] + "' onclick='faqEditClicked(this);'>Reply</a> | " +
								"<a data-id='"+ response[index]["id"] +"' id='deletefaq" + response[index]["id"] + "' onclick='faqDeleteClicked(this);'>Delete</a> "  +
								"</td></tr>";
					}
					if(response.length == 0){
						html += "<tr><td colspan='4' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#faqGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function faqEditClicked(sender){
        $('#faq-form-container').show();

        document.getElementById("faq-form-container").style.display = "show";
        var faqId = $(sender).data("id");
		var faq = $(sender).parents("tr").children("td:nth-child(1)").html();
		var question = $(sender).parents("tr").children("td:nth-child(1)").html();
		var answer = $(sender).parents("tr").children("td:nth-child(4)").html();
		console.log(faqId,question,answer)
		$("#faqId").val(faqId);
		$("#question").val(question);
		$("#answer").val(answer);
		$(window).scrollTop(0);
	}
	function faqDeleteClicked(sender){
		var link =  __BASE_PATH + 'question/deleteQuestion/?id=' + $("#"+sender.id).data("id");
		if(confirm("Are you certain that you want to delete this Q & A?")){
			$.ajax({
				type: 'GET',
				url: link,
				success: function(response){					
					if(response){
						clearfaq();
						loadfaq();
					}
				},
				dataType: 'json'
			});
		}
	}
	$(document).ready(function(){
		loadfaq();
		$("#description").Editor();
	});
</script>