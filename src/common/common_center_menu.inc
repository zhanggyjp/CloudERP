<?php
/*== 工作区(layout_content) ==*/

echo '
                <ul id="layout_box">';

/* 面板1-交易/系统设置 */
echo '
                    <li>
                        <dl class="item">';
if ($_SESSION['Module'] != 'system')
{
    echo '
                            <dt class="li_b">' , _('Transactions') , '</dt>';
}
else
{
    echo '
                            <dt class="li_b">' ,  _('General Setup Options') , '</dt>';
}

$i=0;
foreach ($MenuItems[$_SESSION['Module']]['Transactions']['Caption'] as $Caption)
{
    $ScriptNameArray = explode('?', substr($MenuItems[$_SESSION['Module']]['Transactions']['URL'][$i],1));
    $PageSecurity = $_SESSION['PageSecurityArray'][$ScriptNameArray[0]];
    if ((in_array($PageSecurity, $_SESSION['AllowedPageSecurityTokens']) OR !isset($PageSecurity)))
    {
        echo '
                            <dd><a href="' , $RootPath , $MenuItems[$_SESSION['Module']]['Transactions']['URL'][$i] , '">' , $Caption , '</a></dd>';
    }
    $i++;
}

echo '
                        </dl>
                    </li>';

/* 面板2-查询及报告/应收应付设置 */
echo '
                    <li>
                        <dl class="item">';
if ($_SESSION['Module'] != 'system')
{
    echo '
                            <dt class="li_g">' . _('Inquiries and Reports') . '</dt>';
}
else
{
    echo '
                            <dt class="li_g">' .  _('Receivables/Payables Setup') . '</dt>';
}

$i=0;
foreach ($MenuItems[$_SESSION['Module']]['Reports']['Caption'] as $Caption)
{
    $ScriptNameArray = explode('?', substr($MenuItems[$_SESSION['Module']]['Reports']['URL'][$i],1));
    $PageSecurity = $_SESSION['PageSecurityArray'][$ScriptNameArray[0]];

    if ((in_array($PageSecurity, $_SESSION['AllowedPageSecurityTokens']) OR !isset($PageSecurity)))
    {
        echo '
                            <dd><a href="' . $RootPath . $MenuItems[$_SESSION['Module']]['Reports']['URL'][$i] . '">' . $Caption . '</a></dd>';
    }
    $i++;
}

echo '
                        </dl>
                    </li>';

/* 面板3-维护 */
echo '
                    <li>
                        <dl class="item">';
if ($_SESSION['Module'] != 'system')
{
    echo '
                            <dt class="li_o">' . _('Maintenance') . '</dt>';
}
else
{
    echo '
                            <dt class="li_o">' .  _('Inventory Setup') . '</dt>';
}

$i=0;
foreach ($MenuItems[$_SESSION['Module']]['Maintenance']['Caption'] as $Caption)
{
    $ScriptNameArray = explode('?', substr($MenuItems[$_SESSION['Module']]['Maintenance']['URL'][$i],1));
    $PageSecurity = $_SESSION['PageSecurityArray'][$ScriptNameArray[0]];

    if ((in_array($PageSecurity, $_SESSION['AllowedPageSecurityTokens']) OR !isset($PageSecurity)))
    {
        echo '
                            <dd><a href="' . $RootPath . $MenuItems[$_SESSION['Module']]['Maintenance']['URL'][$i] . '">' . $Caption . '</a></dd>';
    }
    $i++;
}


echo '
                        </dl>
                    </li>
                </ul>';
?>