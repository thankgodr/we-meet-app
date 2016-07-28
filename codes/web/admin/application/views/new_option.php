<style>
table,th,td
{
  
height: 50px;
}
</style>

<script type="text/javascript">
    $('#question').addClass('active');
   
</script>

<div id="option3">
        <div class="row tab-content-caption">
          <div class="container">
            <div class="col-md-4 big-text">
              <p>Option List</p>
            </div>
            <div class="col-md-6 notification-detail">
              <p></p>
            </div>
          </div>
        </div>
        <div class="row editable-options">
        <div class="container">
          <div class="col-md-10">
           <?php 
                                 foreach ($option_list as $question)
                                     {
                                    $ques= $question->question;
                                     }
                                     if(!empty($option_list))
                                      echo '<h4>'.$ques.'</h4>';
                                     
                                     ?>
          </div>
         
          
         
          <div class="col-md-2 options-right-icon">
              
              <?php
                                         foreach($option_list as $option)
                                         {
                                            $view_id = $option->d_id;
                                         }?>  
              
              <a href="option_add/<?php echo  $view_id;?>"><i class="icon-plus"></i></a>
            
          </div>
        </div>
        </div>
        <div class="row editable-content-div">
          <div class="container">
          <div class="col-md-8">

          </div>
          <div class="col-md-2">
          </div>
              
              
              
              
          <!--<div class="col-md-1">
            <button class="btn btn-nothing">Delete</button>
          </div>
          <div class="col-md-1">
            <button class="btn btn-green">Decline</button>
          </div>-->
          <div class="col-md-1">
          
          </div>
          
          <table width="100%" id="table1" class="table-bordered" >
              <tr height="10%">
                 
                  <th width="3%">
                      NO. 
                      
                  </th>
                  
                  <th>
                    Question id
                  </th>
                  <th>
                    Answers
                  </th>
                  <th width="15%">
                        View/Delete
                  </th>
                                      
                  
                  
                  
              </tr>
              <?php
                echo form_open('users/edit_option');
              
              foreach ($option_list as $option)
                      {
                 
                
                      echo "<tr>";
                     
                     echo "<input type='hidden' name='q_id' value='".$option->d_id."'>";
                     
                      echo "<td>".$option->id."</td>";
                        echo "<td>". $option->d_id."</td>";
                     
                      echo "<td width='50%'>".$option->detail_option."</td>";
                      
                      echo "<td >";
                     echo '<button type="submit"  value='.$option->id.'  name="delete_id" id="delete_id" onclick = "return confirm(\'Are You Sure Dlete It ?\')"  class="btn btn-nothing">Delete</button>';
                     echo '&nbsp&nbsp';
                     echo '<button type="submit" value='.$option->id.' name="option_id"     class="btn btn-green">Edit</button>';
                    
                      echo "</td>";
                      
                      
                  echo "</tr>";
                      }
                       echo "  </form>";
              ?>
              
              
          </table>
          
          
         
              
              
              
          </div>
        </div>
      </div>