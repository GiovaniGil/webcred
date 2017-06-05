<?php
use machour\yii2\notifications\widgets\NotificationsWidget;
use yii\helpers\Html;
?>
<header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?=$title?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?=$title?></b> Administrator</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- -->
              <!--<li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-danger notifications-icon-count">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <span class="notifications-header-count">0</span> notifications</li>
                  <li>
                    <div id="notifications"></div>
                  </li>
                </ul>
              </li>-->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-danger notifications-icon-count">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <span class="notifications-header-count">0</span> notifications</li>
                  <li>
                    <ul class="menu">
                      <div id="notifications"></div>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <?PHP


              NotificationsWidget::widget([
                  'theme' => NotificationsWidget::THEME_GROWL,
                  'clientOptions' => [
                      'location' => 'br',
                  ],
                  'counters' => [
                      '.notifications-header-count',
                      '.notifications-icon-count'
                  ],
                  'listSelector' => '#notifications',
                  'xhrTimeout' => 3000
              ]);
              ?>

              <!-- Notifications: style can be found in dropdown.less -->
            <!--  <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><?/*= Yii::t('frontend', 'You have 10 notifications'); */?></li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>-->

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?= Html::img('@web/img/avatar2-160x160.jpg', ['class' => 'user-image', 'alt'=>'User Image']) ?>
                  <span class="hidden-xs"><?= Yii::$app->user->identity->name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?= Html::img('@web/img/avatar2-160x160.jpg', ['class' => 'img-circle', 'alt'=>'User Image']) ?>
                    <p>
                      <?= Yii::$app->user->identity->name; ?>
                      <small>Member since <?= date("d/m/Y", strtotime(Yii::$app->user->identity->created_at)); ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                      <?= Html::a('<i class="fa fa-user" aria-hidden="true"></i> '.Yii::t('frontend','Profile'),
                          ['site/profile'],
                          ['class'=>'btn btn-default btn-flat']); ?>
                    </div>
                    <div class="pull-right">
                      <?= Html::a('Sair '.'<i class="fa fa-sign-out"></i>',
                          ['site/logout'],
                          ['class'=>'btn btn-default btn-flat', //optional* -if you need to add style
                              'data' => ['method' => 'post',]]); ?>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
