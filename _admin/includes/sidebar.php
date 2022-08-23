<?php
$sql_joining = "SELECT " . suJsonExtract('data', 'joining_date') . "," . suJsonExtract('data', 'working_status') . " FROM clients WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
$result_joining = suQuery($sql_joining);
$joining_date = $result_joining['result'][0]['joining_date'];
$working_status = $result_joining['result'][0]['working_status'];
if ((strtotime($joining_date. ' + 5 days') <= strtotime(date('Y-m-d'))) || $working_status == 'Completed')
{
    $completed = 'yes';
}
else
{
    $completed = 'no';
}
?>
<style>
    .report-btn button{
        padding: 7% 7% 7% 7%;
        /*margin: 1.5% 0% 1.5% 0%;*/
        background-color: transparent;
        color: #fff;
        border: none;
    }
    .report-btn button:hover{
        background-color: #343a40;
        color: #1eb5ae;
        width: 100%;
        display: flex;
        justify-content: start;
        align-items: center;
        border-radius: 0;
    }
    .report-btn .dropdown-menu{
        background-color: transparent;
        width: 100%;
        box-shadow: none;
        border: 0;
        position: inherit;
        float: none;
    }
    .report-btn .dropdown-menu li{
        display: inherit;
        border-bottom: 0;
        border-radius: 0;
    }
    .report-btn .dropdown-menu li{
        background-color: none !important;
    }
</style>
<?php if ($_GET['overlay'] != 1) { ?>
    <div class="col-sm-2 sidebar-area" style="padding:0px;" id="navigation-area">
        <nav>
            <table width="251px" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="100%" id="sidebar-nav">
                        <div>&nbsp;</div>
                        <?php if ($_SESSION[SESSION_PREFIX . 'admin_login'] != '') { ?>
                            <ul>
                                <li>
                                    <a id="lk_home" href="<?php echo ADMIN_URL; ?>index<?php echo PHP_EXTENSION; ?>/home/"><i class="fa fa-home"></i>&nbsp;&nbsp;Home</a>

                                </li>
                                <?php
                                if ($_SESSION[SESSION_PREFIX . 'user_group'][0] != 'Client') { ?>
                                    <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>update<?php echo PHP_EXTENSION; ?>/users/<?php echo $_SESSION[SESSION_PREFIX . 'user_id']; ?>/profile/"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a></li>
                                    <?php
                                }
                                suBuildFormLinks();
                                if ($_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Admin' || $_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Site Admin') { ?>
                                    <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>working_clients<?php echo PHP_EXTENSION; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Working Clients</a></li>
                                    <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>completed_working_clients<?php echo PHP_EXTENSION; ?>/<?php echo $_SESSION[SESSION_PREFIX . 'user_id']; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Completed Work Clients</a></li>
                                    <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>qc_clients<?php echo PHP_EXTENSION; ?>/<?php echo $_SESSION[SESSION_PREFIX . 'user_id']; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;QC Failed Clients</a></li>
                                    <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>blocked_clients<?php echo PHP_EXTENSION; ?>/<?php echo $_SESSION[SESSION_PREFIX . 'user_id']; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Blocked Clients</a></li>
                                <?php } ?>
                                <?php if ($_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Client') { 
                                    if(isset($completed) && $completed == 'yes'){

                                    ?>
                                    <div class="dropdown report-btn">
                                        <button class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bug"></i>&nbsp;&nbsp;Reports
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                               <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>correct_forms<?php echo PHP_EXTENSION; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Correct Forms</a></li>
                                               <li><a id="lk_profile" href="<?php echo ADMIN_URL; ?>incorrect_forms<?php echo PHP_EXTENSION; ?>"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Incorrect Forms</a></li>
                                           </ul>
                                       </div>
                                   <?php } } ?>
                                   <li><a href="<?php echo ADMIN_URL; ?>login<?php echo PHP_EXTENSION; ?>/logout/"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                                   <li><a href="javascript:;"><i class="fa fa-envelope"></i>&nbsp;&nbsp;ascenttechcare@gmail.com</a></li>
                                   <li><a href="javascript:;"><i class="fa fa-phone"></i>&nbsp;&nbsp;9727390487</a></li>
                                   </ul>
                               <?php } ?>
                               <div>&nbsp;</div>
                           </td>
                       </tr>
                   </table>

               </nav>
           </div>
       <?php } ?>
