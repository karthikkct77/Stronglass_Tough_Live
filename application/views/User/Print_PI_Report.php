<style></style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> PI Summery</h1>
        </div>

    </div>
    <div class="row" id="content">
        <!-- view Stock Details -->
        <div class="col-md-12">

            <div class="tile" id="pagewidth">
                <img style="width: 5%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                <h3 class="tile-title" style="text-align: center;">PI Summary</h3>
                <div class="tile-body" >
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                     <a class="btn btn-success pi_button" id="with_print" href="<?php echo site_url('User_Controller/Print_PDF_PI/' .$from_date. '/' .$to_date. ''); ?>">PDF</a>


                    <!-- <div class="col-md-3">
                         <h5>NO.PI:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $pi_count[0]['pi_count']; */?></span></h5>
                        </div>
                        <div class="col-md-3">
                            <h5>Amount:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $pi_count[0]['pi_amount']; */?></span></h5>
                        </div>
                        <div class="col-md-3">
                            <h4>NO.WO:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $wo_count[0]['wo_count']; */?></span></h4>
                        </div>
                        <div class="col-md-3">
                            <h4>Amount:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $wo_count[0]['wo_amount']; */?></span></h4>
                        </div>-->
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">From Date</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($from_date)); ?> <input type="hidden" name="fdate" id="fdate" value="<?php echo $from_date; ?>"></td>
                            <td style="font-weight: bold; font-size: 16px;">To Date</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($to_date)); ?> <input type="hidden" name="todate" id="todate" value="<?php echo $to_date; ?>"></td>
                            <td style="font-weight: bold; font-size: 16px;">NO.of.PI:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $pi_count[0]['pi_count']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Amount:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $pi_count[0]['pi_amount']; ?></td>
                        </tr>
                    </table>

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>PI.NO</th>
                            <th>Customer</th>
                            <th>Thickness</th>
                            <th>Special</th>
                            <th>Qty</th>
                            <th>SQ.M</th>
                            <th>Amount</th>


                        </tr>
                        </thead>
                        <tbody style="font-weight: bold;">
                        <?php $i=1;
                        foreach ($wo_details as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');
                            $thicks =  $val['thickness'];


                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $thicks;   ?>
                                <td><?php echo $val['special'];   ?>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="qty[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="area[]" value="<?php echo $val['area']; ?>">

                                </td>

                                <td><?php echo $val['GrossTotal_Value']; ?>
                                    <input type="hidden" name="total[]" value="<?php echo $val['GrossTotal_Value']; ?>">

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

                            <td id="total_amt" style="font-weight: bold; font-size: 24px;"></td>

                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

    <div id="editor"></div>
</main>
<style type="text/css" media="print">
    #pagewidth {
        overflow: hidden ;
    }
    @media print {
        #with_print {
            display: none;
        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        /*tfoot { display:table-footer-group }*/
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}
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



    });

    function  pdf() {
        var from_date = document.getElementById('fdate').value;
        var to_date = document.getElementById('todate').value;
        $.ajax({
            url:"<?php echo site_url('User_Controller/Print_PDF_PI'); ?>",
            data: {Fdate: from_date, Todate: to_date },
            type: "POST",
            success:function(data){
                if(data == '1')
                {
                    swal({
                            title: "Success!",
                            text: 'PI Request Send Success',
                            type: "success"
                        },
                        function(){
                            window.location.href = document.referrer;
                        });
                }

            }
        });



    }
    </script>




