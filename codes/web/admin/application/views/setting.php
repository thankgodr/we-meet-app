
<script type="text/javascript">
    $('#setting').addClass('active');
   
</script>
<div  id="option9">
        <div class="row tab-content-caption">
          <div class="container">
            <div class="col-md-4 big-text">
              <p>Settings</p>
            </div>
          </div>
        </div>
     
             
        <div class="row editable-content-div">
          <div class="container">
            <div class="col-md-8">
              <div class="row">
                <p>Add a New Administrator</p>
                 <?php echo $this->session->flashdata('message');  ?>
                <?php echo form_open('settings/addadmin');
                   
        ?>
                <div class="col-md-6">
                  <label><i class="icon-male"></i> Name</label>
                  <input type="text" name="username" class="form-control" required><br/>
                </div>
                <div class="col-md-6">
                  <label><i class="icon-lock"></i> Password</label>
                  <input type="password"  name="password" class="form-control" required><br/>
                  <label><i class="icon-lock"></i> Confirm Password</label>
                  <input name="repassword" type="password" class="form-control" required>
                  <br>
                  <button type="submit" class="btn btn-green"> Add</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>