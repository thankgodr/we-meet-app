

   
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
                        <h4 class="title semibold">Option List</h4>
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
                                <h3 class="panel-title"><span class="panel-icon mr5"><i class="ico-table22"></i></span>Question - Answers</h3>
                                <!-- panel toolbar -->
                                <div class="panel-toolbar text-right">
                                    <!-- option -->
                                    <div class="option">
                                        <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                                        <button class="btn" data-toggle="panelremove" data-parent=".col-md-12"><i class="remove"></i></button>
                                    </div>
                                    <!--/ option -->
                                   
                                </div>
                                 <?php 
                                 foreach ($option_list as $question)
                                     {
                                    $ques= $question->question;
                                     }
                                     if(!empty($option_list))
                                      echo '<h3>'.$ques.'</h3>';
                                     
                                     ?>
                                <!--/ panel toolbar -->
                            </div>
                            <!--/ panel heading/header -->
                            <!-- panel toolbar wrapper -->
                            <?php echo form_open('users/edit_option');?>
                            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                                <div class="panel-toolbar pl10">
                                   <!-- <div class="checkbox custom-checkbox pull-left">  
                                        <input type="checkbox" id="customcheckbox" value="1" data-toggle="checkall" data-target="#table1">  
                                        <label for="customcheckbox">&nbsp;&nbsp;Select all</label>  
                                    </div>-->
                                </div>
                                <div class="panel-toolbar text-right">
                                    <div class="btn-group">
                                         <?php
                                         foreach($option_list as $option)
                                         {
                                            $view_id = $option->d_id;
                                         }?>
                                        <!--<button type="button" class="btn btn-sm btn-default"><i class="ico-upload22"></i></button>-->
                                        <a href="option_add/<?php echo  $view_id;?>"><button type="button"  class="btn btn-sm btn-default"><i class="ico-plus-circle2"></i></button></a>
                                    </div>

                                    <!--<button type="submit"  onclick="return confirm('Are Your Sure Dlete It ?')" class="btn btn-sm btn-danger"><i class="ico-remove3"></i></button>-->
                                </div>
                            </div>
                            <!--/ panel toolbar wrapper -->

                          
                            <!-- panel body with collapse capabale -->
                            <div class="table-responsive panel-collapse pull out">
                                <table class="table-bordered" id="table1">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">No.</th>
                                            
                                            <th>Question id</th>
                                             <th>Answers </th>
                                           
                                            <th width="20%">View/Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                     <?php 
                                    // <button type='submit'  value='$option->id' name 'delete_id' onclick = \"return confirm('Are You Sure Dlete It ?')\"  class='btn btn-sm btn-danger'>Delete</button>
                                       //checkbox custom-checkbox nm
                                      foreach($option_list as $option){
                                      
 echo "<tr>
 <td>
                                     $option->id        
                                            </td>".
          "<td>".$option->d_id. "</td>".
                                          
                                            "<td>".$option->detail_option."</td>
                                           
                                           
                                                <input type='hidden' name='q_id' value='".$option->d_id."'>
                                            <td class='text-center'>
                                                <!-- button toolbar -->
                                                <div class='toolbar'>
                                                    <div class='btn-group'>
                                                        <button type='submit' value='$option->id' name='option_id'  class='btn btn-sm btn-danger'>Edit</button>
                                                            <button type='submit' value='$option->id' onclick = \"return confirm('Are You Sure Dlete It ?')\" name='delete_id' id='delete_id'  class='btn btn-sm btn-danger'>Delete</button>
                                                       
                                                      
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

        