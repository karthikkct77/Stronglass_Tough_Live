<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Profoma Invoice List</h1>
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
                <h3 class="tile-title">PI List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>PI No</th>
                            <th>PI Date</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
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
                                <td><?php echo $val['Proforma_Date']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['GrossTotal_Value']; ?></td>

                                <?php
                                if ($val['PI_Type'] == '1') { ?>
                                    <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/single_Invoice/') . $val['Proforma_Icode']; ?>">View</a></td>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/single_Invoice/') . $val['Proforma_Icode']; ?>">View</a></td>
                                    <?php
                                }
                                ?>

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
