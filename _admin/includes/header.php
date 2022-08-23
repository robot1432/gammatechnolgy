<?php include('modal.php'); ?>
<header>
    <div class="row header-top"> 
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12  border-left-0">
            <h1 class="top-nav text-white"><?php echo $getSettings['site_name']; ?></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 d-flex justify-content-end pr-5">
            <div class="top-right">
                <?php if ($getSettings['show_profile_picture'] == 1 && $_SESSION[SESSION_PREFIX . 'user_photo'] != '' && file_exists(ADMIN_UPLOAD_PATH . urldecode($_SESSION[SESSION_PREFIX . 'user_photo']))) { ?>
                <img src="<?php echo BASE_URL . 'files/' . urldecode($_SESSION[SESSION_PREFIX . 'user_photo']); ?>">
                <?php } else { ?>
                    <i class="fa fa-user user_icon"></i> 
                <?php } ?>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle btn-theme" type="button" data-toggle="dropdown"><?php echo $_SESSION[SESSION_PREFIX . 'user_name']; ?>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="<?php echo ADMIN_URL; ?>login<?php echo PHP_EXTENSION; ?>/logout/">Logout</a></li>
                      </ul>
                  </div>
              </div>
         </div>

     </div>
 </header>
