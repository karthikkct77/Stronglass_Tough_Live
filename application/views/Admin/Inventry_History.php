<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Inventry Inward History</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('Admin_Controller/Charges_Entry'); ?>">Inventry Entry</a></li>
            <li class="breadcrumb-item"><a href="#">Inventry Inward History</a></li>
        </ul>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">By Date Range</h3>
                <div class="tile-body">
                      <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>From Date</label>
                                      <input class="form-control" id="demoDate" type="text" placeholder="Select Date">                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>To Date</label>
                                      <input  class="form-control"  type="text" name="to_date"  data-date-format="yyyy-mm-dd" id="mydate1" placeholder="To Date" required>

                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <button type="button" class="btn btn-success"  onclick="search_bde_data()" >Search</button>
                                      <button type="button" class="btn btn-danger"  onclick="refresh()" >Reset</button>
                                  </div>
                              </div>
                      </div>
                    <hr>

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Charges Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($charges as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['charge_name']; ?></td>
                                <td><?php echo $val['charge_current_price']; ?></td>
                                <td><button class="btn btn-info" onclick="view_reviced_charges('<?php echo $val['charge_icode']; ?> ')">View</button></td>
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
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">By Material</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Charges old Price</th>
                            <th>Updated ON</th>
                        </tr>
                        </thead>
                        <tbody id="result">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>$('#sampleTable').DataTable();</script>
<script type="text/javascript">
    $('#demoDate').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    function view_reviced_charges (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/View_Charges_Revice_History'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#View").show();
                $("#result").html(server_response);
            }
        });
    }
</script>