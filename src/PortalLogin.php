<?php
include_once('config.php');
include_once('portal/api_portal.php');
include_once('common/api_log.php');

/**
 * 验证启用Portal认证模式是否启用
 */
global $IsPortalEnable;
if (! isset($IsPortalEnable) OR ($IsPortalEnable != true))
{
    echo "Portal单点登录未启用，请联系管理员";
    return;
}

/**
 * 获取code授权码参数
 */
$code = $_GET["code"];
if (! isset($code))
{
    echo "缺少授权码参数，无法进行Portal单点登录，请联系管理员";
    return;
}

/**
 * code授权码验证
 * 如果认证通过，开始单点登录
 */
echo '开始Portal授权码认证……';
$result = Portal_CodeValidate($code, $user, $errmsg);

if ($result != true)
{
    if ($IsShowPortalDebugMsg)
    {
        echo "Portal授权码[" . $code . "]认证未通过，登录终止。错误信息：" . $errmsg;
        echo ", PortalBaseUrl=" . $PortalBaseUrl;
        echo ", ClientID=" . $ClientID;
        echo ", ClientSecret=" . $ClientSecret;
        echo ", RedirectUrl=". $RedirectUrl;
        echo ", result=" . $result;
    }
    else 
    {
        echo "Portal授权码认证未通过，登录终止。错误信息：" . $errmsg;
    }

    return;
}

/**
 * 判断Portal用户名是否有效
 */
if (! isset($user->username) OR empty($user->username))
{
    echo "未获得有效的Portal用户名，登录终止";
    return;
}

/*  创建跳转首页url */
if (! isset($RootPath))
{
    $RootPath = dirname(htmlspecialchars($_SERVER['PHP_SELF']));
    if ($RootPath == '/' OR $RootPath == "\\")
    {
        $RootPath = '';
    }
}

$url = $RootPath . "/index.php";

/**
 * 模拟原App登录界面过程，登录前先创建Session.FormID，提交再作为Post参数作为签名
 */
$PostFormID = sha1(uniqid(mt_rand(), true));

/**
 * 以下参数为原App登录界面参数
 * FormID、CompanyNameField、UserNameEntryField
 * 原App登录界面参数password不传入
 * 其他参数为Portal登录新增
 */
echo "<form style='display:none;' id='form1' name='form1' method='post' action='" . $url . "'>
    <input name='LoginFrom' type='text' value='portal' />
    <input name='UserNameEntryField' type='text' value='" . $user->username . "'/>
    <input name='CompanyNameField' type='text' value='0' />
    <input name='FormID' type='text' value='" . $PostFormID . "' />
    <input name='userid' type='text' value='" . $user->id . "'/>
    <input name='companyid' type='text' value='" . $user->companyId . "'/>
    <input name='scope' type='text' value='" . $user->scope . "'/>
</form>
<script type='text/javascript'>function load_submit(){ document.form1.submit() } load_submit();</script>";
?>