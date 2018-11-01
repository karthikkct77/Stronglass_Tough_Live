
<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Despatch Report</h1>
            </div>
        </div>
        <div class="row">

            <?php if($this->session->flashdata('feedback')): ?>
                <script>
                    var res = "<?php echo $this->session->flashdata('feedback'); ?>";
                    swal({
                            title: "Failed!",
                            text: res,
                            type: "warning"
                        },
                        function(){
                            location.reload();
                        });
                </script>
            <?php endif; ?>

            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Today_Despatch_Print'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Print ?');">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Delivery Location</label>
                                        <select name="Delivery" class="form-control" id="Delivery"  required >
                                            <option value="" >Select Delivery Location</option>
                                            <option value="manapuram" >Manapuram</option>
                                            <option value="ernakulam" >Ernakulam</option>
                                            <option value="chennai" >Chennai</option>
                                            <option value="local" >Local</option>
                                        </select>
                                    </div>
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




