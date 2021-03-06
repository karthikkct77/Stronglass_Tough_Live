<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Add Expenses</h1>
        </div>
    </div>
    <style>
        .blink_me {
            animation: blinker 1s linear infinite;
            font-size: 25px;
            color: #e80d0d;
        }

        @keyframes blinker {
            50% { opacity: 0; }
        }
    </style>
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

        <?php if($this->session->flashdata('feedback1')): ?>
            <script>
                var ssd = "<?php echo $this->session->flashdata('feedback1'); ?>";
                swal({
                        title: "Error!",
                        text: ssd,
                        type: "warning"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>

        <div class="col-md-6" id="add">
            <div class="tile">
                <h3 class="tile-title">Add Expenses</h3> <span class="blink_me">Petty Cash : <?php echo $petty_cash[0]['Petty_Cash']; ?> /-</span>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Insert_Expenses_Details'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save?');">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input type="hidden" name="petty_icode" value="<?php echo $petty_cash[0]['Petty_Cash_Icode']; ?>">
                            <input class="form-control" type="hidden" name="petty_amt" value="<?php echo $petty_cash[0]['Petty_Cash']; ?>" >
<!--                            <input class="form-control" type="text" name="expenses_date" value="--><?php //echo date('Y-m-d'); ?><!--" required readonly>-->
                            <input class="form-control" id="demoDate" name="expenses_date" type="text" placeholder="Select Expenses Date" required >
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Expenses Name</label>
                            <select name="expenses" class="form-control" id="expenses" required  >
                                <option value="" >Select Expenses</option>
                                <?php foreach ($expenses as $row):
                                {
                                    echo '<option value= "'.$row['Expenses_Icode'].'">' . $row['Expenses_Name'] .'</option>';
                                }
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input class="form-control" type="text" name="amount" placeholder="Enter Amount" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Comments</label>

                            <textarea class="form-control" name="comments" placeholder="Enter Comments" required></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
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