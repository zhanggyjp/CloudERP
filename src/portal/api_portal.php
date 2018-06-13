<?php
/**
 * Client证书认证
 */
function client_credentials()
{
    $headers = array
    (
        "Content-type: application/json; charset='utf-8'",
        "Accept: application/json",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
    );
    
    $post_data = array
    (
        "grantType" => "client_credentials",
        "clientId" => $ClientID,
        "clientSecret" => $ClientSecret
    );
    $post_json = json_encode($post_data);
    
    $ch = curl_init($PortalBaseUrl);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * Password认证
 * 在直接登录后认证
 * @username
 * @passowrd
 * @errmsg  错误信息
 * @return
 * true 认证通过
 */
function Portal_PasswordValidate($username, $password, &$errmsg)
{
    global $PortalBaseUrl;
    global $ClientID;
    global $ClientSecret;
    global $PortalDebugMode;
    global $PortalTestUserName;
    global $PortalTestUserPassword;

    $headers = array
    (
        "Content-type: application/json; charset='utf-8'",
        "Accept: application/json",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
    );

    if ($PortalDebugMode)
    {
        /* 调试模式，使用测试用户 */
        $post_data = array
        (
            "grantType" => "password",
            "userName" => $PortalTestUserName,
            "password" => $PortalTestUserPassword,
            "clientId" => $ClientID,
            "clientSecret" => $ClientSecret
        );
    }
    else
    {
        $post_data = array
        (
            "grantType" => "password",
            "userName" => $username,
            "password" => $password,
            "clientId" => $ClientID,
            "clientSecret" => $ClientSecret
        );
    }

    $post_json = json_encode($post_data);

    $ch = curl_init($PortalBaseUrl);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);

    $resultObj = json_decode($result);
    if ($resultObj->client->id == "")
    {
        return false;
    }
    else
    {
        return true;
    }
}

/**
 * 授权码验证
 * 单点登录时认证
 */
function Portal_CodeValidate($code, &$user, &$errmsg)
{
    global $PortalBaseUrl;
    global $ClientID;
    global $ClientSecret;
    global $RedirectUrl;

    $headers = array
    (
        "Content-type: application/json; charset='utf-8'",
        "Accept: application/json",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
    );

    $post_data = array
    (
        "grantType" => "authorization_code",
        "code" => $code,
        "redirectUri" => $RedirectUrl,
        "clientId" => $ClientID,
        "clientSecret" => $ClientSecret
    );

    $post_json = json_encode($post_data);

    $ch = curl_init($PortalBaseUrl);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);

    $resultObj = json_decode($result);

    if ($resultObj->user->id == "")
    {
        if ($PortalDebugMode)
        {
            $user = new StdClass();
            $user->id = "0fd4896cfcc44afe99df2ccefcedc519";
            $user->username = "admin";
            $user->companyId = "dc5fce3e39e141c19fd493032316553d";
            $user->scope = "aa";
            return true;
        }
        return false;
    }

    $user = $resultObj->user;

    return true;
}
?>