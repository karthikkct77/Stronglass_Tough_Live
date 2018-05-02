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
            <h1><i class="fa fa-edit"></i>Edit ST</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Our Entry</li>
            <li class="breadcrumb-item"><a href="#">Edit ST</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit ST</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Update_ST'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Update ?');">
                        <input type="hidden" name="st_id" value="<?php echo $st[0]['ST_Icode'] ?>">
                        <input type="hidden" name="tax_id" value="<?php echo $tax[0]['Tax_Icode'] ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Our Company Name </label>
                                    <input class="form-control" name="company_name" type="text" value="<?php echo $st[0]['ST_Name'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our GSTIN/UIN </label>
                                    <input class="form-control" name="gstin_number" type="text" value="<?php echo $st[0]['ST_GSTIN'] ?>"  required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our Address  </label>
                                    <textarea class="form-control" name="address" value="<?php echo $st[0]['ST_Address_1'] ?>"  required><?php echo $st[0]['ST_Address_1'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Our Address1  </label>
                                    <textarea class="form-control" name="address1" value="<?php echo $st[0]['ST_Address_2'] ?>" ><?php echo $st[0]['ST_Address_2'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Area</label>
                                    <input class="form-control" name="area" type="text" value="<?php echo $st[0]['ST_Area'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input class="form-control" name="city" type="text" required value="<?php echo $st[0]['ST_City'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State </label>
                                    <input class="form-control" name="state" type="text" required value="<?php echo $st[0]['ST_State'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone </label>
                                    <input class="form-control" name="phone" type="text" required value="<?php echo $st[0]['ST_Phone'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alternate Phone</label>
                                    <input class="form-control" name="alternate_phone" type="text" value="<?php echo $st[0]['ST_Alternate_Phone'] ?>" >
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Email Id 1</label>
                                    <input class="form-control" name="email_1" type="email" required value="<?php echo $st[0]['ST_Email_ID1'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email Id 2</label>
                                    <input class="form-control" name="email_2" type="email" value="<?php echo $st[0]['ST_Email_ID2'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bank Name </label>
                                    <input class="form-control" name="bank" type="text" required value="<?php echo $st[0]['ST_Bank'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bank Account Number </label>
                                    <input class="form-control" name="account" type="text" required value="<?php echo $st[0]['ST_Bank_Account_Number'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bank Account Type </label>
                                    <input class="form-control" name="account_type" type="text" required value="<?php echo $st[0]['ST_Bank_Account_Type'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Bank Account IFSC Number </label>
                                    <input class="form-control" name="ifsc" type="text" required value="<?php echo $st[0]['ST_Bank_Account_IFSC_Code'] ?>" >
                                </div>

                                <div class="form-group">
                                    <label class="control-label">SGST % </label>
                                    <input class="form-control" name="sgst" type="text" required value="<?php echo $tax[0]['SGST%'] ?>" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">CGST % </label>
                                    <input class="form-control" name="cgst" type="text" required value="<?php echo $tax[0]['CGST%'] ?>">
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