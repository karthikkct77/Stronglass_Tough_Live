<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Inward Cash</h1>
        </div>
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


        <div class="col-md-6" id="add">
            <div class="tile">
                <h3 class="tile-title">Add Cash</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Insert_Inward_Details'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save?');">
                        <div class="form-group">
                            <label class="control-label">Petty Cash</label>
                            <input type="hidden" name="petty_icode" value="<?php echo $petty_cash[0]['Petty_Cash_Icode']; ?>">
                            <input class="form-control" type="text" name="petty_amt" value="<?php echo $petty_cash[0]['Petty_Cash']; ?>" required readonly>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Inward Reason</label>

                            <textarea class="form-control" name="comments" placeholder="Enter Reason" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Inward Amount</label>
                            <input class="form-control" type="text" name="amount" placeholder="Enter Inward Amount" required>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title ">View Inward Cash</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Inward Amount</th>
                            <th>Inward Name</th>
                            <th>Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($inward as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Inward_Amount']; ?></td>
                                <td><?php echo $val['Inward_Details']; ?></td>
                                <td><?php echo $val['Created_On']; ?></td>

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

    $('#demoDate').datepicker({
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