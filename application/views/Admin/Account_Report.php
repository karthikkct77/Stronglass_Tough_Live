<style></style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Account Summery</h1>
        </div>

    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-12">

            <div class="tile" id="pagewidth">
                <img style="width: 5%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                <h3 class="tile-title" style="text-align: center;">Monthly Accounts Summary</h3>
                <h4  class="tile-title" style="text-align: center;"><?php echo date('F'); ?></h4>

                <div class="tile-body">
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <table class="table table-hover table-bordered">


                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Total WO</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_count']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Total Bill</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $bill_count[0]['Bill_Count']; ?></td>
                        </tr>

                    </table>

                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>WO.NO</th>
                            <th>Amount</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Bill NO</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($bill_account as $val)
                        {

                            ?>
                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['wo_total']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $val['WO_Date']; ?></td>
                                <td><?php echo $val['Bill_Number']; ?></td>
                                <td><?php echo $val['GrossTotal_Value']; ?></td>
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



