<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Review/Confirm Proforma Invoice</h1>
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
        <!-- view Stock Details -->
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>PI- Number</th>
                            <th>Customer</th>
                            <th>PI- Date</th>
                            <th>Total Amount</th>
                            <th>PI Generated  By </th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($invoice as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['Proforma_Date']; ?></td>
                                <td><?php echo $val['GrossTotal_Value']; ?></td>
                                <td><?php echo $val['User_Name']; ?></td>
                                <?php
                                if($val['Email_Send_Status'] == '1')
                                { ?>
                                    <td style="color: #00CC00">Email Sent</td>
                               <?php }
                               else if($val['Modified_Status'] == '1' && $val['Email_Send_Status'] == '0' )
                               { ?>
                                   <td>In Review</td>
                              <?php }
                              else
                                { ?>
                                    <td>Yet to Review</td>
                                <?php }?>
                                <td> <a class="btn btn-info" href="<?php echo site_url('User_Controller/single_Invoice/') . $val['Proforma_Icode']; ?>">Review</a></td>
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
