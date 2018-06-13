<?php
/**
 * 右侧工作区顶部面包屑导航栏
 */
echo '
        <div id="right_navigate">
            <ul class="fleft">
                <li>' . _('Main Menu') . '</li>
                <li>&gt;</li>
                <li>' . $ModuleList[array_search($_SESSION['Module'], $ModuleLink)] . '</li>
            </ul>
            <ul class="fright">
                <li>' . stripslashes($_SESSION['UsersRealName']) . '</li>
                <li> | </li>
                <li>' . date('Y-m-d') . '</li>
            </ul>
        </div>';
?>