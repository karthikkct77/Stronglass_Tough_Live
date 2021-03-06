<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Work Order List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Work Order</a></li>
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
                <h3 class="tile-title">Work Order List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ref No</th>
                            <th>Work Order No</th>
                            <th>Work Order Date</th>
                            <th>PI NO</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($work_order as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td></td>
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['WO_Date']; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <?php
                                if($val['WO_Completed'] == '1')
                                {
                                    ?>
                                    <td style="color: #00CC00;">Completed</td>

                                <?php } else {?>
                                    <td style="color: red;">On Progress</td>
                                <?php } ?>
                                <?php
                                if ($val['PI_Type'] == '1') { ?>
                                    <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_Sheet_Work_Order/') . $val['WO_Icode']; ?>">View</a></td>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_Work_Order/') . $val['WO_Icode']; ?>">View</a></td>
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
