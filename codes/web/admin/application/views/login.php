<div class="container">
            <div class="col-lg-12">
                <p class="title_welcome">Welcome to</p>
                <h1 class="title_up"><?php echo APP_NAME;?></h1>
                
                <h5 align="center"><?php echo $this->session->flashdata('message');  ?></h5>
            </div>
            <div class="col-lg-12">
                <p class="logo_img_login"><img src="<?php echo base_url();?>/public/img/logo.png"></p>
            </div>
      <?php echo form_open('login/check');?>
            <div class="col-lg-12 ">
                <div class="col-lg-4 align_center">
                </div>
                <div class="col-lg-4 align_center">
                    <i class="icon-user"></i>
                    <input class="form-control" type="text" required="" data-parsley-required="" data-parsley-error-message="Please fill in your username / email" data-parsley-errors-container="#error-container" placeholder="User name / Email ID" name="username">
                </div>
                <div class="col-lg-4 align_center">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4 align_center">
                </div>
                <div class="col-lg-4 align_center">
                    <i class="icon-lock"></i>
                    <input class="form-control" type="password" required="" data-parsley-required="" data-parsley-error-message="Please fill in your username / email" data-parsley-errors-container="#error-container" placeholder="Password" name="password">
                </div>
                <div class="col-lg-4 align_center">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4 align_center">
                </div>
                <div class="col-lg-4 align_center">
                    <div class="col-xs-6 no_space">
                        <div class="checkbox custom-checkbox">
                            <input id="remember" type="checkbox" value="1" name="remember">
                            <label for="remember" style="color: #FFF;"> &nbsp;Remember me</label>
                        </div>
                    </div>
                    <div class="col-xs-6 no_space text-right">
                        <a href="javascript:void(0);" class="no_link">Lost password?</a>
                    </div>
                </div>
                <div class="col-lg-4 align_center">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-4 align_center">
                </div>
                <div class="col-lg-4 align_center">
                    <div class="col-xs-4 no_space">
                    </div>
                    <div class="col-xs-4 no_space">
                        <div class="checkbox custom-checkbox">
                            <button class="btn btn-block btn-success no_radious" type="submit">
                                <span class="semibold">LOGIN</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-xs-4 no_space">
                    </div>
                </div>
                <div class="col-lg-4 align_center">
                </div>
            </div>
        </div>