

   
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
                                <h3 class="panel-title"><span class="panel-icon mr5"><i class="ico-table22"></i></span>All the users</h3>
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
                            <?php echo form_open('data_controller/delete_user');?>
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

                                    <button type="submit"  onclick="return confirm('Are Your Sure Dlete It ?')" class="btn btn-sm btn-danger"><i class="ico-remove3"></i></button>
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
                                            <th >City</th>
                                            <th >Email</th>
                                            <th>Facebook ID</th>
                                            <th width="5%">Device ID</th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                     <?php 
                                    
                                       //checkbox custom-checkbox nm
                                      foreach($users_list as $user){
                                        if($user->City==NULL){
                                            $user->City="Not Available";
                                        }
 echo "<tr>
 <td>
                                                <div class=''>  
                                                    <input type='checkbox' id='customcheckbox1[]' name='customcheckbox1[]' value='$user->Entity_Id' data-toggle='selectrow' data-target='tr' data-contextual='success'>  
                                                    <label for='customcheckbox1'></label>   
                                                </div>
                                            </td>".
                                          
                                            "<td>".$user->First_Name." ".$user->Last_Name."</td>
                                            <td>".$user->City."</td>
                                            <td>".$user->Email."</td>
                                            <td>".$user->Fb_Id.".</td>
                                            <td>".$user->Device_Id."</td>
                                                <input type='hidden' name='eid' value='".$user->Entity_Id."'>
                                            <td class='text-center'>
                                                <!-- button toolbar -->
                                                <div class='toolbar'>
                                                    <div class='btn-group'>
                                                        <button type='submit' onclick = \"return confirm('Are You Sure Dlete It ?')\"  class='btn btn-sm btn-danger'>Delete</button>
                                                          <button type='button' class='btn btn-sm btn-info'>Suspend</button>
                                                      
                                                    </div>
                                                </div>
                                                <!--/ button toolbar -->
                                            </td>
                                            

                                          
                                        </tr>";
 
 }

 echo "  </form>";
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

        