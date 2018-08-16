<main class="app-content">
    <div  class="output" >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Work Order Print</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                    <div class="tile" id="page_setup">
                        <div class="row invoice">
                            <img style="position: absolute;width: 100px;height: auto;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                            <h5><?php echo $st[0]['ST_Name']; ?></h5>
                            <h6><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h6>
                            <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                        </div>
                        <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Stock Name</th>
                                            <th>Current Quantity</th>
                                            <th>Company Name</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($godown as $key) { ?>
                                            <tr id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                                <td><?php echo $key['Stock_Name']; ?><br>(<?php echo $key['Stock_Height']; ?>*<?php echo $key['Stock_Width']; ?>)</td>
                                                <td><?php echo $key['Current_Qty']; ?></td>
                                                <td><?php echo $key['Company_Name']; ?></td>
                                                <td><?php echo $key['added_Date']; ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>

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
        #page_setup {   page-break-before: always;
        }

    }
    @page
    {
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
    h4 span{
        width: 185px;
        float: left;
    }
    /* In CSS, not JavaScript */

</style>
<script type="text/javascript">
    $(document).ready(function(){
        window.print();
        history.back();
    });
</script>



