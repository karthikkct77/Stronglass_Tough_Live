<main class="app-content">
    <div   >
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
                                    <h4><span>Work Order No</span>: <?php echo $wo[0]['WO_Number']; ?></h4>
                                    <h4><span>Proforma No</span>  :<?php echo $wo[0]['WO_Number']; ?></h4>
                                    <h4><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Created_On']; echo date("H:i",strtotime($date)); ?></h4>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <h4><span>Project </span>:<?php echo $invoice[0]['Customer_Company_Name']; ?></h4>
                                <h4><span>Prepared Date</span>  :<?php echo date($wo[0]['WO_Date']); ?></h4>
                                <h4><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Date']; echo date('Y-m-d', strtotime($date. ' + 2 days')); ?></h4>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                    <th>#</th>
                                    <th>Material</th>
                                    <th>Actual<br>size(h)</th>
                                    <th>Actual<br>size(w)</th>
                                    <th>No.of<br>Pieces</th>
                                    <th>No.of<br>Holes</th>
                                    <th>Cutouts</th>
                                    <th>Special</th>
                                    <th>Area<br>(sqmtr)</th>
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
                            <div class="col-md-4">
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

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    @media print {
        #with_print {
            display: none;
        }
        @page { size: landscape; }
    }

    #search_data {
        width: 200px;
        padding: 5px;
        margin: 5px 0;
        box-sizing: border-box;
    }
    h4 span{
        width: 185px;
        float: left;
    }
    #autoSuggestionsList > li {
        background: none repeat scroll 0 0 #F3F3F3;
        border-bottom: 1px solid #E3E3E3;
        list-style: none outside none;
        padding: 3px 15px 3px 15px;
        text-align: left;
    }
    .st_check{
        padding-top: 15px;
        border-top: 1px solid #000000;
        text-align: center;
    }

    #autoSuggestionsList > li a { color: #800000; }

    .auto_list {
        border: 1px solid #E3E3E3;
        border-radius: 5px 5px 5px 5px;
        position: absolute;
    }
    .pi_button{
        margin-right: 15px;
        float: right;
    }

    /*.special{*/
    /*margin-left: 30px;*/
    /*font-weight: bold;*/
    /*font-size: 50px;*/
    /*position: absolute;*/
    /*top: -10px;*/
    /*}*/
    /*.st{*/
    /*text-align: center;*/
    /*float: left;*/
    /*width: 100%;*/
    /*font-weight: normal;*/
    /*position: relative;*/
    /*}*/
    /*.customer {*/
    /*font-weight: normal;*/
    /*font-size: 15px;*/
    /*margin-left: 10px;*/
    /*}*/
</style>

<script type="text/javascript">
    $( document ).ready(function() {
        number_to_words();
        var totals =document.getElementsByName("holes_print[]");
        var sum1 = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum1 +=val;
            }
        }
        document.getElementById('holes_print').innerHTML = sum1 ;

        var totals_cut =document.getElementsByName("cutout_print[]");
        var sum2 = 0;
        for (var j = 0, iLen = totals_cut.length; j < iLen; j++) {
            if (totals_cut[j].value!==""){
                val=parseFloat(totals_cut[j].value);
                sum2 +=val;
            }
        }
        document.getElementById('cutout_print').innerHTML = sum2 ;
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>


<script>

    // Number into words
    function number_to_words() {
        var th = ['', 'thousand', 'million', 'billion', 'trillion'];

        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        var s = document.getElementById('gross_tot').value;

        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s)) return 'not a number';
        var x = s.indexOf('.');
        if (x == -1) x = s.length;
        if (x > 15) return 'too big';
        var n = s.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }
        document.getElementById('word').innerHTML = str;
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }
</script>
