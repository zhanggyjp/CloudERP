<?php
/**
 * 构建主框架左侧菜单
 */

/* 引入主菜单配置项 */
include('includes/MainMenuLinksArray.php');

if (isset($_GET['Application'])){ /*This is sent by this page (to itself) when the user clicks on a tab */
    $_SESSION['Module'] = $_GET['Application'];
}

/* 创建左侧菜单 */
echo '
    <div id="left_menu_body">
        <div class="layout_button" id="layout_button"></div>
        <div class="left_body">
            <div class="left_menu">
                <ul>';
$i=0;
while ($i < count($ModuleLink))
{
    // This determines if the user has display access to the module see config.php and header.inc
    // for the authorisation and security code
    if ($_SESSION['ModulesEnabled'][$i]==1)
    {
        // If this is the first time the application is loaded then it is possible that
        // SESSION['Module'] is not set if so set it to the first module that is enabled for the user
        if (!isset($_SESSION['Module']) OR $_SESSION['Module']=='')
        {
            $_SESSION['Module']=$ModuleLink[$i];
        }

        if ($ModuleLink[$i] == $_SESSION['Module'])
        {
            echo '
                    <li class="selected">';
        }
        else
        {
            echo '
                    <li>';
        }

        echo '<a href="' . $RootPath . '/index.php?Application='. $ModuleLink[$i] . '">';
        
        /* 图标高亮 */
        if ($ModuleLink[$i] == $_SESSION['Module'])
        {
            echo '<i class="icon icon_' . $ModuleIconList[$i] . '_hv" iType="' . $ModuleIconList[$i] . '"></i> ';
        }
        else
        {
            echo '<i class="icon icon_' . $ModuleIconList[$i] . '" iType="' . $ModuleIconList[$i] . '"></i> ';
        }

        echo '<span>' . $ModuleList[$i] . '</span>';
        echo '</a></li>';
    }
    $i++;
}

echo '
                </ul>
            </div>
        </div>
    </div>';
?>