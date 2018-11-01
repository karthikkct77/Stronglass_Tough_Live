
<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>WO Summary</h1>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Print_WO_Report'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Print ?');">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>From</h4>
                                    <input class="form-control" id="demoDate" name="from_date" type="text" placeholder="Select from Date">
                                </div>
                                <div class="col-md-4">
                                    <h4>To</h4>
                                    <input class="form-control" id="demoDate1" name="to_date" type="text" placeholder="Select to Date">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-danger pi_button " type="submit" id="with_print"><i class="fa fa-fw fa-lg fa-check-circle"></i>Print_report</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<style type="text/css" media="print">

    #pagewidth {
        overflow: hidden ;
        /*width: 500px ;*/
    }
    @media print {
        #with_print {
            display: none;
        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}
    }
</style>
<script type="text/javascript">


    $('#demoDate').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    $('#demoDate1').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

</script>




