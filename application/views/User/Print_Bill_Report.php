<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Invoice</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                    <div class="tile"  id="pagewidth">
                        <div class="row invoice">
                            <img style="position: absolute; width: 20% !important;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                            <h6>Invoice Report <span style="position: absolute; right: 20px;"></span></h6>
                            <h4><?php echo $st[0]['ST_Name']; ?></h4>
                            <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                            <h6><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                            <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
                            <h6>GSTN: 33ACYFS4034L2ZJ</h6>
                            <h6>ECC-NO: ACYFS4034LEM001</h6>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                               <h3>From Date: <?php echo $from_date; ?></h3>
                            </div>
                            <div class="col-md-4">
                                <h3>To Date: <?php echo $to_date; ?></h3>
                            </div>
                        </div>
                        <form method="post" class="login-form" action="<?php echo site_url('User_Controller/save_bill'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                            <div class="row">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                    <th style="width: 10px;">#</th>
                                    <th style="width: 20px;">Customer Name</th>
                                    <th style="width: 20px;">Invoice</th>
                                    <th style="width: 20px;">Wo.No</th>
                                    <th style="width: 20px;">PI.No</th>
                                    <th style="width: 20px;">Amount</th>
                                    <th style="width: 20px;">Date</th>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach ($bill_report as $val) { ?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                            <td><?php echo $val['Customer_Company_Name']; ?></td>
                                            <td><?php echo $val['Bill_Number']; ?></td>
                                            <td><?php echo $val['WO_Number']; ?></td>
                                            <td><?php echo $val['Proforma_Number']; ?></td>
                                            <td><?php echo $val['GrossTotal_Value']; ?></td>
                                            <td><?php echo $val['Created_On']; ?></td>
                                        </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</main>
<style type="text/css" media="print">
    .app-content{
        margin: 0px;
        padding: 0px;
    }
    #pagewidth {
        overflow: hidden ;


    }
    @media print {

        #with_print {
            display: none;
        }
        #pagewidth {   page-break-before: always;
        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}
        @page {
            size: A4;   /* auto is the initial value */
            margin: 0cm 0cm 0cm 0cm;
            marks: crop cross;
        }
    }
</style>
<style>
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    table td {
        text-align: center;
    }
    #account h5 span {
        float: left;
        width: 150px;
        font-weight: normal;
    }
    h5 span{
        float: left;
        width: 200px;
        font-weight: normal;
    }


</style>


<script>

    $(document).ready(function(){

        window.print();
        history.back();
    });

</script>

