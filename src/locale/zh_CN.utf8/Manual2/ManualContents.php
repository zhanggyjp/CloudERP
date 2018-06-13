<!DOCTYPE html>
<html>
<?php
/**
 * 加载用户手册公用页头，包括标题
 */
include("ManualHeader.inc");
?>

<?php
/**
 * 加载用户手册内容
 */
if (isset($_GET['ViewTopic']) AND ! empty($_GET['ViewTopic']))
{
    /**
     * 具体内容页
     */
    include($_GET['ViewTopic']);
}
else
{
    /**
     * 加载首页目录
     */
    include("ManualMenu.inc");
}
?>

<?php
/**
 * 加载用户手册公用页脚
 */
include("ManualFooter.inc");
?>
</html>