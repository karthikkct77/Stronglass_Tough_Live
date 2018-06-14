<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Customer import</h1>

        </div>

    </div>
    <div class="row">
        <?php if($this->session->flashdata('feedback')): ?>
            <script>
                var res = "<?php echo $this->session->flashdata('feedback'); ?>";
                swal({
                        title: "Success!",
                        text: res,
                        type: "success"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>
        <div class="col-md-6" id="add">
            <div class="tile">
                <h3 class="tile-title">Data Import</h3>
                <div class="tile-body">
                    <form method="post" enctype="multipart/form-data" class="login-form" action="<?php echo site_url('Admin_Controller/ExcelDataAdd_new'); ?>" name="data_register">
                        <div class="form-group">
                            <label class="control-label">Upload Invoice</label>
                            <input type="file" id="exampleInputFile" name="userfile" required>
                        </div>

                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Upload</button>&nbsp;
                    </form>

                </div>
            </div>
        </div>

    </div>
</main>
