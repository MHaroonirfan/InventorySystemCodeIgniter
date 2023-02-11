

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Customer Balance</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Customer Balance</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Customer Balance</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('balance/update') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                  <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Date:</label>
                        <input type="date" class="col-sm-6" name="date" autocomplete="off" value="<?php echo $order_data->date ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Time:</label>
                        <input type="time" class="col-sm-6" name="time" autocomplete="off" value="<?php echo $order_data->time ?>" />
                    </div>
                </div>
<!--                <div class="form-group">
                  <label for="date" class="col-sm-12 control-label">Date: <?php // echo date('Y-m-d') ?></label>
                </div>
                <div class="form-group">
                  <label for="time" class="col-sm-12 control-label">Date: <?php // echo date('h:i a') ?></label>
                </div>-->

                <div class="col-md-4 col-xs-12 pull pull-left">
                  <div class="form-group">
                  <label for="customer_id" class="col-sm-5 control-label" style="text-align:left;">Customer</label>
                  <div class="col-sm-7">
                    <select class="form-control select_group" id="customer_id" name="customer_id">
                      <?php foreach ($customers as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>" <?php if($order_data->customer_id == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                    <?php foreach ($customers as $k => $v) {?>
                    <?php if($order_data->customer_id == $v['id']) { ?>
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Address</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_address" name="customer_address" value="<?php echo $v['address'] ?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Phone</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo $v['phone'] ?>" autocomplete="off">
                    </div>
                  </div>
                    <?php 
                    }
                    } ?>
                </div>
                  
                <div class="col-md-4 col-xs-12 pull pull-right">
                    
                  <div class="form-group">
                    <label for="total_amount" class="col-sm-5 control-label" style="text-align:left;">Total Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="total_amount" value="<?php echo $orders['order_data']['order_amount'];?>" autocomplete="off" />
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label for="paid_amount" class="col-sm-5 control-label" style="text-align:left;">Paid Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="paid_amount" name="paid_amount" value="<?php echo $orders['balance_data']['paid_amount'];?>" autocomplete="off">
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label for="pending_amount" class="col-sm-5 control-label" style="text-align:left;">Pending Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="pending_amount" name="pending_amount" autocomplete="off" value="<?php echo $orders['order_data']['order_amount'] - $orders['balance_data']['paid_amount'];?>" readonly>
                      <input type="hidden" id="hidden_pending_amount" name="hidden_pending_amount" value="<?php echo $orders['order_data']['order_amount'] - $orders['balance_data']['paid_amount'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lease" class="col-sm-5 control-label" style="text-align:left;">Add More Lease</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="lease_amount" name="lease_amount" onkeyup="updateAmount()" autocomplete="off">
                    </div>
                  </div>  
                  <div class="form-group">
                    <label for="paid_amount" class="col-sm-5 control-label" style="text-align:left;">Payment Method</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="payment_method" value="<?php echo $order_data->payment_method; ?>" autocomplete="off" required>
                    </div>
                  </div>
                  
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('balance/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainBalanceNav").addClass('active');
    $("#manageBalanceNav").addClass('active');
   
  }); // /document

  // get the customer information from the server


    $("#customer_id").change(function() {
    var customer_id = $("#customer_id").val();    
    $("#order_id").html('');
    $("#order_amount").val('');
    $("#paid_amount").val('');
    $('#pending_amount').val('');
      $.ajax({
        url: base_url + 'balance/fetchCustomerDataById',
        type: 'post',
        data: {customer_id : customer_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          $("#order_id").append('<option>Select</option>');
          $.each(response.order_data,function(key, value)
                {
                    $("#order_id").append('<option value=' + value.order_id + ' order_amount=' + value.net_amount + '>' + value.bill_no + '</option>');
                    
                });
          $("#customer_address").val(response.customer_data.address);
          $("#customer_phone").val(response.customer_data.phone);

        } // /success
      }); // /ajax function to fetch the product data 
    });
    
    $("#order_id").change(function() {
       var order_amount = $('option:selected', this).attr('order_amount');
       $("#order_amount").val(order_amount);
    });
    
    function updateAmount(){
        
        if($('#pending_amount').val() == ''){
          alert('please select customer first');
        }else{
          var pending_amount = $('#hidden_pending_amount').val();
          var lease_amount = $('#lease_amount').val();
          
          var remain_amount = 0;
          if(parseInt(lease_amount) > parseInt(pending_amount)){
            alert('value is greaten than the amount');
          }else{
            remain_amount = pending_amount - lease_amount;
            $('#pending_amount').val(remain_amount);
          }
        }
        //$('#pending_amount').val(remain_amount);
        
    }
</script>