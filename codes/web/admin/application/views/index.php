
<script type="text/javascript">
   
    $('.selectall').click(function() {
    if ($(this).is(':checked')) {
        $('div input').attr('checked', true);
    } else {
        $('div input').attr('checked', false);
    }
});
    </script>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
      <?php echo $this->load->view('sidebar');?>
        <!--/ END Template Sidebar (Left) -->

        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header page-header-block">
                    <div class="page-header-section">
                        <h4 class="title semibold">Dashboard <?php echo $check;?></h4>
                    </div>
                    <div class="page-header-section">
                        <!-- Toolbar -->
                        <div class="toolbar clearfix">
                          
                            <div class="col-xs-14">
                                <button class="btn btn-primary pull-right" onclick="location.reload();"><i class="ico-loop4 mr5"></i>Update</button>
                            </div>
                        </div>
                        <!--/ Toolbar -->
                    </div>
                </div>
                <!-- Page Header -->

                <div class="row">
                    <!-- START Left Side -->
                    <div class="col-md-9">
                        <!-- Top Stats -->
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- START Statistic Widget -->
                                <div class="table-layout animation delay animating fadeInDown">
                                    <div class="col-xs-4 panel bgcolor-info">
                                        <div class="ico-users3 fsize24 text-center"></div>
                                    </div>
                                    <div class="col-xs-8 panel">
                                        <div class="panel-body text-center">
                                            <h4 class="semibold nm"><?php echo $user_count_today;?></h4>
                                            <p class="semibold text-muted mb0 mt5">New Users for the day</p>
                                        </div>
                                    </div>
                                </div>
                                <!--/ END Statistic Widget -->
                            </div>
                            <div class="col-sm-4">
                                <!-- START Statistic Widget -->
                                <div class="table-layout animation delay animating fadeInUp">
                                    <div class="col-xs-4 panel bgcolor-teal">
                                        <div class="ico-crown fsize24 text-center"></div>
                                    </div>
                                    <div class="col-xs-8 panel">
                                        <div class="panel-body text-center">
                                            <h4 class="semibold nm"><?php echo $male_count_today;?></h4>
                                            <p class="semibold text-muted mb0 mt5">Male new users for the day</p>
                                        </div>
                                    </div>
                                </div>
                                <!--/ END Statistic Widget -->
                            </div>
                            <div class="col-sm-4">
                                <!-- START Statistic Widget -->
                                <div class="table-layout animation delay animating fadeInDown">
                                    <div class="col-xs-4 panel bgcolor-primary">
                                        <div class="ico-box-add fsize24 text-center"></div>
                                    </div>
                                    <div class="col-xs-8 panel">
                                        <div class="panel-body text-center">
                                            <h4 class="semibold nm"><?php echo $female_count_today;?></h4>
                                            <p class="semibold text-muted mb0 mt5">Female new users for the day</p>
                                        </div>
                                    </div>
                                </div>
                                <!--/ END Statistic Widget -->
                            </div>
                        </div>
                        <!--/ Top Stats -->

                        <!-- Website States -->
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- START panel -->
                                <div class="panel mt10">
                                    <!-- panel-toolbar -->
                                    <div class="panel-heading">
                                        <div class="panel-toolbar">
                                            <h5 class="semibold nm ellipsis">Website States</h5>
                                        </div>
                                        <div class="panel-toolbar text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-default">Duration</button>
                                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-header">Select duration :</li>
                                                    <li><a href="#">Year</a></li>
                                                    <li><a href="#">Month</a></li>
                                                    <li><a href="#">Week</a></li>
                                                    <li><a href="#">Day</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ panel-toolbar -->
                                    <!-- panel-body -->
                                    <div class="panel-body pt0">
                                        <div class="chart mt10" id="chart-audience" style="height:250px;"></div>
                                    </div>
                                    <!--/ panel-body -->
                                    <!-- panel-footer -->
                                    <div class="panel-footer hidden-xs">
                                        <ul class="nav nav-section nav-justified">
                                            <li>
                                                <div class="section">
                                                    <h4 class="bold text-default mt0 mb5"><?php echo $user_count_today;?></h4>
                                                    <p class="nm text-muted">
                                                        <span class="semibold">New reported users of the day</span>
                                                       
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="section">
                                                    <h4 class="bold text-default mt0 mb5"><?php echo $chat_count;?></h4>
                                                    <p class="nm text-muted">
                                                        <span class="semibold">Messages exchanged</span>
                                                       
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="section">
                                                    <h4 class="bold text-default mt0 mb5">89.96%</h4>
                                                    <p class="nm text-muted">
                                                        <span class="semibold">Bounce Rate</span>
                                                        
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--/ panel-footer -->
                                </div>
                                <!--/ END panel -->
                            </div>
                        </div>
                        <!--/ Website States -->

                      
                    </div>
                    <!--/ END Left Side -->

                    <!-- START Right Side -->
                    <div class="col-md-3">
                        <div class="panel panel-minimal">
                            <div class="panel-heading"><h5 class="panel-title"><i class="ico-health mr5"></i>Latest Activity</h5></div>
                        
                            <!-- Media list feed -->
                            <ul class="media-list media-list-feed nm">

                               <?php 
                               $i=0;
                               foreach($users_list as $user){

                                if (++$i == 6) break;
echo "<li class='media'>
 <div class='media-object pull-left'>
                                       <img src='".$user->Profile_Pic_Url."'>
                                    </div>
                                    <div class='media-body'>
                                        <p class='media-heading'>".$user->First_Name." ".$user->Last_Name."</p>
                                        <p class='media-text'><span class='text-primary semibold'>".$user->Email."</span></p>
                                        <p class='media-meta'>".$user->Create_Dt."</p>
                                    </div>
                                </li>";
}

?>
                            </ul>
                            <!--/ Media list feed -->
                        </div>
                    </div>
                    <!--/ END Right Side -->
                </div>
            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-marker="#main" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="-50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->

        <!-- START Template Sidebar (right) -->
      
        <!--/ END Template Sidebar (right) -->

       