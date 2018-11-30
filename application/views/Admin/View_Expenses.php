<main class="app-content">
    <div  class="output" >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>View Expenses</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="tile" id="page_setup">
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h5><?php echo $st[0]['ST_Name']; ?></h5>
                        <h6><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h6>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                    </div>
                    <hr>
                    <h3 align="center">Monthly Expenses Details</h3>
                    <h3 align="center"><?php echo date('F'); ?></h3>

                    <div class="row">

                        <div class="col-md-12">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Expenses Name</th>
                                    <th>Amount</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($expenses as $key) { ?>
                                    <tr id="row<?php echo $i; ?>">
                                        <td  class="heading"><?php echo $i; ?></td>
                                        <td><?php echo $key['Expenses_Date']; ?></td>
                                        <td><?php echo $key['Expenses_Name']; ?></td>
                                        <td><?php echo $key['Amount']; ?>
                                            <input type="hidden" name="material_qty[]" value="<?php echo $key['Amount']; ?>">
                                        </td>
                                        <td><?php echo $key['Comments']; ?></td>

                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: bold;">Total Expenses</td>
                                    <td id="total_exp" style="font-weight: bold; font-size: 20px;"></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            <h4  align="center">Cash in Hand: <span><?php echo $petty_cash[0]['Petty_Cash']; ?></span></h4>

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
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        /*tfoot { display:table-footer-group }*/
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}


    }
</style>
<!--<script>$('#sampleTable').DataTable();</script>-->
<script>
    $( document ).ready(function() {

        var mqty =document.getElementsByName("material_qty[]");
        var sum_qty = 0;
        for (var j = 0, iLen = mqty.length; j < iLen; j++) {
            if (mqty[j].value!==""){
                val=parseFloat(mqty[j].value);
                sum_qty +=val;
            }
        }
        document.getElementById('total_exp').innerHTML = parseFloat(sum_qty);


    });
</script>





