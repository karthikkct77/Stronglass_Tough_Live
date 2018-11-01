<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Work Order List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Work Order</a></li>
        </ul>
    </div>
    <div class="row">
        <?php if($this->session->flashdata('feedback')): ?>
            <script>
                var ssd = "<?php echo $this->session->flashdata('feedback'); ?>";
                swal({
                        title: "Success!",
                        text: ssd,
                        type: "success"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>
        <!-- view Stock Details -->
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Work Order List</h3>
                <input type="submit" class="btn btn-success"  onclick="Delivery_All()" value="Delivery"/>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Delivery Location</label>
                            <select name="Delivery" class="form-control" id="Delivery"  required >
                                <option value="" >Select Delivery Location</option>
                                <option value="manapuram" >Manapuram</option>
                                <option value="ernakulam" >Ernakulam</option>
                                <option value="chennai" >Chennai</option>
                                <option value="local" >Local</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Vehicle Number </label>
                            <input class="form-control" type="text" name="Vehicle_No" id="Vehicle_No" placeholder="Enter Vehicle Number" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Driver Name </label>
                            <input class="form-control" type="text" name="Driver_Name" id="Driver_Name" placeholder="Enter Driver_name" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Delivery Date </label>
                            <input class="form-control" id="Delivery_Date" name="Delivery_Date" type="text" placeholder="Select Delivery Date">

                        </div>
                    </div>

                </div>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> All<input type="checkbox" id="selectall"/></th>
                            <th>#</th>
                            <th>Work Order No</th>
                            <th>PI NO</th>
                            <th>Customer Name</th>
                            <th>State</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($work_order as $val)
                        {
                            ?>
                            <tr>
                                <td> <input type='checkbox' class='case' name='case' value="<?php echo $val['WO_Icode'];?>"></td>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?> </td>
                                <td><?php echo $val['Customer_State']; ?></td>
                                <td><?php echo $val['GrossTotal_Value']; ?></td>


                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
<script>$('#sampleTable').DataTable();</script>
<script type="text/javascript">


    $('#Delivery_Date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    $('#demoDate1').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

</script>
<script>

    $(document).ready(function(){

        $('#selectall').change(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            if(this.checked)
            {
                $('input[type="button"]').not(this).prop('disabled', true);

            }
            else
            {
                $('input[type="button"]').not(this).prop('disabled', false);

            }

        });
    });

    function  Delivery_All() {
        if (confirm("Do you want to Delivery ")) {
            var checkboxes = document.getElementsByName('case');
            var vals = "";
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                if (checkboxes[i].checked) {
                    vals += "," + checkboxes[i].value;
                }
            }
            var process_id = vals;
            var vehicle = document.getElementById('Vehicle_No').value;
            var driver = document.getElementById('Driver_Name').value;
            var delivery_date = document.getElementById('Delivery_Date').value;
            var delivery_place = document.getElementById('Delivery').value;

            if(vehicle == "" || driver == "" || delivery_date == "" || delivery_place == "" || process_id == ""  )
            {
                alert("Please Select All Required Fields...");
            }
            else
            {
                $.ajax({
                    url: "<?php echo site_url('Admin_Controller/Delivery_All_WO'); ?>",
                    data: {
                        Wo_Icode: process_id,
                        Delivery_Location: delivery_place,
                        Delivery_Date: delivery_date,
                        Driver_Name: driver,
                        Vehicle_No: vehicle
                    },
                    type: "POST",
                    context: document.body,
                    success: function (data) {
                        if (data != 0) {
                            swal({
                                    title: "Success!",
                                    text: "Data Saved..",
                                    type: "success"
                                },
                                function () {
                                    location.reload();
                                });

                        }
                    }
                });
            }

        }

    }
</script>
