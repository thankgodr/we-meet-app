
<script type="text/javascript">
    $('#home').addClass('active');
   
</script>
<div id="option1">
        <div class="row tab-content-caption">
          <div class="container">
            <div class="col-md-3 big-text">
              <p>DASHBOARD</p>
            </div>
            <div class="col-md-6 notification-detail">
              <p>Latest User Information</p>
            </div>
            <div class="col-md-2 update-detail">
              <p><i class="icon-refresh"></i> UPDATE</p>
              
            </div>
          </div>
        </div>
        <div class="row content-div">
          <div class="container">
            <div class="col-md-8 welcome-text">
              <div class="chart mt10" id="chart-audience" style="height:270px;"><div class="chart mt10" id="chart-audience" style="height:270px;"></div></div>
            </div>
            <div class="col-md-4 requests">
             
                
                   <?php 
                               $i=0;
                               foreach($users_list as $user){

                                if (++$i == 5) break;
                                
                                echo ' <div class="row">
                                    <div class="col-md-2 request-pic"><img src="'.$user->Profile_Pic_Url.'" alt="fb Photo" style="width:58px;margin-left:-15px;"
></div>
                                    
                                    <div class="col-md-7 request-details">
                                    
                  <p>'.$user->First_Name.' '.$user->Last_Name.'<span class="right"></span></p>
                  <p>'.$user->Create_Dt.'</p>
                </div>

                </div>         
';
                                
                                
                                
                                
                               }
                ?>
                  
                  
                  
                  
                
              
             
             
            </div>
          </div>
        </div>
      </div>