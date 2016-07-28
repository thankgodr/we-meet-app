<style>
table,th,td
{
  
height: 50px;
}
</style>


<script type="text/javascript">
    $('#location_list').addClass('active');
   
</script>

<div id="option3">
        <div class="row tab-content-caption">
          <div class="container">
            <div class="col-md-4 big-text">
              <p>Chekin Place List</p>
            </div>
            <div class="col-md-6 notification-detail">
              <p></p>
            </div>
          </div>
        </div>
        <div class="row editable-options">
        <div class="container">
          <div class="col-md-4">
              Chekin Place List<br>
           <?php echo $this->session->flashdata('message');  ?>
          </div>
        
          <div class="col-md-5">
            
          </div>
          <div class="col-md-3 options-right-icon">
              
              <a href="location"  style="text-decoration: none;"><i class="icon-plus"></i></a>
            
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
          
          <table width="100%" id="table1" class="table-bordered">
              <tr height="10%">
                 
                  <th >
                      NO. 
                      
                  </th>
                  
                  <th>
                      Loc_name
                  </th>
                  <th>
                      Loc_lat
                  </th>
                  <th>
                      Loc_long
                  </th>
                  <th>
                      loc_address
                  </th>
                  <th width="15%">
                        View/Delete
                  </th>
                                      
                  
                  
                  
              </tr>
              <?php
                echo form_open('users/chekin_location_edit');
              
              foreach ($question_list as $question)
                      {
                 
                
                      echo "<tr>";
                      
                     
                      echo "<td >".$question->	id."</td>";
                      echo "<td width='15%'>".$question->Loc_name."</td>";
                        echo "<td  width='12%'>".$question->Loc_lat."</td>";
                          echo "<td width='12%' >".$question->Loc_long."</td>";
                            echo "<td >".$question->loc_address."</td>";
                      
                      echo "<td >";
                     echo '<button type="submit"  value='.$question->id.'  name="delete" onclick = "return confirm(\'Are You Sure Dlete It ?\')"  class="btn btn-nothing">Delete</button>';
                     echo '&nbsp&nbsp';
                     echo '<button type="submit"  value='.$question->id.' name="location"     class="btn btn-green">Edit</button>';
                     echo '&nbsp&nbsp';
                   
                      echo "</td>";
                      
                      
                  echo "</tr>";
                      }
                       echo "  </form>";
              ?>
              
              
          </table>
          
          
         
              
              
              
          </div>
        </div>
      </div>