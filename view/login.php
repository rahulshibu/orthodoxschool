<?php
	require_once("config.php");
?>
<html>
<meta charset="utf-8"><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<style>
/* Include Lato font from Google Web Fonts */
@import url('//fonts.googleapis.com/css?family=Lato:300,400,400italic,500,500italic,600,600italic,700,700italic');

body {
    
}
body, html {   
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    display:table;	
	font-size:12px;
	font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #454e59;    
	background-color:#c9c9c9;
}
#parent {
	display: table;
	width: 100%;
	height: 100%;	
}
.login-form-wrapper{
	width:320px;
	height:160px;	
	vertical-align: middle;
	margin: 0 auto;
	padding:20px 10px;
	background-color: #fff;
}
.login-form-wrapper input[type=text],
.login-form-wrapper input[type=password] {
	width :100%;
	height:35px;
	border-radius: 3px;
	border:1px solid #dae0e8;
	color: #454e59;
}
.login-form-wrapper label{
	font-size:14px;
}
#form_login {
   display: table-cell;
   vertical-align: middle;
}
.red{
	color:red;
	font-weight:700;
}
</style>
<body>
<div id="parent" align="center">
	
    <form id="form_login" method="post" action="<?php echo $BASE_PATH; ?>account/login/">
	<div class="login-form-wrapper">
		<div align="center"><h2 style="margin:0px;">Admin Login</h2></div>
		<div align="center" style="height:20px;padding:3px;"><span class="red">
			<?php
				if(isset($model->message)){
					echo $model->message;
				}
			?>
		</span></div>
		<table width="100%">
			<tr>
				<th style="width:32%;"></th><th style="width:68%;"></th>
			</tr>
			<tr>
				<td><label>UserName :</label></td>
				<td><input type="text" name="username" placeholder="Enter your username." /></td>
			</tr>
			<tr>
				<td><label>Password :</label></td>
				<td><input type="password" name="password" placeholder="Enter your password" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" id="submit" value="Submit" style="float:right;"/></td>
			</tr>
		</table>        
    </div>
    </form>
	
</div>
</body>
</html>