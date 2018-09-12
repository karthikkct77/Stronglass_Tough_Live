
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Chat</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <?php
            if($_SESSION['role'] == 5)
            {
                if($msg_count[0]['msg'] == '0')
                { ?>
                    <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

                <?php  }
                else{ ?>
                    <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                    </li>

                <?php }
                ?>



            <?php   }
            elseif ($_SESSION['role'] == 10)
            {
                if($msg_count[0]['msg'] == '0')
                { ?>
                    <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

                <?php  }
                else{ ?>
                    <li><a  style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                    </li>

                <?php }
                ?>

            <?php  }
            elseif ($_SESSION['role'] == 11)
            {       if($msg_count[0]['msg'] == '0')
            { ?>
                <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

            <?php  }
            else{ ?>
                <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                </li>

            <?php }
                ?>

            <?php  } ?>

        </ul>
    </div>

    <?php
    $role = $this->session->userdata['role'];

    if($role == 5)
    { ?>
        <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#5a" role="tab" aria-controls="pills-home" aria-selected="true">Chennai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#1a" role="tab" aria-controls="pills-profile" aria-selected="false">Kerala</a>
                </li>
                      </ul>
            <div class="col-md-6">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="5a" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="tile" >
                                <h2>Chennai Customer </h2>
                                <div class="messanger">
                                    <div class="messages">
                                        <?php
                                        foreach ($chennai_msg as $key ) {
                                            if($key['Client_Icode'] != "0")
                                            { ?>
                                                <div class="message"><img src="<?php echo base_url('img/c.png'); ?>" >
                                                    <p class="info"><span style="display: block;width: 100%;color: black;"><?php echo $key['send_date']; ?>
                                            </span><?php echo $key['Client_Message']; ?></p>
                                                </div>

                                            <?php  }
                                            else
                                            {

                                            }
                                            if($key['User_Icode'] != "0")
                                            { ?>
                                                <div class="message me"><img src="<?php echo base_url('img/st.png'); ?>" >
                                                    <p class="info"><span style="display: block;width: 100%;color: #fff;"><?php echo $key['send_date']; ?></span>
                                                        <?php echo $key['Message']; ?></p>
                                                </div>

                                            <?php  }
                                            else
                                            {

                                            }
                                            ?>
                                            <?php
                                        }

                                        ?>
                                        <input type="hidden" name="client_type" value="chennai" id="client_type">
                                    </div>
                                    <div class="sender">
                                        <input type="text" placeholder="Send Message" name="message" id="admin_message_chennai">
                                        <button class="btn btn-primary" type="button" onclick="send_message_admin();" ><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                                    </div>
                                </div>

                            </div>
                  </div>
           <div class="tab-pane fade" id="1a" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="tile">
                <h2>Kerala Customer</h2>
                  <div class="messanger">
                      <div class="messages">
                          <?php
                          foreach ($kerala_msg as $key ) { ?>
                             <?php if($key['Client_Icode'] != "0")
                              { ?>
                                  <div class="message"><img src="<?php echo base_url('img/k.png'); ?>" >
                                      <p class="info"><span style="display: block;width: 100%;color: black;"><?php echo $key['send_date']; ?>
                                            </span><?php echo $key['Client_Message']; ?></p>
                                  </div>

                              <?php  }
                              else
                              {

                              }
                              if($key['User_Icode'] != "0")
                              { ?>
                                  <div class="message me"><img src="<?php echo base_url('img/st.png'); ?>" >
                                      <p class="info"><span style="display: block;width: 100%;color: #fff;"><?php echo $key['send_date']; ?></span>
                                          <?php echo $key['Message']; ?></p>
                                  </div>

                              <?php  }
                              else
                              {

                              }
                              ?>
                              <?php
                          }

                          ?>
                          <input type="hidden" name="client_type" value="kerala" id="client_type_kerala">
                      </div>
                      <div class="sender">
                          <input type="text" placeholder="Send Message" name="message" id="admin_message_kerala">
                          <button class="btn btn-primary" type="button" onclick="send_message_admin_kerala();" ><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                      </div>
                  </div>

            </div>
        </div>
            </div>
        </div>
        </div>
        </div>
    <?php }
    elseif ($role == 10)
    { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">chennai Chat</h3>
                    <div class="messanger">
                        <div class="messages">
                            <?php
                            foreach ($chennai_msg as $key ) {
                                if($key['User_Icode'] != "0")
                                { ?>
                                    <div class="message"><img src="<?php echo base_url('img/st.png'); ?>" >
                                        <p class="info"><span style="display: block;width: 100%;color: black;"><?php echo $key['send_date']; ?>
                                            </span><?php echo $key['Message']; ?></p>
                                    </div>

                                <?php  }
                                else
                                {

                                }

                                if($key['Client_Icode'] != "0")
                                { ?>
                                    <div class="message me"><img src="<?php echo base_url('img/c.png'); ?>" >
                                        <p class="info"><span style="display: block;width: 100%;color: #fff;"><?php echo $key['send_date']; ?></span>
                                            <?php echo $key['Client_Message']; ?></p>
                                    </div>

                                <?php  }
                                else
                                {

                                }


                                ?>
                                <?php
                            }

                            ?>
                            <input type="hidden" name="client_type" value="chennai" id="client_type">
                        </div>
                        <div class="sender">
                            <input type="text" placeholder="Send Message" name="message" id="message">
                            <button class="btn btn-primary" type="button" onclick="send_message();" ><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>


    <?php }
    elseif ($role == 11)
    { ?>

        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Chat</h3>
                    <div class="messanger">
                        <div class="messages">
                            <?php
                            foreach ($kerala_msg as $key ) {
                                if($key['User_Icode'] != "0")
                                { ?>
                                    <div class="message"><img src="<?php echo base_url('img/st.png'); ?>" >
                                        <p class="info"><span style="display: block;width: 100%;color: black;"><?php echo $key['send_date']; ?>
                                            </span><?php echo $key['Message']; ?></p>
                                    </div>

                                <?php  }
                                else
                                {

                                }

                                if($key['Client_Icode'] != "0")
                                { ?>
                                    <div class="message me"><img src="<?php echo base_url('img/k.png'); ?>" >
                                        <p class="info"><span style="display: block;width: 100%;color: #fff;"><?php echo $key['send_date']; ?></span>
                                            <?php echo $key['Client_Message']; ?></p>
                                    </div>

                                <?php  }
                                else
                                {

                                }


                                ?>
                                <?php
                            }

                            ?>
                            <input type="hidden" name="client_type" value="kerala" id="client_type">
                        </div>
                        <div class="sender">
                            <input type="text" placeholder="Send Message" name="message" id="message">
                            <button class="btn btn-primary" type="button" onclick="send_message();" ><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>


    <?php }
    ?>




</main>
<script>
    $(document).ready(function() {
        /*stay in same tab after form submit*/
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){

            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
        }
        $('#tblCustomers5').DataTable();
        $('#tblCustomers4').DataTable();
//        $('#tblCustomers3').DataTable();
//        $('#tblCustomers2').DataTable();
//        $('#tblCustomers1').DataTable();
        $(".messages").animate({ scrollTop: $(document).height() }, "slow");
        return false;
    } );

    function send_message() {

        var msg = document.getElementById('message').value;
        var type = document.getElementById('client_type').value;

        $.ajax({
            url: "<?php echo site_url('User_Controller/save_message'); ?>",
            data: {
                message: msg,
                ctype: type
            },
            type: "POST",
            context: document.body,
            success: function (data) {
                if (data == 1) {
                    location.reload();
                }
            }
        });
    }

    function send_message_admin() {
        var msg = document.getElementById('admin_message_chennai').value;
        var type = document.getElementById('client_type').value;

        $.ajax({
            url: "<?php echo site_url('User_Controller/save_admin_message'); ?>",
            data: {
                message: msg,
                ctype: type
            },
            type: "POST",
            context: document.body,
            success: function (data) {
                if (data == 1) {
                    location.reload();
                }
            }
        });
    }

    function send_message_admin_kerala() {
        var msg = document.getElementById('admin_message_kerala').value;
        var type = document.getElementById('client_type_kerala').value;

        $.ajax({
            url: "<?php echo site_url('User_Controller/save_admin_message'); ?>",
            data: {
                message: msg,
                ctype: type
            },
            type: "POST",
            context: document.body,
            success: function (data) {
                if (data == 1) {
                    location.reload();
                }
            }
        });
    }

</script>






