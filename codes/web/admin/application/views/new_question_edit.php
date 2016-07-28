
<script type="text/javascript">
    $('#question').addClass('active');
   
</script>

<div id="option3">
        <div class="row tab-content-caption">
          <div class="container">
            <div class="col-md-4 big-text">
              <p>Question List</p>
            </div>
            <div class="col-md-6 notification-detail">
              <p></p>
            </div>
          </div>
        </div>
        <div class="row editable-options">
        <div class="container">
          <div class="col-md-2">
           Question List
          </div>
          <div class="col-md-1">
           
          </div>
          <div class="col-md-1">
           
          </div>
          <div class="col-md-5">
            
          </div>
          <div class="col-md-3 options-right-icon">
              
            <i class="icon-plus"></i>
            
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
              <tr>
                 
                  <th width="3%">
                      NO. 
                      
                  </th>
                  
                  <th>
                      Question
                  </th>
                  <th>
                        View/Delete
                  </th>
                                      
                  
                  
                  
              </tr>
              <?php
                echo form_open('users/update_question');
              
              foreach ($question_edit as $question)
                      {
                 
                
                      echo "<tr>";
                     
                      echo "<input type='hidden' name='q_id' value='".$question->d_id."'>";
                     
                      echo "<td>".$question->d_id."</td>";
                      echo "<td><textarea  rows='4' cols='50' name='questionlist'>$question->details_ques</textarea></td>";
                      
                      echo "<td >";
                  
                     echo '<button type="submit"  value='.$question->d_id.' name="question"     class="btn btn-green">Update</button>';
                  
                     echo "</td>";
                      
                      
                  echo "</tr>";
                      }
                       echo "  </form>";
              ?>
              
              
          </table>
          
          
         
              
              
              
          </div>
        </div>
      </div>