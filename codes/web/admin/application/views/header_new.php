<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>/public/img/logo.png">
    
    <title><?php echo APP_TITLE;?> Admin</title>
   
    <link href="<?php echo base_url();?>/public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/public/css/responsive-style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/public/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?php echo base_url(); ?>/public/library/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/public/js/map.js"></script>

    
  </head>
  <body>
  <div class="container">
    <div class="row towber-nav">
      <div class="col-md-5 logo">
        <h3><img src="<?php echo base_url();?>/public/img/logo.png" width="40" height="40"> <?php echo APP_NAME;?></h3>
      </div>
      <div class="col-md-2 nav-select">
        <div class="dropdown">
          
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Stranger</a></li>
          </ul>
        </div>
           <?php $attributes = array('method' => 'GET', 'id' => 'myform');
                  echo form_open( base_url().'index.php/users/search', $attributes);?>
      </div>
       
      <div class="col-md-2 nav-search">
        <input type="text" class="form-control"name="q"  placeholder="Search"><i  type='submit' class="icon-search"></i>
      </form>
      </div>
      <div class="col-md-2 nav-admin">
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
           <i class="icon-smile"></i> Hello Admin
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url();?>/index.php/login/logout">Log Out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
   <div class="row second-nav">
    <div class="container">
      <ul class="nav nav-pills">
          
        <li id="home"><a href="<?php echo base_url();?>"><i class="icon-home"></i></a></li>
        
        
        <li id="user"><a href="<?php echo base_url();?>index.php/users" ><i class="icon-male"></i></a></li>
        <li id="question"><a href="<?php echo base_url();?>index.php/users/question"><i class="icon-question"></i></a></li>
        
        

         <li id="setting"><a href="<?php echo base_url();?>index.php/settings"><i class="icon-list-ul"></i></a></li>
        
        <!--
         <li id="location"><a href="<?php echo base_url();?>index.php/users/location"><i class="icon-map-marker"></i></a></li>
         <li id="location_list"><a href="<?php echo base_url();?>index.php/users/chekin_location"><i class="icon-file"></i></a></li>
        <li><a href="test" ><i class="icon-download"></i></a></li>         
        <li><a href="users"><i class="icon-truck"></i></a></li>
        <li><a href="#option5" ><i class="icon-envelope"></i></a></li>
        <li><a href="#option6"><i class="icon-check"></i></a></li>
        <li><a href="#option7" ><i class="icon-phone"></i></a></li>
        <li><a href="#option8" ><i class="icon-file"></i></a></li>
        -->
      </ul>
        
    </div>
  </div>
      
  <div class="row third-portion">
    <div class="tab-content">
        
        
        