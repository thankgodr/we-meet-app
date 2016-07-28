
<script type="text/javascript">
    $('#user').addClass('active');
</script>
<style>
    table,th,td
    {

        height: 50px;
    }
</style>

<script type="text/javascript">
    function check()
    {
        var checkedValue = null;
        var inputElements = document.getElementsByClassName('check');

var chek='off';
        for (var i = 0; inputElements[i]; ++i) {
            if (inputElements[i].checked) {          
                var chek = 'on';
                checkedValue = inputElements[i].value;
               break;              
            }
            else
            {               
                var chek = 'off';
            }
          }
         if (chek == "on")
            {
                return confirm("Are you sure you want to delete the selected users ?");

            }
            else
            {
                alert("Please select a user first.");
                return false;

            }
 }
</script>  

<div id="option3">
    <div class="row tab-content-caption">
        <div class="container">
            <div class="col-md-4 big-text">
                <p>User List</p>
            </div>
            <div class="col-md-6 notification-detail">
                <p></p>
            </div>
        </div>
    </div>
    <div class="row editable-options">
        <div class="container">
            <div class="col-md-2">
               <!-- <input type="checkbox"  id="customcheckbox"  >--> 

                <input type="checkbox" id="customcheckbox" value="1" data-toggle="checkall" data-target="#table1">  

                &nbsp;Select All
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-5">

            </div>
            <div class="col-md-3 options-right-icon">

                <?php echo form_open('data_controller/delete_user'); ?>

                <button type="submit" style="width:24px; height:28px;border: none;" class="button"  onclick ="return check()"><i class="icon-trash" style="margin-left: -7px;"></i></button>
            </div>
        </div>
    </div>
    <div class="row editable-content-div">
        <div class="container" id ="form">
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
                    <th width="3%" align="right">
                        <i class="icon-arrow-down"></i>

                    </th>
                    <th width="3%">
                        id
                    </th>
                    <th>Name
                    </th>
                    <th>
                        Date Of Birth
                    </th>
                    <th>
                        Email
                    </th>
                    <th>                        Facebook ID                         
                    </th>
                    <th>
                        Device ID
                    </th>
                    <th>
                        Delete 
                    </th>
                </tr>
                <?php
                foreach ($users_list as $user) {

                    if ($user->City == NULL) {
                        $user->City = "Not Available";
                    }
                    if ($user->Email == NULL) {
                        $user->Email = "Not Available";
                    }

                    echo "<tr>";

                    echo "<td>" . "<input type='checkbox' class='check'  id='customcheckbox1[]' name='customcheckbox1[]' value='$user->Entity_Id' data-toggle='selectrow' data-target='tr' data-contextual='success'>" . "</td>";
                    echo "<td>" . $user->Entity_Id . "</td>";
                    echo "<td>" . $user->First_Name . ' ' . $user->Last_Name . "</td>";
                    echo "<td>" . $user->DOB . "</td>";
                    echo "<td>" . $user->Email . "</td>";
                    echo "<td>" . $user->Fb_Id . "</td>";
                    echo "<td>" . $user->Device_Id . "</td>";
                    echo "<td align='center'>";
                    echo '<button type="submit" value="' . $user->Entity_Id . '" name="customcheckbox1" onclick = "return confirm(\'Are You Sure Dlete It ?\')"  class="btn btn-nothing">Delete</button>';
                    echo "</td>";

                    echo "</tr>";
                }
                echo "  </form>";
                ?>


            </table>






        </div>
    </div>
</div>
<!--
<SCRIPT language="javascript">
    $(function() {

        // add multiple select / deselect functionality
        $("#customcheckbox").click(function() {
            $('.customcheckbox1').attr('checked', this.checked);
        });

        // if all checkbox are selected, check the selectall checkbox
        // and viceversa
        $(".customcheckbox1").click(function() {

            if ($(".customcheckbox1").length == $(".customcheckbox1:checked").length) {
                $("#customcheckbox").attr("checked", "checked");
            } else {
                $("#customcheckbox").removeAttr("checked");
            }

        });
    });
</SCRIPT>-->