<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());

$shotcutIcon = "icon";
$shotcutText = "Bangbon Forklift";
$systemName = "Bangbon Forklift";

/* Config */
$enableCalendar = TRUE;
$enableNotice = TRUE;
$enableAcl = TRUE;

/* Calendar */
$calDay = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
$calStartDay = 0;
$calToday = date('Y-m-d');
$calBeginWeek = date('Y-m-d', strtotime("last {$calDay[$calStartDay]}", strtotime($calToday)));

/* Variable left menu
$menus = [];
*/
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<title><?php echo $shotcutText ?></title>
	
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap/bootstrap.min');
		echo $this->Html->css('bootstrap/bootstrap-datetimepicker.min');
		echo $this->Html->css('sbAdmin2/metisMenu/metisMenu.min');
		echo $this->Html->css('sbAdmin2/font-awesome/font-awesome.min');
		echo $this->Html->css('sbAdmin2/sb-admin-2');
        echo $this->Html->css('selectSearch/immybox');
        echo $this->Html->css('custom');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		echo $this->Html->script('jquery.min'); //Version 1.11.2
		echo $this->Html->script('bootstrap/moment.min');
		//echo $this->Html->script('bootstrap/locale/th');
		echo $this->Html->script('bootstrap/bootstrap.min');
		echo $this->Html->script('bootstrap/bootstrap-datetimepicker.min');
		echo $this->Html->script('sbAdmin2/metisMenu/metisMenu.min');
        echo $this->Html->script('sbAdmin2/sb-admin-2');
        echo $this->Html->script('selectSearch/jquery.immybox.min');
        if($enableAcl) {
            echo $this->Html->script('js-acl');
        }
	?>
</head>
<body>
    <?php
    if($enableAcl){
        $crt = isset($_SESSION['USER']['crt']) ? json_encode($_SESSION['USER']['crt'], JSON_UNESCAPED_UNICODE) : '';
        echo "<div id='acl-crt' value='{$crt}' hidden></div>";
    }
    ?>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top hidden-print" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                <a tabindex="-1" class="navbar-brand" href="#"><?php echo $systemName; ?></a>
			</div>

			<ul class="nav navbar-top-links navbar-right hidden-xs hidden-sm">
				<?php if(isset($_SESSION['USER'])){ ?>
					<?php if($enableNotice){ ?>
					<!-- /.Notify -->
					<li id="nav-notice" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-bell fa-fw"></i><span class="badge">0</span>
						</a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php
                            if(empty($notices)){
                                echo '<li style="text-align:center;">No notification</li>';
                            }else{
                                foreach($notices as $notice){
                                    $link = $notice['link'];
                                    $msg  = $notice['msg'];
                                    $time  = $notice['time'];
                                    echo "
                                        <li>
                                            <a href='{$link}'>
                                                <div>
                                                    {$msg} <span class='pull-right text-muted small'>{$time}</span>
                                                </div>
                                            </a>
                                        </li><li class='divider'></li>";
                                }
                            }
                            ?>
                        </ul>
					<?php } ?>
					<!-- /.Notify -->
                
					<!-- /.User Info for desktop-->
					<li class="dropdown">
						<a id="nav-user" class="dropdown-toggle" data-toggle="dropdown" href="#">
							<?php 
                                $name = $_SESSION['USER']['name'];
                                if(!empty($_SESSION['USER']['pic']) && file_exists(IMAGES . $_SESSION['USER']['pic'])){
                                    $pic = $_SESSION['USER']['pic'];
                                }else{
                                    $pic = '/img/users/default.png';
                                }
                                //$pic = $this->Html->image($pic, array('class'=>'img-rounded nav-user-pic'));
                                $pic = '<i class="fa fa-user fa-fw"></i>';
                                echo "<small>{$name}</small> {$pic}";
                            ?>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<a href="/User/view/<?php echo $_SESSION['USER']['id'] ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-key fa-fw"></i> Change Password</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
							</li>
							<li class="divider"></li>
							<li><a href="/Authens/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
							</li>
						</ul>
					</li>
					<!-- /.User Info for desktop-->

				<?php }else{ ?>
					<!-- /.Guest -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							Guest <i class="fa fa-user fa-fw"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
						</ul>
					</li>
					<!-- /.Guest -->
				<?php } ?>
			</ul>
			
			<!-- /.Left Menu -->
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
					
						<?php if(isset($_SESSION['USER'])){ ?>
						<!-- /.Left Menu User info for mobile -->
                        <li class="dropdown visible-xs visible-sm hidden-md hidden-lg" style="text-align: center;">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<?php echo $_SESSION['USER']['name'] . ' ' . (!empty($_SESSION['USER']['pic']) ? $this->Html->image($_SESSION['USER']['pic'], array('alt' => $_SESSION['USER']['name'], 'class'=>'img-circle')) : '<i class="fa fa-user fa-fw"></i>'); ?>
							</a>
						</li>
						<?php }else{ ?>
						<li class="hidden-md hidden-lg">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="text-align: center;">
								Guest <i class="fa fa-user fa-fw"></i>
							</a>
						</li>
						<?php } ?>
						<!-- /.Left Menu User info for mobile -->
						
						<!-- /.Left Menu Calendar -->
						<?php if($enableCalendar){ ?>
                        <li class="hidden-xs hidden-sm">
							<table class="table home-calendar">
								<tr class='cal-header'><td colspan=7><?php echo date("j F, Y", strtotime($calToday)); ?></td></tr>
								<tr class='cal-day'>
									<?php
										$w = date('w', strtotime($calToday));
										for($i = $calStartDay; $i < $calStartDay+7; $i++){
											switch($i%7){
												case 0: $class = "class = 'cal-sunday'";break;
												case 6: $class = "class = 'cal-satday'";break;
												default: $class = "";break;
											}
											echo "<td {$class}>{$calDay[$i%7]}</td>"; 
										}
									?>
								</tr>
								<tr class='cal-date'>
									<?php
										$d = date('d', strtotime($calToday));
										for($i = 0; $i < 7; $i++){
											$date = date('d', strtotime("+ {$i} days", strtotime($calBeginWeek)));
											$class_today = ($d == $date) ? "class = 'cal-today'" : "";
											echo "<td {$class_today}>" . (int)$date . "</td>"; 
										}
									?>
								</tr>
							</table>
						</li>
						<?php } ?>
						<!-- /.Left Menu Calendar -->
						
						<!-- /.Left Menu fetch menu -->
						<?php 
						function fetchMenu($menus, $level = 1, $limit = 3){
							
							switch($level+1){
								case 2: $class_lvl =  "nav-second-level";break;
								case 3: $class_lvl =  "nav-third-level";break;
								default: $class_lvl =  "";break;
							}
						
							foreach($menus as $menu){
								$link = $menu['link'];
								$name = $menu['name'];
								$sub = $menu['sub'];
								echo "<li>";
								if($level < $limit && !empty($sub)){
                                    echo "<a href='{$link}'>{$name}<span class='fa arrow'></span></a>";
									echo "<ul class='nav {$class_lvl}'>";
									fetchMenu($sub, $level+1, $limit);
									echo "</ul>";
								}else{
                                    echo "<a href='{$link}'>{$name}</a>";
                                }
								echo "</li>";
							}
						}
						if(!empty($menus)){
							fetchMenu($menus);
						}
						?>
						<!-- /.Left Menu fetch menu -->
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.Left Menu -->
		</nav>
        <div id="page-wrapper">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
        </div>
        <div id="footer-wrapper">Copyright © 2015 TaPoneSoft All Rights Reserved</div>
	</div>
</body>
</html>
<?php //echo $this->element('sql_dump'); ?>



<script>
$(function () {
    $('#page-wrapper').find('input, textarea, select')
        .not('input[type=hidden],input[type=button],input[type=submit],input[type=reset],input[type=image],button')
        .filter(':enabled:visible:first').attr('tabindex', '1');

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover( { trigger: 'hover',html: true } );

    $('#flashMessage').css('left', ($(window).width()/2) - ($('#flashMessage').width()/2) + 'px');
    window.setTimeout(function () {
        // closing the popup
        $('#flashMessage').fadeOut(500, function () {
            $('#flashMessage').alert('close');
        });
    }, 3000);

    /**** Table empty ****/
    if($('.table-data-list tr').length <= 1) {
        $('.table-data-list tr:last').after('<tr><td colspan=100% class="text-center">No data</td></tr>');
    }

    /**** Data format ****/
    $('td.data-money').html(function(index,val){
        return formatMoney(val, 2,',','.' );
    });

    /**** Date Picker ****/
    $('.datePicker').datetimepicker({
        format: 'YYYY-MM-DD',
        showClear: true
    });
    $('.datePicker').each(function(){
        $(this).data("DateTimePicker").ignoreReadonly(true); 
    });
    $('.datePicker-readonly').attr('readonly',true);
    $('.datePicker').focus(function() { $(this).select(); } );
    
    /**** selectSearch ****/
    $('.selectSearch').each(function(){
        var choices = jQuery.parseJSON($(this).attr('data-choices'));
        $(this).immybox({choices: choices});
        $(this).focus(function() { $(this).select(); } );
    });
});


function formatMoney (val, decPlaces, thouSeparator, decSeparator) {
    var n = new Number(val),
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSeparator = decSeparator == undefined ? "." : decSeparator,
        thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};
</script>