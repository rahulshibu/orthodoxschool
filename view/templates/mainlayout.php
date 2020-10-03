<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $BASE_PATH; ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH; ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH; ?>assets/css/jquery-ui.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH; ?>/assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH; ?>/assets/css/editor.css" rel="stylesheet">
	<!-- /.container -->
    <!-- jQuery -->
    <script src="<?php echo $BASE_PATH; ?>assets/js/jquery.js"></script>
	<script src="<?php echo $BASE_PATH; ?>assets/js/jquery-ui.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $BASE_PATH; ?>assets/bootstrap/js/bootstrap.min.js"></script> 
	<script src="<?php echo $BASE_PATH; ?>assets/js/bootbox.min.js"></script>
	<script src="<?php echo $BASE_PATH; ?>assets/js/editor.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
		var __BASE_PATH = "<?php echo $BASE_PATH ?>";
		function showMessage(msg, callback){
			bootbox.alert(msg, callback);
		}
	</script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-red" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
					<img src="<?php echo $BASE_PATH;?>assets/images/holy-cross.png" style="height:50px;width:auto;position:relative;bottom:8px;"/>
					<span class="logo-txt" style="position:relative;bottom:26px;">Orthodox Bible School</span>
				</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo $BASE_PATH . 'logout/index/'; ?>" title="Click to logout"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                    </li>
                    <!-- <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>-->
                </ul> 
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" id="page-container">
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="<?php echo $BASE_PATH . 'prayertypes/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "PrayerTypes") ? "active" : ""; ?>">Prayer Type</a>
					<a href="<?php echo $BASE_PATH . 'prayer/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "Prayer") ? "active" : ""; ?>">Prayers</a>
                    <a href="<?php echo $BASE_PATH . 'biblewords/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "BibleWords") ? "active" : ""; ?>">Bible Words</a>
                     <a href="<?php echo $BASE_PATH . 'faith/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "Faith") ? "active" : ""; ?>">Faith Of Church</a>
					<a href="<?php echo $BASE_PATH . 'calendar/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "Calendar") ? "active" : ""; ?>">Calendar</a>
					<a href="<?php echo $BASE_PATH . 'saint/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "Saint") ? "active" : ""; ?>">Saints</a>
					<a href="<?php echo $BASE_PATH . 'churchhistory/index/'; ?>" 
						class="list-group-item <?php echo ($this->getControllerName() == "ChurchHistory") ? "active" : ""; ?>">Church History</a>
                    <a href="<?php echo $BASE_PATH . 'faq/index/'; ?>"
                       class="list-group-item <?php echo ($this->getControllerName() == "Faq") ? "active" : ""; ?>">FAQ</a>
                    <a href="<?php echo $BASE_PATH . 'question/index/'; ?>"
                       class="list-group-item <?php echo ($this->getControllerName() == "Question") ? "active" : ""; ?>">Bible Q & A</a>
                    <a href="<?php echo $BASE_PATH . 'prayerrequest/index/'; ?>"
                       class="list-group-item <?php echo ($this->getControllerName() == "PrayerRequest") ? "active" : ""; ?>">Prayer Requests</a>
                    <a href="<?php echo $BASE_PATH . 'notification/index/'; ?>"
                       class="list-group-item <?php echo ($this->getControllerName() == "Notification") ? "active" : ""; ?>">Notifications</a>
                </div>
            </div>
            <div class="col-md-10">
                <?php
					//echo $content;
					$this->renderHtmlBody();
				?>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <div class="container">   <br/><br/>     
        <!-- Footer -->
        <footer><hr>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; <br/>Orthodox Bible School</p>
                </div>
            </div>
        </footer>
    </div>
	<div id="divLoading" style="z-index:10000">
    </div>
	<script>
		var showLoading = function () {
			$("div#divLoading").addClass('show');
		}
		var hideLoading = function () {
			$("div#divLoading").css('display','none').removeClass('show');
		}
		$.ajaxSetup({
			beforeSend: function(){
				showLoading();
			},
			complete: function(){
				hideLoading();
				//$("#sidebar-wrapper").css("height", $(document).height());
			}
		});
		$(document).ready(function(){
			
		});
		$("td").tooltip();
		function toggleFormSection(formContainerId){
			$(formContainerId).toggle("slow");
		}
		function putLineBreak(str){
			return str;
			//if(str == null){
			//	str = "";
			//}
			//return str.replace(/\r\n|\r|\n/g,"<br />");
		}
		function putNewLine(str){
			return str;
			//if(str == null){
			//	str = "";
			//}
			//return str.replace(/<br ?\/?>/g, "\r\n");
		}
	</script>
</body>
</html>

