<?php
/* $Id: Login.php 7535 2016-05-20 13:43:16Z rchacon $*/
// Display demo user name and password within login form if $AllowDemoMode is true

//include ('LanguageSetup.php');
if ((isset($AllowDemoMode)) AND ($AllowDemoMode == True) AND (!isset($demo_text))) {
	$demo_text = _('Login as user') .': <i>' . _('admin') . '</i><br />' ._('with password') . ': <i>' . _('weberp') . '</i>' .
		'<br /><a href="../">' . _('Return') . '</a>';// This line is to add a return link.
} elseif (!isset($demo_text)) {
	$demo_text = '';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head lang="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Newtouch ERP</title>
      	<meta charset="utf-8" />
      	<meta name="renderer" content="webkit" />
        <link rel="shortcut icon" href="<?php echo 'css/' . $DefaultTheme ?>/images/favicon.ico" type="image/x-icon" />
    	<link rel="stylesheet" href="css/style-base.css"/>
        <link rel="stylesheet" href="css/content-style.css"/>
        <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    </head>
    <body class="lg_back">
<?php
if (get_magic_quotes_gpc())
{
	echo '<p style="background:white">';
	echo _('Your webserver is configured to enable Magic Quotes. This may cause problems if you use punctuation (such as quotes) when doing data entry. You should contact your webmaster to disable Magic Quotes');
	echo '</p>';
}
?>
        <div class="lg_bg">
            <div class="lg_header">
                <div class="lg_header_box">
                    <img class="fleft" src="img/lg_logo.png" alt=""/>
                    <h2 class="fleft">ERP平台</h2>
                </div>
            </div>
            <div class="lg_content clearfix">
                <div class="lg_left fleft"></div>
                <div class="lg_right fright">
                    <div class="lg_box">
                        <h2>欢迎使用  新致ERP平台软件</h2>

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');?>" method="post">
                        	<input type="hidden" name="FormID" value="<?php echo $_SESSION['FormID']; ?>" />
                        	<input type="hidden" name="LoginFrom" value="app" />
                        	<div><i>测试帐号：admin/123456</i></div>
                        	<div><i>Portal测试帐号：hh@qq.com/123456</i></div>
                        	<!-- 隐藏公司选择 -->
                            <input type="hidden" name="CompanyNameField" value="0" />
<!--                             <input type="hidden" name="CompanyNameField" value="1" /> -->
                            <div class="lg_control user">
                                <input type="text" name="UserNameEntryField" required="required" autofocus="autofocus" maxlength="20"
                                    placeholder="用户名"
                                    value="<?php echo $_COOKIE['login_name'];?>" />
                            </div>
                            <div class="lg_control pass">
                                <input type="password" required="required" name="Password" placeholder="密码"
                                    value="<?php echo $_COOKIE['login_password'];?>" />
                            </div>
                            <div id="demo_text">
                                <?php
                                	if (isset($demo_text))
                                	{
                                		echo $demo_text;
                                	}
                                ?>
                            </div>
                            <div class="lg_infor">
                                <label for="check">
                                    <input type="checkbox" id="check" name="Is_Remember[]"
                                        style="vertical-align: middle;margin-top: -2px;"
                                        value="1" <?php
                                            if ($_COOKIE['is_remember'] == 1)
                                            {
                                                echo 'checked="checked"';
                                            }
                                            else
                                            {
                                                echo "";
                                            }
                                        ?> /> 记住密码
                                </label>
                            </div>
                        	<div id="demo_text"><i>360浏览器请使用极速模式，获得更好体验</i></div>
                            <!--<button class="us_btn lg_btn">登录</button>-->
                            <input type="submit" class="us_btn lg_btn" value="登录" name="SubmitUser">
                            <!-- 暂不开放注册
                            <p class="clearfix">
                                <a href="" class="fleft">忘记密码</a>
                                <a href="" class="fright">立即注册</a>
                            </p>
                            -->
                        </form>
                    </div>
                </div>
            </div>
            <div class="lg_bottom">
                <div class="lg_footer_bg"></div>
                <div style="background: #fafafa;height: 30px;"></div>
                <div class="lg_footer">
<!--
                    <p>© 2014-2017 Newtouch.com  ICP证：沪ICP备10012409号-1<?php echo 'aaabbb' ?></p>
-->
                </div>
            </div>
        </div>
    </body>
</html>