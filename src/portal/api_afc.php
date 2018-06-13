<?php
/**
 * 生成密码接口
 * 数据同步程序使用
 * method : post
 * param:
 *      clientid
 *      clientsecret
 *      key  ：密码，反序传送
 * return:
 *      反序传送
 */
include_once("../config.php");

function CryptPass($Password)
{
    if (PHP_VERSION_ID < 50500)
    {
        $Salt = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
        $Salt = str_replace('+', '.', $Salt);
        $Hash = crypt($Password, '$2y$10$' . $Salt . '$');
    }
    else
    {
        $Hash = password_hash($Password, PASSWORD_DEFAULT);
    }
    return $Hash;
}

try
{
    if (! isset($_SERVER["REQUEST_METHOD"]))
    {
        echo "null1";
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
        echo "null2";
        return;
    }

    /**
     * 未保证安全，需验证clientid, clientsecret
     */
    if (! isset($_POST["clientid"])
        OR ! isset($_POST["clientsecret"]))
    {
        echo "null3";
        return;
    }

    if ($_POST["clientid"] != $ClientID
        OR $_POST["clientsecret"] != $ClientSecret)
    {
        echo "null4";
        return;
    }

    if (! isset($_POST["key"]))
    {
        echo "null5";
        return;
    }

    $key = $_POST['key'];

    echo strrev(CryptPass(strrev($post)));
}
catch(Exception $ex)
{
    
}
?>