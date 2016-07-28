 <?php 
 foreach($users_list as $user){
 echo "<tr>
 <td>
                                                <div class='checkbox custom-checkbox nm'>  
                                                    <input type='checkbox' id='customcheckbox1' value='1' data-toggle='selectrow' data-target='tr' data-contextual='success'>  
                                                    <label for='customcheckbox1'></label>   
                                                </div>
                                            </td>
                                            <td><div class='media-object'><img src='image/avatar/avatar.png' alt='' class='img-circle'></div>
                                            </td>
                                            <td>".$user->First_Name."</td>
                                            <td>".$user->Country."</td>
                                            <td>".$user->Email."</td>
                                            <td>".$user->Fb_Id.".</td>
                                            <td>".$user->Device_Id."</td>
                                            <td class='text-center'>
                                                <!-- button toolbar -->
                                                <div class='toolbar'>
                                                    <div class='btn-group'>
                                                        <button type='button' class='btn btn-sm btn-default'>Action</button>
                                                        <button type='button' class='btn btn-sm btn-default dropdown-toggle' data-toggle='dropdown'>
                                                            <span class='caret'></span>
                                                        </button>
                                                        <ul class='dropdown-menu dropdown-menu-right'>
                                                            <li><a href='javascript:void(0);'><i class='icon ico-pencil'></i>Update</a></li>
                                                            <li><a href='javascript:void(0);'><i class='icon ico-print3'></i>Print</a></li>
                                                            <li class='divider'></li>
                                                            <li><a href='javascript:void(0);' class='text-danger'><i class='icon ico-remove3'></i>Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!--/ button toolbar -->
                                            </td>
                                        </tr>";
 
 }