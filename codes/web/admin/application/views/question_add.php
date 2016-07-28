

   
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
                        <h4 class="title semibold">Add Questions</h4>
                      
                       
                          <?php echo $this->session->flashdata('message');?>
                        
                           

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
                                <h3 class="panel-title"><span class="panel-icon mr5"><i class="ico-table22"></i></span>Add Questions</h3>
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
                            <?php echo form_open('users/question_insert'); ?>
                            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                                <div class="panel-toolbar pl10">
                                    <div class="checkbox custom-checkbox pull-left">  
                                        <!--<input type="checkbox" id="customcheckbox" value="1" data-toggle="checkall" data-target="#table1">  
                                        <label for="customcheckbox">&nbsp;&nbsp;Select all</label>  -->
                                    </div>
                                </div>
                                <div class="panel-toolbar text-right">
                                    <!--<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-default"><i class="ico-upload22"></i></button>
                                        <button type="button" class="btn btn-sm btn-default"><i class="ico-archive2"></i></button>
                                    </div>

                                    <button type="submit"  onclick="return confirm('Are Your Sure Dlete It ?')" class="btn btn-sm btn-danger"><i class="ico-remove3"></i></button>-->
                                </div>
                            </div>
                            <!--/ panel toolbar wrapper -->

                          
                            <!-- panel body with collapse capabale -->
                            <div class="table-responsive panel-collapse pull out">
                                <table class="table table-bordered table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">Id</th>
                                            
                                            <th>Add Questions</th>
                                            
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                     <?php 
                                    
                                       //checkbox custom-checkbox nm
                                      
                                      
 echo "<tr>
 <td>
                                    Question     
                                            </td>".
                                          
                                            "<td>"."<textarea rows='4' cols='50' name='question' required></textarea>"."</td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>
<tr>
 <td>
                                     option A    
                                            </td>".
                                          
                                            "<td>"." <input type ='text' name='option_a' required></input>  "."</td>
                                           
                                           
                                                
                                          
                                            

                                          
                                        </tr>                                        

<tr>
 <td>
                                     option B      
                                            </td>".
                                          
                                            "<td>"." <input type ='text' name='option_b' required  ></input>"."</td>
                                           
                                           
                                                
                                           
                                            

                                          
                                        </tr>
                                        <tr>
 <td>
                                     option C     
                                            </td>".
                                          
                                            "<td>"." <input type ='text' name='option_c'></input> "."</td>
                                           
                                           
                                                
                                           

                                          
                                        </tr>
                                        <tr>
 <td>
                                     option D     
                                            </td>".
                                          
                                            "<td>"." <input type ='text' name='option_d'></input> "."</td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>
                                         <tr>
 <td colspan='2' >
                                      <div class='toolbar'>
                                                    <div class='btn-group' align='center'>
                                                        <button type='submit'  class='btn btn-sm btn-danger'>Add </button>
                                                                                                                
                                                    </div>
                                                </div>     
                                            </td>
                                           
                                           
                                                
                                            
                                            

                                          
                                        </tr>";
 
 
 

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

        