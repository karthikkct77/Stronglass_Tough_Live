<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Lamination Profoma Invoice</h1>
        </div>

    </div>
    <div class="row">
        <?php if($this->session->flashdata('feedback')): ?>
            <script>
                var ssd = "<?php echo $this->session->flashdata('feedback'); ?>";
                swal({
                        title: "error!",
                        text: ssd,
                        type: "error"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>
        <div class="col-md-6" id="add">
            <div class="tile">
                <?php if($this->session->flashdata('message')){?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('message')?>
                    </div>
                <?php } ?>
                <h3 class="tile-title">Upload PI Data (From Excel)</h3>
                <div class="tile-body">
                    <form method="post" enctype="multipart/form-data" class="login-form" action="<?php echo site_url('User_Controller/Upload_Lamination'); ?>" name="data_register">
                        <div class="form-group">
                            <label class="control-label">Select File to Upload</label>
                            <input type="file" id="exampleInputFile" name="userfile" required>
                        </div>
                        <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Load File</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>