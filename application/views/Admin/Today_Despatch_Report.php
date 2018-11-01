<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Despatch Report</h1>
        </div>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-12" id="content">

            <div class="tile" id="pagewidth">
                <img style="width: 5%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                <h3 class="tile-title" style="text-align: center;">Despatch Report</h3>
                <h3 class="tile-title" style="text-align: center;"><?php $wo_details[0]['Delivery_Location']; ?></h3>
                <div class="tile-body">
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <a class="btn btn-success pi_button" id="with_print" href="<?php echo site_url('Admin_Controller/despatch_pdf/'.$wo_details[0]['Delivery_Location'].''); ?>">PDF</a>

                    <table class="table table-hover table-bordered" id="sampleTable" >
                        <thead>
                        <tr>
                            <th>Delivery Location</th>
                            <th>Delivery Date</th>
                            <th>Vehicle Number</th>
                            <th>Driver Name</th>
                        </tr>
                        </thead>
                        <tbody style="font-weight: bold; fo">
                        <tr>
                            <td><?php echo $wo_details[0]['Delivery_Location']; ?> </td>
                            <td><?php echo date("d-m-Y", strtotime($wo_details[0]['Delivery_Date']));  ?> </td>
                            <td><?php echo $wo_details[0]['Vehicle_Number']; ?> </td>
                            <td><?php echo $wo_details[0]['Driver_Name']; ?> </td>
                        </tr>

                        </tbody>
                    </table>




                    <table class="table table-hover table-bordered" id="sampleTable" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>WO.NO</th>
                            <th>PI.NO</th>
                            <th>Thickness</th>
                            <th>Qty</th>
                            <th>SQ.M</th>
                            <th>Weight</th>
                            <th>Amount</th>
                            <th>Transport</th>
                        </tr>
                        </thead>
                        <tbody style="font-weight: bold; fo">
                        <?php $i=1;
                        foreach ($wo_details as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');

                            $str = $val['thickness'];
                            preg_match_all('!\d+!', $str, $matches);

                            $res = array();
                            foreach($matches as $value) {
                                foreach($value as $key => $number) {
                                    (!isset($res[$key])) ?
                                        $res[$key] = $number :
                                        $res[$key] += $number;
                                }
                            }

                            $length = sizeof($res);

                            if($length > 1)
                            {
                                $sum = array_sum($res);
                                $vals = $sum /2 ;
                            }
                            else
                            {
                                $sum = array_sum($res);
                                $vals = $sum;
                            }



                            $width = $area * $vals * 2.5;




                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['thickness'];   ?></td>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="qty[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="area[]" value="<?php echo $val['area']; ?>">

                                </td>
                                <td> <?php echo $width; ?>

                                    <input type="hidden" name="width[]" value="<?php echo $width; ?>">
                                </td>
                                <td><?php echo $val['GrossTotal_Value']; ?>
                                    <input type="hidden" name="total[]" value="<?php echo $val['GrossTotal_Value']; ?>">

                                </td>

                                <td id="Transport<?php echo $i; ?>" >

                                    <?php echo $val['Transport']; ?>

                                </td>
                                <td id="trans<?php echo $i; ?>" class="span">
                                    <input class="form-control" type="text" name="pics[]" id="pics<?php echo $i; ?>"
                                           value="<?php echo $val['Transport']; ?>" onkeyup="change_transport('<?php echo $i; ?>')"  >

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_qty" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_sqm" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="tot_width" style="font-weight: bold; font-size: 24px;"></td>

                            <td id="total_amt" style="font-weight: bold; font-size: 24px;"></td>
                            <td></td>

                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>
</main>




<style type="text/css" media="print">
    #pagewidth {
        overflow: hidden ;
    }

    @media print {
        #with_print {
            display: none;
        }
        .form-control {
            display: none;
        }
        .span{
            display: none;
        }

        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        @page {
            size: A4;   /* auto is the initial value */
            margin: 0cm 0cm 0cm 0cm;
            marks: crop cross;
        }

    }


</style>
<script>


    $( document ).ready(function() {
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('total_amt').innerHTML = parseFloat(sum);

        var pices =document.getElementsByName("qty[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('tot_qty').innerHTML = parseFloat(sum_pic);

        var area =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = area.length; j < iLen; j++) {
            if (area[j].value!==""){
                val=parseFloat(area[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('area_sqm').innerHTML = parseFloat(sum_area).toFixed(2);

        var width =document.getElementsByName("width[]");
        var sum_width = 0;
        for (var j = 0, iLen = width.length; j < iLen; j++) {
            if (width[j].value!==""){
                val=parseFloat(width[j].value);
                sum_width +=val;
            }
        }
        document.getElementById('tot_width').innerHTML = parseFloat(sum_width).toFixed(2);

    });
    function change_transport(id)
    {
        var pcs = document.getElementById('pics'+id).value;
        document.getElementById('Transport'+id).innerHTML = pcs;

    }
</script>