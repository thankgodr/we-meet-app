

   
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
                        <h4 class="title semibold">Flamer Users</h4>
                    </div>
                </div>
                <!-- Page Header -->

                <!-- START row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- START panel -->
                        <div class="panel panel-primary">
                            <!-- panel heading/header -->
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="panel-icon mr5"><i class="ico-table22"></i></span>Reported Users</h3>
                                <!-- panel toolbar -->
                                <div class="panel-toolbar text-right">
                                    <!-- option -->
                                    <div class="option">
                                        <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                                        <button class="btn" data-toggle="panelremove" data-parent=".col-md-12"><i class="remove"></i></button>
                                    </div>
                                    <!--/ option -->
                                </div>
                                <!--/ panel toolbar -->
                            </div>
                            <!--/ panel heading/header -->
                            <!-- panel toolbar wrapper -->
                            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                                <div class="panel-toolbar pl10">
                                    <div class="checkbox custom-checkbox pull-left">  
                                        <input type="checkbox" id="customcheckbox" value="1" data-toggle="checkall" data-target="#table1">  
                                        <label for="customcheckbox">&nbsp;&nbsp;Select all</label>  
                                    </div>
                                </div>
                                <div class="panel-toolbar text-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-default"><i class="ico-upload22"></i></button>
                                        <button type="button" class="btn btn-sm btn-default"><i class="ico-archive2"></i></button>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-danger"><i class="ico-remove3"></i></button>
                                </div>
                            </div>
                            <!--/ panel toolbar wrapper -->

                          
                            <!-- panel body with collapse capabale -->
                            <div class="table-responsive panel-collapse pull out">
                                <table class="table table-bordered table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center"><i class="ico-long-arrow-down"></i></th>
                                            
                                            <th>Name</th>
                                            <th>City</th>
                                            <th >Email</th>
                                            <th>Facebook ID</th>
                                            <th width="5%">Device ID</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php 
                                      foreach($users_list as $user){
                                        if($user->City==NULL){
                                            $user->City="Not Available";
                                        }
 echo "<tr>
 <td>
                                                <div class='checkbox custom-checkbox nm'>  
                                                    <input type='checkbox' id='customcheckbox1' value='1' data-toggle='selectrow' data-target='tr' data-contextual='success'>  
                                                    <label for='customcheckbox1'></label>   
                                                </div>
                                            </td>
                                           
                                            <td>".$user->First_Name."</td>
                                            <td>".$user->City."</td>
                                            <td>".$user->Email."</td>
                                            <td>".$user->Fb_Id.".</td>
                                            <td>".$user->Device_Id."</td>
                                            <td class='text-center'>
                                                <!-- button toolbar -->
                                                <div class='toolbar'>
                                                    <div class='btn-group'>
                                                        <button type='button' class='btn btn-sm btn-danger'>Delete</button>
                                                          <button type='button' class='btn btn-sm btn-info'>Suspend</button>
                                                      
                                                    </div>
                                                </div>
                                                <!--/ button toolbar -->
                                            </td>
                                        </tr>";
 
 }
                                     ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--/ panel body with collapse capabale -->
                        </div>
                    </div>
                </div>
                <!--/ END row -->

               
            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-marker="#main" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="-50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->

        <!-- START Template Sidebar (right) -->
        <aside class="sidebar sidebar-right">
            <!-- START Sidebar Content -->
            <section class="content slimscroll">
                <!-- START Sidebar Profile -->
                <!-- Panel -->
                <div class="panel">
                    <!-- thumbnail -->
                    <div class="thumbnail">
                        <!-- media -->
                        <div class="media">
                            <!-- meta -->
                            <span class="meta text-center">
                                <h5 class="semibold mb0">Erich Reyes</h5>
                                <p class="nm"><i class="ico-user7 mr5"></i>Administrator</p>
                            </span>
                            <!-- meta -->
                            <!-- indicator -->
                            <div class="indicator"><span class="spinner"></span></div>
                            <!--/ indicator -->
                            <img data-toggle="unveil" src="image/background/400x250/placeholder.jpg" data-src="image/background/400x250/background3.jpg" alt="Cover" width="100%">
                        </div>
                        <!--/ media -->
                    </div>
                    <!--/ thumbnail -->
                    <!-- panel body -->
                    <div class="panel-body" style="margin-top:-55px;z-index:2;">
                        <ul class="list-unstyled">
                            <li class="text-center">
                                <img class="img-circle" src="image/avatar/avatar7.jpg" alt="" width="75px" height="75px">
                                <br>
                                <!-- dropdown -->
                                <div class="btn-group mt10">
                                    <button type="button" class="btn btn-default"><span class="hasnotification hasnotification-success mr5"></span>Online</button>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Away</a></li>
                                        <li><a href="#">Offline</a></li>
                                        <li><a href="#">Busy</a></li>
                                    </ul>
                                </div>
                                <!--/ dropdown -->
                            </li>
                        </ul>
                    </div>
                    <!--/ panel body -->
                </div>
                <!--/ Panel -->
                <!--/ END Sidebar Profile -->

                <!-- START Sidebar contact -->
                <div class="media-list media-list-contact">
                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar1.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Autumn Barker</span>
                            <span class="media-meta ellipsis">Malaysia</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar2.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Giselle Horn</span>
                            <span class="media-meta ellipsis">Bolivia</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar.png" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Austin Shields</span>
                            <span class="media-meta ellipsis">Timor-Leste</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar.png" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-danger mr5"></span> Caryn Gibson</span>
                            <span class="media-meta ellipsis">Libya</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar3.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Nash Evans</span>
                            <span class="media-meta ellipsis">Honduras</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar4.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Josiah Johnson</span>
                            <span class="media-meta ellipsis">Belgium</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar.png" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Philip Hewitt</span>
                            <span class="media-meta ellipsis">Bahrain</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar5.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-default mr5"></span> Wilma Hunt</span>
                            <span class="media-meta ellipsis">Dominica</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar6.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Noah Gill</span>
                            <span class="media-meta ellipsis">Guatemala</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar8.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> David Fisher</span>
                            <span class="media-meta ellipsis">French Guiana</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar9.jpg" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Samantha Avery</span>
                            <span class="media-meta ellipsis">Jersey</span>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="media">
                        <span class="media-object pull-left">
                            <img src="image/avatar/avatar.png" class="img-circle" alt="">
                        </span>
                        <span class="media-body">
                            <span class="media-heading"><span class="hasnotification hasnotification-success mr5"></span> Madaline Medina</span>
                            <span class="media-meta ellipsis">Finland</span>
                        </span>
                    </a>
                </div>
                <!--/ END Sidebar contact -->
            </section>
            <!--/ END Sidebar Content -->
        </aside>
        <!--/ END Template Sidebar (right) -->
