<?php $this->load->view('sidebar');?>
        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header page-header-block">
                    <div class="page-header-section">
                        <h4 class="title semibold">Settings</h4>
                    </div>
                </div>
               
                
                <div class="col-lg-3">
                    <h3>Add a new administrator</h3>
        <?php echo form_open('settings/addadmin');
        
        
        ?>
                    
                     <div class="panel-body">
                                         <div class="form-group">
                                    <div class="form-stack has-icon pull-left">
                                        <input name="username" type="text" class="form-control input-lg" placeholder="Username / email" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your username / email" data-parsley-required required>
                                        <i class="ico-user2 form-control-icon"></i>
                                    </div>
                                    <div class="form-stack has-icon pull-left">
                                        <input name="password" type="password" class="form-control input-lg" placeholder="Password" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your password" data-parsley-required required>
                                        <i class="ico-lock2 form-control-icon"></i>
                                    </div>
                                       <div class="form-stack has-icon pull-left">
                                        <input name="repassword" type="password" class="form-control input-lg" placeholder="Retype Password" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your password" data-parsley-required required> 
                                        <i class="ico-lock2 form-control-icon"></i>
                                    </div>
                                </div>

                                <!-- Error container -->
                                <div id="error-container"class="mb15"></div>
                                <!--/ Error container -->
                               
                                
                                <div class="form-group nm">
                                    <button type="submit" class="btn btn-block btn-success" ><span class="semibold">Add</span></button>
                                </div>
                                
                            </div>
                </form>
                    
                </div>
                <!-- Page Header -->

                
            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-marker="#main" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="-50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->

        <!-- START Template Sidebar (right) -->

        <!--/ END Template Sidebar (right) -->
