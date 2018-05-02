<?php if ($this->session->flashdata('message')): ?>
    <script type="text/javascript">
        $(document).ready(function() {
            swal({
                title: "Done",
                text: "<?php echo $this->session->flashdata('message'); ?>",
                timer: 1500,
                showConfirmButton: false,
                type: 'success'
            });
        });
    </script>
<?php endif; ?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Edit Customer</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('Admin_Controller/View_Customers'); ?>">Customer View</a></li>
            <li class="breadcrumb-item"><a href="#">Edit Customers</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Customer</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Update_Customer'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Update ?');">
                        <input type="hidden" name="customer_id" value="<?php echo $customers[0]['Customer_Icode'] ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Company Name </label>
                                    <input class="form-control" name="company_name" type="text" value="<?php echo $customers[0]['Customer_Company_Name'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our GSTIN/UIN </label>
                                    <input class="form-control" name="gstin_number" type="text" value="<?php echo $customers[0]['Customer_GSTIN'] ?>"  required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our Address  </label>
                                    <textarea class="form-control" name="address" value="<?php echo $customers[0]['Customer_Address_1'] ?>"  required><?php echo $customers[0]['Customer_Address_1'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our Address1  </label>
                                    <textarea class="form-control" name="address1" value="<?php echo $customers[0]['Customer_Address_2'] ?>" ><?php echo $customers[0]['Customer_Address_2'] ?></textarea>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Area</label>
                                    <input class="form-control" name="area" type="text" value="<?php echo $customers[0]['Customer_Area'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input class="form-control" name="city" type="text" required value="<?php echo $customers[0]['Customer_City'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State </label>
                                    <input class="form-control" name="state" type="text" required value="<?php echo $customers[0]['Customer_State'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone </label>
                                    <input class="form-control" name="phone" type="text" required value="<?php echo $customers[0]['Customer_Phone'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alternate Phone</label>
                                    <input class="form-control" name="alternate_phone" type="text" value="<?php echo $customers[0]['Customer_Alternate_Phone'] ?>" >
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Email Id 1</label>
                                    <input class="form-control" name="email_1" type="email" required value="<?php echo $customers[0]['Customer_Email_Id_1'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email Id 2</label>
                                    <input class="form-control" name="email_2" type="email" value="<?php echo $customers[0]['Customer_Email_Id_2'] ?>">
                                </div>
                                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
                        </div>
                        <form>
                </div>
            </div>
        </div>
    </div>
</main>