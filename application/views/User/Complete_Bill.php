<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Generated Bill List</h1>
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
<!--                <h3 class="tile-title">WO List</h3>-->
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>WO - Number</th>                          
                            <th>PI- Number</th>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($bill as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['WO_Number']; ?></td>                                
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['Bill_Number']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['GrossTotal_Value']; ?></td>
                                <td><?php echo $val['Created_On']; ?></td>


                                <?php
                                if ($val['PI_Type'] == '1') { ?>
                                    <td> <a class="btn btn-info" href="<?php echo site_url('User_Controller/View_Single_Sheet_Bill/') . $val['Proforma_Icode']; ?>">Sheet Bill</a></td>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <td><a class="btn btn-info" href="<?php echo site_url('User_Controller/View_Single_Bill/') . $val['Proforma_Icode']; ?>">View Bill</a></td>
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
