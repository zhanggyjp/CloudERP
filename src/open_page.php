<?php
$PageSecurity=0;

include_once('common/common_session.inc');
include_once('common/common_header.inc');
include_once('common/common_menu.inc');

// echo '
//     <div class="right_body">
//         <div class="right_navigate">
//             <ul class="fleft">
//                 <li>' . _('Main Menu') . '</li>
//                 <li>&gt;</li>
//                 <li>' . $ModuleList[array_search($_SESSION['Module'], $ModuleLink)] . '</li>
//             </ul>
//             <ul class="fright">
//                 <li>' . stripslashes($_SESSION['UsersRealName']) . '</li>
//                 <li> | </li>
//                 <li>' . date('Y-m-d') . '</li>
//             </ul>
//         </div>';

/**
 * ========== 开始布局右侧工作区 ==========
 */
echo '
    <div id="right_body">';

/**
 * 右侧工作区顶部面包屑导航栏
 */
include_once('common/common_right_navigate.inc');

//         <div id="right_navigate">
//             <ul class="fleft">
//                 <li>' . _('Main Menu') . '</li>
//                 <li>&gt;</li>
//                 <li>' . $ModuleList[array_search($_SESSION['Module'], $ModuleLink)] . '</li>
//             </ul>
//             <ul class="fright">
//                 <li>' . stripslashes($_SESSION['UsersRealName']) . '</li>
//                 <li> | </li>
//                 <li>' . date('Y-m-d') . '</li>
//             </ul>
//         </div>';
echo '
        <div id="right_content_fun"
            <div id="right_layout_fun">';

/**
 * 功能页面
 */
if (isset($_GET['page']))
{
    include($_GET['page'] . '.php');
}


echo '
            </div>
        </div>      
    </div>';
/**
 * ========== 右侧工作区布局结束 ==========
 */

/* close right_layout_fun */
/* close right_content_fun */
/* close right_body */

include_once('common/common_footer.inc');
?>