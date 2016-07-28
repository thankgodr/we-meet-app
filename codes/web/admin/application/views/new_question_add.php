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
                <p>Question Answer Add</p>
            </div>
            <div class="col-md-6 notification-detail">
                <p></p>
            </div>
        </div>
    </div>
    <div class="row editable-options">
        <div class="container">
            <div class="col-md-7">
                Question Answer Add </br>
                <?php echo $this->session->flashdata('message'); ?>
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-1">

            </div>

            <div class="col-md-3 options-right-icon">

                <a href="question_add"  style="text-decoration: none;"><i class="icon-plus"></i></a>

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

            <table width="100%" id="table1">
                <tr >

                    <th width="1%">
                        NO. 

                    </th>

                    <th width="10%">
                        Question
                    </th>





                </tr>
                <?php
                echo form_open('users/question_insert');




                echo "<tr>
 <td>
                                    Question     
                                            </td>" .
                "<td>" . "<textarea rows='4' cols='50' name='question' required></textarea>" . "</td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>
<tr>
 <td>
                                     option A    
                                            </td>" .
                "<td>" . " <input type ='text' name='option_a' required></input>  " . "</td>
                                           
                                           
                                                
                                          
                                            

                                          
                                        </tr>                                        

<tr>
 <td>
                                     option B      
                                            </td>" .
                "<td>" . " <input type ='text' name='option_b' required  ></input>" . "</td>
                                           
                                           
                                                
                                           
                                            

                                          
                                        </tr>
                                        <tr>
 <td>
                                     option C     
                                            </td>" .
                "<td>" . " <input type ='text' name='option_c'></input> " . "</td>
                                           
                                           
                                                
                                           

                                          
                                        </tr>
                                        <tr>
 <td>
                                     option D     
                                            </td>" .
                "<td>" . " <input type ='text' name='option_d'></input> " . "</td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>
                                         <tr>
 <td >
                                      <div class='toolbar'>
                                                    <div class='btn-group' align='center'>
                                                        
                                                                                                                
                                                    </div>
                                                </div>     
                                            </td><td><button type='submit'  class='btn btn-green'>Add </button></td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>";






                echo "  </form>";
                ?>


            </table>






        </div>
    </div>
</div>