<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>

    <?php
    foreach ($invoice_item as $key)
    {
        $total = $key['Proforma_Qty'];
        for ($i=1;$i<=$total;$i++)
        { ?>
    <div class="left" id="sample">

                <div>WO.No :<span><?php echo $wo[0]['WO_Number']; ?> </span></div>
                <div>PI. NO : <span><?php echo $invoice[0]['Proforma_Number']; ?></span><span style="float:right;"><?php echo $key['Proforma_Special']; ?></span></div>
                <div class="medium"><span><?php echo $invoice[0]['Customer_Company_Name']; ?></span></div>
                <div class="medium"><span><?php echo $key['Material_Name']; ?></span></div>
                <div><span class="size">Size :</span> <span class="size"> <?php echo $key['Proforma_Actual_Size_Height']; ?> X <?php echo $key['Proforma_Actual_Size_Width']; ?> </span><span style="float:right;">Qty : <?php echo $key['Proforma_Qty']; ?></span></div>
                <div class="last_fot">
                    <div class="left">HOLES :<span><?php echo $key['Proforma_Holes']; ?></span></div>
                    <div class="left">CUTOUTS :<span><?php echo $key['Proforma_Cutout']; ?></span></div>
                    <div class="left">OTHER :<span>C & W</span></div>
                </div>


    </div>
            <?php
        }
        ?>
        <?php
    }
    ?>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        window.print();
        history.back();
    });
</script>
<style>
    @media {
        html, body {
            width: 101.6mm;
            height: 50mm;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: bolder;
            font-family: sans-serif;
        }
        #sample{
            /*page-break-inside: avoid;*/
            margin-top: 10px;
            width: 90mm;
        }
    }
    div {
        padding-bottom: 10px;
    }
    .last_fot{
        display: block;
        font-size: 12px;
        font-weight: 100;
    }
    .left{
        float: left;
        padding-right: 10px;
    }
    .medium{
        font-weight: 100;
    }
    .size
    {
        font-size: 20px;

    }
</style>