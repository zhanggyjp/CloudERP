<?php
/**
 * 把日志输出到浏览器控制台
 * @param unknown $data
 */
function console_log($data)
{
    echo("<script>try { console.log('" . $data . "'); } catch(e){}</script>\r\n");
}
?>