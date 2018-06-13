<?php
/* $Id: index.php 7341 2015-08-16 05:08:07Z daintree $*/

$PageSecurity=0;

include_once('common/api_log.php');

include('includes/session.inc');
//include('common/common_session.inc');
$Title=_('Main Menu');

include('includes/header.inc');
//include('common/common_header.inc');

/*The module link codes are hard coded in a switch statement below to determine the options to show for each tab */
//include('includes/MainMenuLinksArray.php');

/*========== 未使用，可能是客户或供应商特殊权限的遗留代码，待整理 ==========*/
if (isset($SupplierLogin) AND $SupplierLogin==1){
	echo '<table class="table_index">
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/SupplierTenders.php?TenderType=1">' . _('View or Amend outstanding offers') . '</a></p>
			</td>
			</tr>
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/SupplierTenders.php?TenderType=2">' . _('Create a new offer') . '</a></p>
			</td>
			</tr>
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/SupplierTenders.php?TenderType=3">' . _('View any open tenders without an offer') . '</a></p>
			</td>
			</tr>
		</table>';
	include('includes/footer.inc');
	exit;
} elseif (isset($CustomerLogin) AND $CustomerLogin==1){
	echo '<table class="table_index">
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/CustomerInquiry.php?CustomerID=' . $_SESSION['CustomerID'] . '">' . _('Account Status') . '</a></p>
			</td>
			</tr>
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/SelectOrderItems.php?NewOrder=Yes">' . _('Place An Order') . '</a></p>
			</td>
			</tr>
			<tr>
			<td class="menu_group_item">
				<p>&bull; <a href="' . $RootPath . '/SelectCompletedOrder.php?SelectedCustomer=' . $_SESSION['CustomerID'] . '">' . _('Order Status') . '</a></p>
			</td>
			</tr>
		</table>';

	include('includes/footer.inc');
	exit;
}

//include_once('common/common_menu.inc');

// if (isset($_GET['Application'])){ /*This is sent by this page (to itself) when the user clicks on a tab */
// 	$_SESSION['Module'] = $_GET['Application'];
// }

/*========== 左侧模块菜单栏布局 ==========*/
// echo '
//     <div id="left_menu_body">
//         <div class="layout_button" id="layout_button"></div>
//         <div class="left_body">
//             <div class="left_menu">
//                 <ul>';
// $i=0;
// while ($i < count($ModuleLink))
// {
//     // This determines if the user has display access to the module see config.php and header.inc
//     // for the authorisation and security code
//     if ($_SESSION['ModulesEnabled'][$i]==1)
//     {
//         // If this is the first time the application is loaded then it is possible that
//         // SESSION['Module'] is not set if so set it to the first module that is enabled for the user
//         if (!isset($_SESSION['Module']) OR $_SESSION['Module']=='')
//         {
//             $_SESSION['Module']=$ModuleLink[$i];
//         }

//         if ($ModuleLink[$i] == $_SESSION['Module'])
//         {
//             echo '
//                     <li class="selected">';
//         }
//         else
//         {
//             echo '
//                     <li>';
//         }

//         echo '<a href="' . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '?Application='. $ModuleLink[$i] . '">';

//         /* 图标高亮 */
//         if ($ModuleLink[$i] == $_SESSION['Module'])
//         {
//             echo '<i class="icon icon_' . $ModuleIconList[$i] . '_hv" iType="' . $ModuleIconList[$i] . '"></i> ';
//         }
//         else
//         {
//             echo '<i class="icon icon_' . $ModuleIconList[$i] . '" iType="' . $ModuleIconList[$i] . '"></i> ';
//         }

//         echo '<span>' . $ModuleList[$i] . '</span>';
//         echo '</a></li>';
//     }
//     $i++;
// }

// echo '
//                 </ul>
//             </div>
//         </div>
//     </div>';

/*========== 工作区布局 ==========*/

/*== 导航栏(breadcrumbs) ==*/
// echo '
//     <div id="right_body">
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

/**
 * ========== 开始布局右侧工作区 ==========
 */
// echo '
//                 <div id="right_body">';

/**
 * 右侧工作区顶部面包屑导航栏
 */
//include_once('common/common_right_navigate.inc');

include_once('common/common_center_menu.inc');

/* echo '
    </div>'; */

/**
 * ========== 右侧工作区布局结束 ==========
 */

/*================== 打印所有模块和菜单 ==================*/
// echo '
//     <input type="hidden" value="';

/* 模块列 */
//echo '
//====模块列====';

// $i = 0;
// while ($i < count($ModuleLink))
// {
//     $ModuleID = $ModuleLink[$i];
//     $ModuleCaption = $ModuleList[$i];

//     foreach ($MenuItems[$ModuleID]['Transactions']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $ModuleCaption;
//     }

//     foreach ($MenuItems[$ModuleID]['Reports']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $ModuleCaption;
//     }

//     foreach ($MenuItems[$ModuleID]['Maintenance']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $ModuleCaption;
//     }

//     $i++;
// }

// /* 类型列 */
// echo '
// ====类型列====';

// $i = 0;
// while ($i < count($ModuleLink))
// {
//     $ModuleID = $ModuleLink[$i];
//     $ModuleCaption = $ModuleList[$i];

//     foreach ($MenuItems[$ModuleID]['Transactions']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . '交易';
//     }

//     foreach ($MenuItems[$ModuleID]['Reports']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . '查询及报告';
//     }

//     foreach ($MenuItems[$ModuleID]['Maintenance']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . '维护';
//     }

//     $i++;
// }

// /* 功能列 */
// echo '
// ====功能列====';

// $i = 0;
// while ($i < count($ModuleLink))
// {
//     $ModuleID = $ModuleLink[$i];
//     $ModuleCaption = $ModuleList[$i];

//     foreach ($MenuItems[$ModuleID]['Transactions']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $MenuCaption;
//     }

//     foreach ($MenuItems[$ModuleID]['Reports']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $MenuCaption;
//     }

//     foreach ($MenuItems[$ModuleID]['Maintenance']['Caption'] as $MenuCaption)
//     {
//         echo '
// ' . $MenuCaption;
//     }

//     $i++;
// }

// echo '
//    " />';
///*================== 打印所有模块和菜单 ==================*/

include('includes/footer.inc');
//include('common/common_footer.inc');

function GetRptLinks($GroupID) {
/*
This function retrieves the reports given a certain group id as defined in /reports/admin/defaults.php
in the acssociative array $ReportGroups[]. It will fetch the reports belonging solely to the group
specified to create a list of links for insertion into a table to choose a report. Two table sections will
be generated, one for standard reports and the other for custom reports.
*/
	global $db, $RootPath, $ReportList;
	require_once('reportwriter/languages/en_US/reports.php');
	require_once('reportwriter/admin/defaults.php');
	$GroupID=$ReportList[$GroupID];
	$Title= array(_('Custom Reports'), _('Standard Reports and Forms'));

	$sql= "SELECT id,
				reporttype,
				defaultreport,
				groupname,
				reportname
			FROM reports
			ORDER BY groupname,
					reportname";
	$Result=DB_query($sql,'','',false,true);
	$ReportList = '';
	while ($Temp = DB_fetch_array($Result)) {
		$ReportList[] = $Temp;
	}
	$RptLinks = '';
	for ($Def=1; $Def>=0; $Def--) {
        $RptLinks .= '<li class="menu_group_headers">';
        $RptLinks .= '<b>' .  $Title[$Def] . '</b>';
        $RptLinks .= '</li>';
		$NoEntries = true;
		if ($ReportList) { // then there are reports to show, show by grouping
			foreach ($ReportList as $Report) {
				if ($Report['groupname']==$GroupID AND $Report['defaultreport']==$Def) {
                    $RptLinks .= '<li class="menu_group_item">';
					$RptLinks .= '<p>&bull; <a href="' . $RootPath . '/reportwriter/ReportMaker.php?action=go&amp;reportid=' . $Report['id'] . '">' . _($Report['reportname']) . '</a></p>';
					$RptLinks .= '</li>';
					$NoEntries = false;
				}
			}
			// now fetch the form groups that are a part of this group (List after reports)
			$NoForms = true;
			foreach ($ReportList as $Report) {
				$Group=explode(':',$Report['groupname']); // break into main group and form group array
				if ($NoForms AND $Group[0]==$GroupID AND $Report['reporttype']=='frm' AND $Report['defaultreport']==$Def) {
                    $RptLinks .= '<li class="menu_group_item">';
					$RptLinks .= '<img src="' . $RootPath . '/css/' . $_SESSION['Theme'] . '/images/folders.gif" width="16" height="13" alt="" />&nbsp;';
					$RptLinks .= '<p>&bull; <a href="' . $RootPath . '/reportwriter/FormMaker.php?id=' . $Report['groupname'] . '"></p>';
					$RptLinks .= $FormGroups[$Report['groupname']] . '</a>';
					$RptLinks .= '</li>';
					$NoForms = false;
					$NoEntries = false;
				}
			}
		}
		if ($NoEntries) $RptLinks .= '<li class="menu_group_item">' . _('There are no reports to show!') . '</li>';
	}
	return $RptLinks;
}

?>