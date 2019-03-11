<?php
// ediit by james 2019.3.11
session_start();
error_reporting(0);     //PHP运行出现Notice : Notice: Undefined index的原因及解决办法
require "conn/conn.php";
$my_username = isset($_POST['username'])? $_POST['username'] : '';
if($my_username!='') {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password = md5($password);
	//$sql = "SELECT * FROM user_info where username='".$username."' and password='".$password."'";
	$sql = "SELECT * FROM user_name where user_name='".$username."' and user_pass='".$password."'";
	mysqli_set_charset($conn,'utf8');
	$result = $conn->query($sql);
 
	if ($result->num_rows > 0) {
	    // 输出数据
	    while($row = $result->fetch_assoc()) {
	        //echo "id: " . $row["id"]. " - username: " . $row["username"]. " - userrole: " . $row["user_role"]. "<br>";
	        	$username = $row["user_name"];
	        	$userrole = $row["user_role"];
				$userpic  = $row["user_pic_url"];
				$userid   = $row["id"];
	    }
		
		$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
					  	$url = dirname($url);
		$my_user_fullurl = $url;
		$my_user_fullurl .= '/userbm'; 
		$my_user_fullurl .= '/' . $userpic;
		
						//$pre_path = strstr($my_user_fullurl,"world");  
						$my_user_fullurl = str_replace("column","userbm",$my_user_fullurl);
						$my_user_fullurl = str_replace("picturebm","userbm",$my_user_fullurl);
						$my_user_fullurl = str_replace("listenbm","userbm",$my_user_fullurl);
						$my_user_fullurl = str_replace("videobm","userbm",$my_user_fullurl);
						$my_user_fullurl = str_replace("articlebm","userbm",$my_user_fullurl);
						$my_user_fullurl = str_replace("rolebm","userbm",$my_user_fullurl);
	    
	    // 存储 session 数据
		$_SESSION['mg_userid']=$userid;
		$_SESSION['mg_username']=$username;
		$_SESSION['mg_userrole']=$userrole;
		$_SESSION['loggd']='login';
		$_SESSION['user_img']=$my_user_fullurl;  //'assets/img/user04.png';
		$_SESSION['pu_user_img']=$my_user_fullurl;  //'../assets/img/user04.png';


		switch ($_SESSION['mg_userrole'])
		{
		case '超级管理员':
			$my_login_url = 'indexbm/indexbm-index.php';
			$_SESSION['mg_userclass']='1';
			break;
		case '图片管理员':
			$my_login_url = 'picturebm/pic-list.php';
			$_SESSION['mg_userclass']='2';
			break;
		case '听力管理员':
			$my_login_url = 'listenbm/listen-list.php';
			$_SESSION['mg_userclass']='3';
			break;
		case '视频管理员':
			$my_login_url = 'videobm/video-list.php';
			$_SESSION['mg_userclass']='4';
			break;
		case '文章管理员':
			$my_login_url = 'articlebm/article-list.php';
			$_SESSION['mg_userclass']='5';
			break;
			
		
			
		}
		// echo "<br/> my_login_url =".$my_login_url;
	    ?>
		<script language="javascript">
		alert("登录成功");window.location.href="<?php echo $my_login_url;?>";
		</script>
		<?php
	} else {
	   ?>
		<script language="javascript">
		// window.alert = function(name){
    //             var iframe = document.createElement("IFRAME");
    //             iframe.style.display="none";
    //             document.documentElement.appendChild(iframe);
    //             window.frames[0].window.alert(name);
    //             iframe.parentNode.removeChild(iframe);
    //         };
		alert("用户名或密码错");

		



	     
          
             

		window.location.href="login.php";
		
		</script>
		<?php
		// echo "用户名或密码错";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0"> 
	<title>学工系统 - 后台管理</title>
    <link href="assets/myui/css/default.css" rel="stylesheet" type="text/css" />
	<!--必要样式-->
    <link href="assets/myui/css/styles.css" rel="stylesheet" type="text/css" />
    <link href="assets/myui/css/demo.css" rel="stylesheet" type="text/css" />
		<link href="assets/myui/css/loaders.css" rel="stylesheet" type="text/css" />
		<link href="assets/layui/css/layui.css" rel="stylesheet" type="text/css" />
		<style>
			body {
				background-color: #07335b;
				padding: 0;
				margin: 0;
				background-size: 100% 100%;
			}

			.my_threed{
				color: #fafafa;
				letter-spacing: 0;
				text-shadow: 0px 1px 0px #999, 0px 2px 0px #888, 0px 3px 0px #777, 0px 4px 0px #666, 0px 5px 0px #555, 0px 6px 0px #444, 0px 7px 0px #333, 0px 8px 7px #001135 
			}

			.my_press {
				color: transparent;
				background-color : black;
				text-shadow : rgba(255,255,255,0.5) 0 5px 6px, rgba(255,255,255,0.2) 1px 3px 3px;
				-webkit-background-clip : text;
			}

			.my_stroke{
				color: transparent;
				-webkit-text-stroke: 1px black;
				letter-spacing: 0.04em;
				background-color: 
			}

			#my_system_title {
				font-size: 50px !important;
				padding-bottom: 20px;
				text-align: center;
				margin-top: -30px;
				
			}
		
		
		</style>
</head>
<body>
<!-- <form action="login-check.php" method="post" name="myform" onsubmit="return check()"> -->
<form action="" method="post" name="myform" onsubmit="return check()">
	<div class='login'>
	<div id="my_system_title">
	    <span class="my_threed">学工系统</span>
	  </div>
	  <div class='login_title'>
	    <span>管理员登录</span>
	  </div>
	  <div class='login_fields'>
	    <div class='login_fields__user'>
	      <div class='icon'>
	        <img alt="" src='assets/myui/img/user_icon_copy.png'>
	      </div>
	      <input id="username" name="username" placeholder='用户名' maxlength="16" type='text' autocomplete="off" value=""/>
	        <div class='validation'>
	          <img alt="" src='assets/myui/img/tick.png'>
	        </div>
	    </div>
	    <div class='login_fields__password'>
	      <div class='icon'>
	        <img alt="" src='assets/myui/img/lock_icon_copy.png'>
	      </div>
	      <input id="password" name="password" placeholder='密码' maxlength="16" type='password' autocomplete="off">
	      <div class='validation'>
	        <img alt="" src='assets/myui/img/tick.png'>
	      </div>
	    </div>
	    <!--<div class='login_fields__password'>
	      <div class='icon'>
	        <img alt="" src='img/key.png'>
	      </div>
	      <input name="code" placeholder='验证码' maxlength="4" type='text' name="ValidateNum" autocomplete="off">
	      <div class='validation' style="opacity: 1; right: -5px;top: -3px;">
	      </div>
	    </div>-->
	    <div class='login_fields__submit'>
	      <input type='submit' value='登录'>
	    </div>
	  </div>
	  <div class='success'>
	  </div>
	  <div class='disclaimer'>
	    <p></p>
	  </div>
	</div>
</form>
	<!--<div class='authent'>
	  <div class="loader" style="height: 44px;width: 44px;margin-left: 28px;">
        <div class="loader-inner ball-clip-rotate-multiple">
            <div></div>
            <div></div>
            <div></div>
        </div>
        </div>
	  <p>认证中...</p>
	</div>-->
	<div class="OverWindows"></div>
    
	
	<script language="javascript">
function check() {
	if (document.getElementById("username").value == "")
	{
		alert("请输入用户名!");myform.username.focus();return false;
	}

	if (document.getElementById("password").value == "")
	{
		alert("请输入密码!");myform.password.focus();return false;
	}

//	if (document.getElementById("txt_yan").value == "")
//	{
//		alert("请输入验证码!");myform.txt_yan.focus();return false;
//	}
//
//	if (document.getElementById("txt_yan").value != document.getElementById("txt_hyan").value )
//	{
//		alert("验证码不正确");myform.txt_yan.focus();return false;
//	}

}






</script>
	</body>
</html>

<?php
$conn->close();
?>
