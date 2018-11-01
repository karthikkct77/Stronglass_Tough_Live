<html>
<head>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js">
    </script>
    <style>
        body,div,table,thead,td,th,tr,span,li,ul,p,h1,h2,h3,h4,h5,h6,i,section{
            font-family: Helvetica;
        }
        table,tr,td,thead,tbody,th{
            border: 1px solid #cccccc;
            border-collapse: collapse;
        }
        th{
            font-weight: bold;
        }
        table{
            width: 100%;
            text-align: center;
            font-size: 12px;
        }
        .width_td{
            width: 15%;
            max-width: 30px;
            table-layout: fixed;
            text-align:left;
        }
        #page {
            page-break-inside: avoid;
        }
        .acc span
        {
            width: 100px;
            float: left;
            font-size: 12px;
            font-weight: normal;
        }
        .details_tag{
            border: 1px solid #ccc;
            height: 10px;
            width: 100%;
            margin: 0px auto;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }
        .flex{
            display: flex;
        }
        .total
        {
            font-weight: bold;
        }
        #account h5 span {
            float: left;
            width: 150px;
            font-weight: normal;
        }
        .section3{
            font-size: 18px !important;
            font-weight: bold;
            float: right;
            text-align: left;
        }
        .tile_1{
            margin: 0 0 15px 0;margin-bottom:5px;font-size: 14px;width: 200px;
        }
    </style>
</head>
<body>
<div style="width: 100%; display: block;text-align: center;">
    <img style="position: absolute;width: 12%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">

    <h4 style=" margin-bottom: 0px; font-size:18px">Stronglass Tough</h4>
    <h3>WO  Summary</h3>

    <hr>

    <table class="table table-hover table-bordered">
        <tr>
            <td style="font-weight: bold; font-size: 16px;">From Date</td>
            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($from_date)); ?></td>
            <td style="font-weight: bold; font-size: 16px;">To Date:</td>
            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($to_date)); ?></td>
            <td style="font-weight: bold; font-size: 16px;">NO.of.WO:</td>
            <td style="font-weight: bold; font-size: 24px;"><?php echo  $wo_count[0]['wo_count']; ?></td>
            <td style="font-weight: bold; font-size: 16px;">Amount:</td>
            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_amount']; ?></td>
        </tr>
    </table>
    <hr>
    <table>
        <thead >
        <tr >
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
        <?php $i=1;
        $total_qty=0;
        $total_sqm=0;
        $total_sqmm=0;
        $total_amt=0;
        foreach ($wo_details as $val) {
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
            $total_qty += $val['Total_Qty'];
            $total_sqm += $val['area'];
            $total_amt += $val['GrossTotal_Value'];
            $i++;


        }
        ?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold;">Total Summary</td>
            <td id="tot_qty" style="font-weight: bold; font-size: 16px;"><?php echo $total_qty; ?></td>
            <td id="area_sqm" style="font-weight: bold; font-size: 16px;"><?php echo $total_sqm; ?></td>
            <td id="total_amt" style="font-weight: bold; font-size: 16px;"><?php echo $total_amt; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="table table-hover table-bordered" id="sampleTable1">
        <thead>
        <tr>
            <th>#</th>
            <th>Material Name</th>
            <th>Special</th>
            <th>Qty</th>
            <th>Area(Sq.mt)</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;
        $tot_m_qty = 0;
        $tot_m_area=0;

        foreach ($material_details as $val)
        {
            $area =  number_format((float)$val['area'], 2, '.', '');



            ?>

            <tr>

                <td><?php echo $i; ?></td>
                <td><?php echo $val['Material_Name']; ?></td>
                <td><?php echo $val['special'];   ?>
                <td><?php echo $val['Total_Qty']; ?>
                    <input type="hidden" name="material_qty[]" value="<?php echo $val['Total_Qty']; ?>">
                </td>
                <td><?php echo $area ; ?>
                    <input type="hidden" name="material_area[]" value="<?php echo $val['area']; ?>">

                </td>


            </tr>

            <?php
            $tot_m_qty += $val['Total_Qty'];
            $tot_m_area += $val['area'];
            $i++;
        }
        ?>

        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Total Summary</td>
            <td id="tot_material_qty" style="font-weight: bold; font-size: 24px;"><?php echo $tot_m_qty; ?></td>
            <td id="area_material_qty" style="font-weight: bold; font-size: 24px;"><?php echo $tot_m_area; ?></td>
            <td></td>
        </tr>
        </tbody>

    </table>



</div>

</body>
</html>

