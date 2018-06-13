<?php
/**
 * 主框架页头处理
 * 包含顶部Logo、顶部动态菜单
 */

/* $Id: header.inc 7324 2015-06-20 14:49:56Z rchacon $ */

	// Titles and screen header
	// Needs the file config.php loaded where the variables are defined for
	// $RootPath
	// $Title - should be defined in the page this file is included with
	if (!isset($RootPath)){
		$RootPath = dirname(htmlspecialchars($_SERVER['PHP_SELF']));
		if ($RootPath == '/' OR $RootPath == "\\") {
			$RootPath = '';
		}
	}

	$ViewTopic = isset($ViewTopic)?'?ViewTopic=' . $ViewTopic : '';
	$BookMark = isset($BookMark)? '#' . $BookMark : '';
	$StrictXHTML=False;

	if (!headers_sent()){
		if ($StrictXHTML) {
			header('Content-type: application/xhtml+xml; charset=utf-8');
		} else {
			header('Content-type: text/html; charset=utf-8');
		}
	}
	if($Title == _('Copy a BOM to New Item Code')){//solve the cannot modify heaer information in CopyBOM.php scritps
		ob_start();
	}
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '
<head>
    <meta name="renderer" content="webkit" />
    <link rel="icon" href="', $RootPath, '/css/', $_SESSION['Theme'], '/images/favicon.ico" />
    <link rel="shortcut icon" href="', $RootPath, '/css/', $_SESSION['Theme'], '/images/favicon.ico" />';

	if ($StrictXHTML)
	{
		echo '
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />';
	}
	else
	{
		echo '
	<meta http-equiv="Content-Type" content="application/html; charset=utf-8" />';
	}
    echo '
    <link href="', $RootPath, '/css/print.css" rel="stylesheet" type="text/css" media="print" />
    <link href="', $RootPath, '/css/' , $_SESSION['Theme'] , '/default.css" rel="stylesheet" type="text/css" media="screen"/>';
/*  <meta name="viewport" content="width=device-width, initial-scale=1">//To tell the small device that the website is a responsive site (keep relationship between CSS pixels and device pixels).*/
    echo '
    <link rel="stylesheet" type="text/css" href="' , $RootPath , '/css/style-base.css"/>
    <link rel="stylesheet" type="text/css" href="' , $RootPath , '/css/content-style.css"/>
    <link rel="stylesheet" type="text/css" href="' , $RootPath , '/component/jquery.mCustomScrollbar.css"/>
    <script type="text/javascript" src="' , $RootPath , '/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="' , $RootPath , '/js/index.js"></script>
    <script type="text/javascript" src="' , $RootPath , '/javascripts/MiscFunctions.js"></script>
    <title>', $Title, '</title>
</head>';

    echo '
<body style="background: #f8fbff;">
<div id="common_header_box">
    <div id="common_header">
        <div class="top_left fleft">
            <div class="us_logo"></div>
            <h2>新致ERP平台软件</h2>
        </div>
        <div class="top_menu fright">
    		<ul>
                <li>
                    <i class="icon icon_menus"></i><a href="'.$RootPath.'/index.php"><span>' . _('Main Menu') . '</span></a>
                </li>
                <li>
                    <i class="icon icon_kehu"></i><a href="'.$RootPath.'/open_page.php?page=SelectCustomer"><span>' . _('Customers') . '</span></a>
                </li>
                <li>
                    <i class="icon icon_good"></i><a href="'.$RootPath.'/open_page.php?page=SelectProduct"><span>' . _('Items') . '</span></a>
                </li>
                <li>
                    <i class="icon icon_gys"></i><a href="'.$RootPath.'/open_page.php?page=SelectSupplier"><span>' . _('Suppliers') . '</span></a>
                </li>';

                		$DefaultManualLinkNew = '<a rel="external" accesskey="8" href="' .  $RootPath . '/doc/Manual/ManualContents.php'. $ViewTopic . $BookMark. '"><span>' . _('Manual') . '</span></a>';
                		if (mb_substr($_SESSION['Language'],0,2) != 'en')
                		{
                		    if (file_exists('locale/'.$_SESSION['Language'].'/Manual/ManualContents.php'))
                		    {
                		        $DefaultManualLinkNew = '<a target="_blank" href="'.$RootPath.'/locale/'.$_SESSION['Language'].'/Manual/ManualContents.php'. $ViewTopic . $BookMark. '"><span>' . _('Manual') . '</span></a>';
                		    }
                		}
                		
    echo '
                <li>
                    <i class="icon icon_help"></i>' . $DefaultManualLinkNew . '
                </li>
                <li>
                    <i class="icon icon_lgout"></i><a href="'.$RootPath.'/Logout.php" onclick="return confirm(\''._('Are you sure you wish to logout?').'\');"><span>' . _('Logout') . '</span></a>
                </li>
    		</ul>
		</div>
	</div>
</div>';

    echo '
<div id="common_main">';
?>
