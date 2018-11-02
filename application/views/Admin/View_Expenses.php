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
                                        <td><?php echo $key['Amount']; ?></td>
                                        <td><?php echo $key['Comments']; ?></td>

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
<!--<script>$('#sampleTable').DataTable();</script>-->





