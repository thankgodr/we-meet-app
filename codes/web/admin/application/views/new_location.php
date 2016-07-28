<script type="text/javascript">
    $('#location').addClass('active');

</script>
<div id="option1">
    <div class="row tab-content-caption">
        <div class="container">
            <div class="col-md-3 big-text">
                <p>Add CheckIn </p>
            </div>
            <div class="col-md-6 notification-detail">
                <p> Add CheckIn Place</p>
            </div>
            <div class="col-md-2 update-detail">
            </div>
        </div>
    </div>
    <div class="row content-div">
        <div class="container">
            <div class="col-md-9 ">


                <div style="margin-top: 10px;" id="map_canvas" >
                    </head>
                    <body onload="xyz()">

                        <div id="wrapper" style="margin:5px"><div id="map" style="width:800px; height: 550px"></div></div>
                        <table cellpadding="5" cellspacing="0" border="1">
                            <input size="5" type="hidden" id="latboxm" name="latm" value="" ><input size="6" type="hidden" id="latboxmd" onchange="test()" name="latmd" value=""  ><input size="8" type="hidden" id="latboxms" name="latms" value="" >
                            <input size="5" type="hidden" id="lonboxm" name="lonm" value="" ><input size="6" type="hidden" id="lonboxmd" name="lonmd" value="" ><input size="8" type="hidden" id="lonboxms" name="lonms" value="" >
                        </table>

                </div>     

            </div>
            <div class="col-md-3 requests">
                <div class="row">
                    <table >
                        <p color="green"><?php echo $this->session->flashdata('message'); ?></p>
                        <?php echo form_open("users/insert_location"); ?>
                        <tr><th colspan="2">Location Info</th></tr>

                        <tr><td>LocationName</td></tr>
                        <tr><td><input type="text" name ="location" class="form-control" required></td></tr>

                        <tr><td>Latitude<td></tr>
                        <tr><td><input type="text"  class="form-control" id="latbox" name="lat1" onkeyup="xz()"   required ><input type="hidden"  id="latbox1" name="lat" onkeyup="xz()" onchange="test()" > </td></tr>

                        <tr><td>Longitude</td></tr>
                        <tr><td><input type="text"  class="form-control"  id="lonbox" name="lon1" onkeyup="xz()" required><input type="hidden"   id="lonbox1" name="lon" onkeyup="xz()"></td></tr>

                        <tr><td>Address</td></tr>
                        <tr><td><input type="textarea" class="form-control" name="address" id="address" rows="4" cols="50" onkeyup="codeLatLng()" required></input></td></tr>

                        <tr><td colspan="2" align="center"><input type="submit"  class="btn btn-green" value="submit"></td></tr>

<!--<div class="col-md-2 request-pic"><img src=""></div>-->
                        </form>
                    </table>

                    <div class="col-md-7 request-details">

<!--p><span class="right"></span></p>
<p></p>-->
                    </div>
                </div>         
            </div>
        </div>
    </div>
</div>

