<main class="app-content">
    <div  class="output" >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Work Order Barcode</h1>
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
            <div class="col-md-12" >
                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h4><?php echo $st[0]['ST_Name']; ?></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="consign">
                                <h4 class="heading"><span>Work Order No</span>: <?php echo $wo[0]['WO_Number']; ?></h4>
                                <h4 class="heading"><span>Proforma No</span>  :<?php echo $wo[0]['WO_Number']; ?></h4>
                                <h4 class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Created_On']; echo date("H:i",strtotime($date)); ?></h4>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <h4 class="heading"><span>Project </span>:<?php echo $invoice[0]['Customer_Company_Name']; ?></h4>
                            <h4 class="heading"><span>Prepared Date</span>  :<?php echo date($wo[0]['WO_Date']); ?></h4>
                            <h4 class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Date']; echo date('Y-m-d', strtotime($date. ' + 2 days')); ?></h4>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-hover table-bordered" id="sampleTable" >
                                <thead>
                                <th>#</th>
                                <th>Material</th>
                                <th>Height</th>
                                <th>Width</th>
                                <th>Qty</th>
                                <th>Holes</th>
                                <th>Cutout</th>
                                <th>Special</th>
                                <th>Area</th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <tr id="row<?php echo $i; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $key['Material_Name']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                        <td><?php echo $key['Proforma_Qty']; ?></td>
                                        <td><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                        <td><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $invoice_total[0]['qty']; ?></td>
                                    <td id="holes_print"></td>
                                    <td id="cutout_print"></td>
                                    <td></td>
                                    <td><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-3">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Extra Charges</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=1;
                                foreach ($invoice_Charges as $key) {
                                    ?>
                                    <tr>
                                        <td><?php echo $key['charge_name']; ?></td>
                                        <td><?php echo $key['Proforma_Charge_Count']; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="margin-top: 150px;">
                        <div class="col-md-3">

                            <h4 class="st_check">Prepared By</h4>

                        </div>
                        <div class="col-md-3">
                            <h4 class="st_check">Checked By</h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="st_check">Production Manager</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()"value="Print"/>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</main>

<style>
    h4 span{
        width: 185px;
        float: left;
    }
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    .heading {
        font-size: 18px;
    }
    /* In CSS, not JavaScript */

</style>


