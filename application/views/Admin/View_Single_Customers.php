
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>View Customers </h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('Admin_Controller/View_Customers'); ?>">Customer List</a></li>
            <li class="breadcrumb-item"><a href="#">View Customers</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-6">
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
            <div class="tile">  <h3 class="tile-title pull-left">View Customers</h3>
                <a class="btn btn-success pull-right" href="<?php echo site_url('Admin_Controller/Edit_Customers/').$customers[0]['Customer_Icode']; ?>">EDIT</a>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="size_table">
                        <tbody>
                        <?php
                        foreach ($customers as $key)
                        {
                            ?>
                            <tr>
                                <td align="right">NAME</td><td><?php echo $key['Customer_Company_Name']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">GSTIN</td><td><?php echo $key['Customer_GSTIN']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Address</td><td><?php echo $key['Customer_Address_1']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Address1</td><td><?php echo $key['Customer_Address_2']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Area</td><td><?php echo $key['Customer_Area']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">City</td><td><?php echo $key['Customer_City']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">State</td><td><?php echo $key['Customer_State']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Phone</td><td><?php echo $key['Customer_Phone']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Alternate Phone</td><td><?php echo $key['Customer_Alternate_Phone']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Email</td><td><?php echo $key['Customer_Email_Id_1']; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Email 2</td><td><?php echo $key['Customer_Email_Id_2']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(document).ready( function () {
        $('#size_table').DataTable();
    } );
</script>