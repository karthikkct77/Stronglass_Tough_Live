<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Work Order Status</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Work Order Status</a></li>
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
        <style>
            .wo_right{
                background: #ccc;
                text-align: center;
                margin-bottom: 20px;
            }
            .wo_top{
                margin-bottom: 20px;
            }
            .wo_top h4{
                margin-bottom: 0;

                padding: 10px 0;
            }
            .remaining_qty
            {
                display: inline-block;
                vertical-align: middle;
                font-size: 20px;
                color: #009688;
            }
        </style>
        <!-- view Stock Details -->
        <div class="col-md-12">
            <div class="tile">
                <!--         <h3 class="tile-title">Work Order List</h3>-->
                <div class="tile-body">
                    <div class="row wo_top">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Ref No </h4>
                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4>123</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>PI NO </h4>
                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['Proforma_Number']; ?></h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Work Order No</h4>

                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['WO_Number']; ?></h4>

                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="wo_icode" id="wo_icode" value="<?php echo $work_order[0]['WO_Icode']; ?>">

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Work Order Date</h4>

                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['WO_Date']; ?></h4>

                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Completed % </th>
                            <th>Remaining Cutting % </th>
                            <th>Remaining Furnace %</th>
                            <th>Remaining Dispatch %</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $total_qty = $work_order[0]['Total_Qty'];
                                $disptach_remain = $complete[0]['remaining1'];
                                $cutting_remain = $complete[0]['remaining2'];
                                $funan_remain = $complete[0]['remaining3'];
                                $remain = $disptach_remain + $cutting_remain + $funan_remain;
                                $completed = $total_qty - $remain;
                                $totel_completed = ($completed/$total_qty) * 100;
                                if($totel_completed < 50)
                                { ?>
                                    <td style="color: red;"><h2><?php echo  round($totel_completed); ?>%</h2></td>
                                    <?php
                                }
                                elseif($totel_completed >50 && $totel_completed <50 )
                                {
                                    ?>
                                    <td style="color: orange;"><h2><?php echo  $totel_completed; ?>%</h2></td>

                                    <?php
                                }
                                else{ ?>
                                    <td style="color: orange;"><h2><?php echo  $totel_completed; ?>%</h2></td>
                                <?php }
                                ?>
                                <?php
                                $total_qty = $work_order[0]['Total_Qty'];
                                $completed = $cutting[0]['remaining'];
                                $totel = (int)(($completed/$total_qty) * 100); ?>
                                <td><h2><?php echo  $totel; ?>% <span class="remaining_qty">(<?php echo $completed; ?> / <?php echo $total_qty; ?> )</span></h2></td>
                                <?php
                                $total_qty = $work_order[0]['Total_Qty'];
                                $completed =  $furnace[0]['remaining'];
                                $totel_furnace = (int)(($completed/$total_qty) * 100); ?>
                                    <td><h2><?php echo  $totel_furnace; ?>% <span class="remaining_qty">(<?php echo $completed; ?> / <?php echo $total_qty; ?> )</span></h2></td>
                                <?php
                                $total_qty = $work_order[0]['Total_Qty'];
                                $completed =  $dispatch[0]['remaining'];
                                $totel_dispatch = (int)(($completed/$total_qty) * 100); ?>
                                    <td><h2><?php echo  $totel_dispatch; ?>% <span class="remaining_qty">(<?php echo $completed; ?> / <?php echo $total_qty; ?> )</span></h2></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>$('#sampleTable').DataTable();</script>