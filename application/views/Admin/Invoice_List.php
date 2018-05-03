<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> View Customer Details</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('Admin_Controller/Add_Customers'); ?>">Add Customer</a></li>
            <li class="breadcrumb-item"><a href="#">View Customers</a></li>
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
                <h3 class="tile-title">Customers List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>PI- Number</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Locations</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($customers as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['Customer_City']; ?></td>
                                <td><?php echo $val['Customer_Phone']; ?></td>
                                <td><?php echo $val['Customer_Email_Id_1']; ?></td>
                                <td><h3><a href="<?php echo site_url('Admin_Controller/Locations/') . $val['Customer_Icode'];  ?>"> <?php echo $val['locations']; ?></a></h3></td>
                                <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/single_customer/') . $val['Customer_Icode']; ?>">View</a></td>
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
