<h3 class="header-style">Prayer Requests</h3>
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
				<label>Prayer Requests</label>
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
			var link =  __BASE_PATH + 'prayerrequest/saveRequest/';
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
		var link =  __BASE_PATH + 'prayerrequest/getRequest/';
		console.log(link)
		$.ajax({
			type: 'GET',
			url: link,
			success: function(response){
			    console.log(response)
				if(response){
				    console.log(response)
					var html = "<table class='table faqGrid'><tr><th class='hidden'>Title</th><th>Person's Details</th><th>Request</th><th>Actions</th></tr>";
					for(var index=0;index<response.length;index++){

						html += "<tr><td class='hidden'>"  + response[index]["question"] + "</td>" +
								"<td title='Tooltip'>" + putLineBreak(response[index]["name"]) +
                                "<br>"+putLineBreak(response[index]["phone"])+
                                "<br>"+putLineBreak(response[index]["email"])+
                                "<br>"+putLineBreak(response[index]["createdDate"])+
                                "</td>" +
								"<td title='Tooltip'><h4 style=\"text-align: center;\">" + putLineBreak(response[index]["subject"]) + "</h4><br>"+
                                    putLineBreak(response[index]["message"])+ "</td>" +
								"<td>";
						    if (response[index]["status"] ==1){
                                html +=	"<b data-id='"+ response[index]["id"] +"' id='editfaq"   + response[index]["id"] + "''>Accepted</b> " +
                                    "</td></tr>";
                            }else if (response[index]["status"] ==0){
                            html +=	"<b data-id='"+ response[index]["id"] +"' id='editfaq"   + response[index]["id"] + "''>Rejected</b> " +
								"</td></tr>";
						    }else {
                                html +=	"<a data-id='"+ response[index]["id"] +"' id='editfaq"   + response[index]["id"] + "' onclick='acceptPrayer(this);'>Accept</a> | " +
                                    "<a data-id='"+ response[index]["id"] +"' id='deletefaq" + response[index]["id"] + "' onclick='rejectPrayer(this);'>Reject</a> "  +
                                    "</td></tr>";
                            }
					}
					if(response.length == 0){
						html += "<tr><td colspan='3' class='center-text'><i>No records to display.</i></td></tr>";
					}
					html += "</table>";
					$("#faqGridWrapper").html(html);
				}
			},
			dataType: 'json'
		});
	}
	function acceptPrayer(sender){
        var requestId = $(sender).data("id");
        console.log(requestId,name)
        var condition = confirm("Are you sure you want to accept the prayer request?");
	    if (condition!=true){
	        return true
        }
        var link =  __BASE_PATH + 'prayerrequest/saveRequest/';
            $.ajax({
                type: 'POST',
                url: link,
                data : { "id" : requestId ,"status" : 1,"sendEmail" :true},
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

	}
	function rejectPrayer(sender){
        var requestId = $(sender).data("id");
        console.log(requestId,name)
        var condition = confirm("Are you sure you want to reject the prayer request ?");
        if (condition!=true){
            return true
        }
        var link =  __BASE_PATH + 'prayerrequest/saveRequest/';
        $.ajax({
            type: 'POST',
            url: link,
            data : { "id" : requestId ,"status" : 0,"sendEmail" :true},
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
	}
	$(document).ready(function(){
		loadfaq();
		$("#description").Editor();
	});
</script>
