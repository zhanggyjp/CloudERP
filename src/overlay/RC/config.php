<?php

// User configurable variables
//---------------------------------------------------

// Default language to use for the login screen and the setup of new users.
$DefaultLanguage = 'zh_CN.utf8';

// Default theme to use for the login screen and the setup of new users.
/* 暂时取消用户界面多风格，改为标准版 */
/* $DefaultTheme = 'professional'; */
$DefaultTheme = 'newtouch';

// Whether to display the demo login and password or not on the login screen
$AllowDemoMode = FALSE;

// Connection information for the database
// $host is the computer ip address or name where the database is located
// assuming that the we.1bserver is also the sql server
$host = 'localhost';

// assuming that the web server is also the sql server
$DBType = 'mysqli';
//assuming that the web server is also the sql server
$DBUser = 'root';
$DBPassword = '~47yb9pt*M4';
// The timezone of the business - this allows the possibility of having;
date_default_timezone_set('Asia/Shanghai');
putenv('TZ=Asia/Shanghai');
$AllowCompanySelectionBox = 'ShowSelectionBox';
//The system administrator name use the user input mail;
$SysAdminEmail = '';
$DefaultDatabase = 'weberp';
$SessionLifeTime = 3600;
$MaximumExecutionTime = 120;
$DefaultClock = 12;
$RootPath = dirname(htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8'));
if (isset($DirectoryLevelsDeep)){
   for ($i=0;$i<$DirectoryLevelsDeep;$i++){
		$RootPath = mb_substr($RootPath,0, strrpos($RootPath,'/'));
	}
}
if ($RootPath == '/' OR $RootPath == '\\') {
	$RootPath = '';
}
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//Installed companies 
$CompanyList[0] = array('database'=>'weberp' ,'company'=>'新致软件股份有限公司' );
$CompanyList[1] = array('database'=>'weberpdemo' ,'company'=>'WebERP Demo Company' );
//End Installed companies-do not change this line
/* Make sure there is nothing - not even spaces after this last ?> */

/**
 * 是否开放用户管理功能
 */
$IsUserManagerEnable = true;

/*==== Portal单点登录相关配置 ====*/
/* 启用Portal认证模式 */
$IsPortalEnable = true;
/* 内置系统管理员账号 */
$SysAdmin="admin";

/* Portal认证接口地址 */
$PortalBaseUrl = "http://103.36.173.184:8080/ecloud/oapi/token";
/* Portal认证失败时，是否显示详细信息 */
$IsShowPortalDebugMsg = true;

/* 测试AppClient参数 */
$ClientID = "demoerp";
$ClientSecret = "demoerpsecret";
//$RedirectUrl = "http://localhost?cb";
$RedirectUrl = "http://218.245.66.222/PortalLogin.php";

/* 调试模式，使用测试Portal用户认证 */
$PortalDebugMode = false;
/* Portal测试用户 */
$PortalTestUserName = "222@rr.com";
/* Portal测试用户密码 */
$PortalTestUserPassword = "123321";
/* Portal长效Code */
$PortalTestCode = "864e6dc6a83fdb519be0d1c754f8255d916b2787";
/*==== 单点登录相关配置结束 ====*/

?>