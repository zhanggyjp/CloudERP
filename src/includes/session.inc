<?php
/**
 * 主框架Session处理
 * 负责Session处理和登录验证
 */
/* $Id: session.inc 7056 2015-01-02 00:53:14Z rchacon $*/

if (!isset($PathPrefix))
{
	$PathPrefix='';
}

if (!file_exists($PathPrefix . 'config.php')){
	$RootPath = dirname(htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8'));
	if ($RootPath == '/' OR $RootPath == "\\") {
		$RootPath = '';
	}
	header('Location:' . $RootPath . '/install/index.php');
	exit;
}

include($PathPrefix . 'config.php');
include_once($PathPrefix . 'portal/api_portal.php');
include_once($PathPrefix . 'common/api_log.php');

if (isset($dbuser)) { //this gets past an upgrade issue where old versions used lower case variable names
	$DBUser=$dbuser;
	$DBPassword=$dbpassword;
	$DBType=$dbType;
}

if (isset($SessionSavePath)){
	session_save_path($SessionSavePath);
}

if (!isset($SysAdminEmail)) {
	$SysAdminEmail='';
}

ini_set('session.gc_maxlifetime',$SessionLifeTime);

if( !ini_get('safe_mode') ){
	set_time_limit($MaximumExecutionTime);
	ini_set('max_execution_time',$MaximumExecutionTime);
}
session_write_close(); //in case a previous session is not closed
session_start();

/**
 * Portal登录时，PortalLogin.php内创建了Post.FormID，作为Session.FormID使用。
 * 普通App登录时，在打开登录页Login.php时，已完成这一动作，不需要额外处理。
 * 通过判断Post.LoginFrom参数
 */
if (isset($_POST["LoginFrom"]) AND ($_POST["LoginFrom"] == "portal")
    AND isset($_POST['FormID']))
{
    $_SESSION['FormID'] = $_POST['FormID'];
}

include($PathPrefix . 'includes/ConnectDB.inc');
include($PathPrefix . 'includes/DateFunctions.inc');

if (!isset($_SESSION['AttemptsCounter']) OR $AllowDemoMode==true){
	$_SESSION['AttemptsCounter'] = 0;
}

/* iterate through all elements of the $_POST array and DB_escape_string them
to limit possibility for SQL injection attacks and cross scripting attacks
*/
if (isset($_SESSION['DatabaseName']))
{
	foreach ($_POST as $PostVariableName => $PostVariableValue)
	{
		if (gettype($PostVariableValue) != 'array')
		{
			if(get_magic_quotes_gpc())
			{
				$_POST['name'] = stripslashes($_POST['name']);
			}
			$_POST[$PostVariableName] = DB_escape_string($PostVariableValue);
		}
		else
		{
			foreach ($PostVariableValue as $PostArrayKey => $PostArrayValue)
			{
				if(get_magic_quotes_gpc())
				{
					$PostVariableValue[$PostArrayKey] = stripslashes($value[$PostArrayKey]);
				}
				$PostVariableValue[$PostArrayKey] = DB_escape_string($PostArrayValue);
			}
		}
	}

	/* iterate through all elements of the $_GET array and DB_escape_string them
	to limit possibility for SQL injection attacks and cross scripting attacks
	*/
	foreach ($_GET as $GetKey => $GetValue)
	{
		if (gettype($GetValue) != 'array')
		{
			$_GET[$GetKey] = DB_escape_string($GetValue);
		}
	}
}
else
{
    //set SESSION['FormID'] before the a user has even logged in
    $_SESSION['FormID'] = sha1(uniqid(mt_rand(), true));
}

include($PathPrefix . 'includes/LanguageSetup.php');
$FirstLogin = False;

if(basename($_SERVER['SCRIPT_NAME'])=='Logout.php')
{
	header('Location: index.php');
}
elseif (isset($AllowAnyone))
{
    /* only do security checks if AllowAnyone is not true */
	$_SESSION['AllowedPageSecurityTokens'] = array();
	$_SESSION['DatabaseName'] = $DefaultDatabase;
	$_SESSION['CompanyName'] = $DefaultDatabase;
	include_once ($PathPrefix . 'includes/ConnectDB_' . $DBType . '.inc');
	include($PathPrefix . 'includes/GetConfig.php');
}
else
{
    /* App内登录 */
	include $PathPrefix . 'includes/UserLogin.php';	/* Login checking and setup */

	/**
	 * 检查Post参数，如果登录来源是App或Portal，并且已经有登录名等参数，则进入用户名验证。
	 * 具体使用原生应用验证还是Portal验证，在userLogin内判断
	 */
	if (isset($_POST["LoginFrom"]) AND ($_POST["LoginFrom"] == "app")
	    AND isset($_POST['UserNameEntryField']) AND isset($_POST['Password']))
	{
	    /* 普通App登录，需要在登录页上输入密码 */
		$rc = userLogin($_POST['UserNameEntryField'], $_POST['Password'], $SysAdminEmail, $db, $_POST["LoginFrom"]);
		$FirstLogin = true;
	}
	elseif (isset($_POST["LoginFrom"]) AND ($_POST["LoginFrom"] == "portal")
	    AND isset($_POST['UserNameEntryField']))
	{
	    /* Portal单点登录，不传入密码 */
	    $rc = userLogin($_POST['UserNameEntryField'], "", $SysAdminEmail, $db, $_POST["LoginFrom"]);
	    $FirstLogin = true;
	}
	elseif (empty($_SESSION['DatabaseName']))
	{
	    /* 无登录参数，显示登录页面 */
		$rc = UL_SHOWLOGIN;
	}
	else
	{
		$rc = UL_OK;
	}

	/*  Need to set the theme to make login screen nice */
	$Theme = (isset($_SESSION['Theme'])) ? $_SESSION['Theme'] : $DefaultTheme;
	switch ($rc) {
	case  UL_OK; //user logged in successfully
		include($PathPrefix . 'includes/LanguageSetup.php'); //set up the language
		break;

	case UL_SHOWLOGIN:
		include($PathPrefix . 'includes/Login.php');
		exit;

	case UL_BLOCKED:
		die(include($PathPrefix . 'includes/FailedLogin.php'));

	case UL_CONFIGERR:
		$Title = _('Account Error Report');
		include($PathPrefix . 'includes/header.inc');
		echo '<br /><br /><br />';
		prnMsg(_('Your user role does not have any access defined for webERP. There is an error in the security setup for this user account'),'error');
		include($PathPrefix . 'includes/footer.inc');
			exit;

	case  UL_NOTVALID:
		$demo_text = '<font size="3" color="red">' .  _('incorrect password') . ', ' . _('The user/password combination') . _('is not a valid user of the system') . '</font>';
		die(include($PathPrefix . 'includes/Login.php'));

	case  UL_MAINTENANCE:
		$demo_text = '<font size="3" color="red">' .  _('system maintenance') . ', ' . _('webERP is not available right now') . _('during maintenance of the system') . '</font>';
		die(include($PathPrefix . 'includes/Login.php'));

 	case  UL_PORTAL_NOTVALID:
	    /* Portal认证未通过 */
	    $demo_text = '<font size="3" color="red">Portal认证未通过</font>';
	    die(include($PathPrefix . 'includes/Login.php'));

    case  UL_PORTAL_DISABLE:
        /* Portal登录模式未启用 */
        $demo_text = '<font size="3" color="red">Portal登录模式未启用</font>';
        die(include($PathPrefix . 'includes/Login.php'));

    case  UL_PORTAL_NOTUSER:
        /* 不是Portal用户 */
        $demo_text = '<font size="3" color="red">不是有效的Portal用户</font>';
        die(include($PathPrefix . 'includes/Login.php'));
        
	}
}

/*If the Code $Version - held in ConnectDB.inc is > than the Database VersionNumber held in config table then do upgrades */
if (strcmp($Version,$_SESSION['VersionNumber'])>0 AND (basename($_SERVER['SCRIPT_NAME'])!='UpgradeDatabase.php')) {
	header('Location: UpgradeDatabase.php');
}


If (isset($_POST['Theme']) AND ($_SESSION['UsersRealName'] == $_POST['RealName'])) {
	$_SESSION['Theme'] = $_POST['Theme'];
	$Theme = $_POST['Theme'];
} elseif (isset($_SESSION['Theme'])) {
	$Theme = $_SESSION['Theme'];
} else {
	$Theme = $DefaultTheme;
	$_SESSION['Theme'] = '$DefaultTheme';
}


if ($_SESSION['HTTPS_Only']==1){
	if ($_SERVER['HTTPS']!='on'){
		prnMsg(_('webERP is configured to allow only secure socket connections. Pages must be called with https://') . ' .....','error');
		exit;
	}
}



// Now check that the user as logged in has access to the page being called. $SecurityGroups is an array of
// arrays defining access for each group of users. These definitions can be modified by a system admin under setup


if (!is_array($_SESSION['AllowedPageSecurityTokens']) AND !isset($AllowAnyone)) {
	$Title = _('Account Error Report');
	include($PathPrefix . 'includes/header.inc');
	echo '<br /><br /><br />';
	prnMsg(_('Security settings have not been defined for your user account. Please advise your system administrator. It could also be that there is a session problem with your PHP web server'),'error');
	include($PathPrefix . 'includes/footer.inc');
	exit;
}

/*The page security variable is now retrieved from the database in GetConfig.php and stored in the $SESSION['PageSecurityArray'] array
 * the key for the array is the script name - the script name is retrieved from the basename ($_SERVER['SCRIPT_NAME'])
 */
if (!isset($PageSecurity)){
//only hardcoded in the UpgradeDatabase script - so old versions that don't have the scripts.pagesecurity field do not choke
	$PageSecurity = $_SESSION['PageSecurityArray'][basename($_SERVER['SCRIPT_NAME'])];
}


if (!isset($AllowAnyone)){
	if ((!in_array($PageSecurity, $_SESSION['AllowedPageSecurityTokens']) OR !isset($PageSecurity))) {
		$Title = _('Security Permissions Problem');
		include($PathPrefix . 'includes/header.inc');
		echo '<tr>
				<td class="menu_group_items">
					<table width="100%" class="table_index">
						<tr>
							<td class="menu_group_item">
								<b><font style="size:+1; text-align:center;">' . _('The security settings on your account do not permit you to access this function') . '</font></b>
							</td>
						</tr>
					</table>
				</td>
			</tr>';

		include($PathPrefix . 'includes/footer.inc');
		exit;
	}
}

//$PageSecurity = 9 hard coded for supplier access Supplier access must have just 9 and 0 tokens
if (in_array(9,$_SESSION['AllowedPageSecurityTokens']) AND count($_SESSION['AllowedPageSecurityTokens'])==2){
	$SupplierLogin = 1;
} else {
	$SupplierLogin = 0; //false
}
if (in_array(1,$_SESSION['AllowedPageSecurityTokens']) AND count($_SESSION['AllowedPageSecurityTokens'])==2){
	$CustomerLogin = 1;
} else {
	$CustomerLogin = 0;
}
if (in_array($_SESSION['PageSecurityArray']['WWW_Users.php'], $_SESSION['AllowedPageSecurityTokens'])) { /*System administrator login */
	$debug = 1; //allow debug messages
} else {
	$debug = 0; //don't allow debug messages
}

if ($FirstLogin AND !$SupplierLogin AND !$CustomerLogin AND $_SESSION['ShowDashboard']==1) {
	header('Location: ' . $PathPrefix .'Dashboard.php');
}


function CryptPass( $Password ) {
    if (PHP_VERSION_ID < 50500) {
        $Salt = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
        $Salt = str_replace('+', '.', $Salt);
        $Hash = crypt($Password, '$2y$10$' . $Salt . '$');
    } else {
        $Hash = password_hash($Password,PASSWORD_DEFAULT);
    }
    return $Hash;
 }

function VerifyPass($Password,$Hash)
{
    if(PHP_VERSION_ID < 50500)
    {
        return (crypt($Password,$Hash)==$Hash);
    }
    else
    {
        return password_verify($Password,$Hash);
    }
}

/**
 * 判断提交过来的Post请求是否为同一FormID，如果不同视为非法访问
 * Portal访问时，已经把Post.FormID回写入Session.FormID
 */
if (sizeof($_POST) > 0 AND !isset($AllowAnyone))
{
	/*Security check to ensure that the form submitted is originally sourced from webERP with the FormID = $_SESSION['FormID'] - which is set before the first login*/
	if (!isset($_POST['FormID']) OR ($_POST['FormID'] != $_SESSION['FormID']))
	{
		$Title = _('Error in form verification');
		include('includes/header.inc');
		prnMsg(_('This form was not submitted with a correct ID') , 'error');
		include('includes/footer.inc');
		exit;
	}
}
?>