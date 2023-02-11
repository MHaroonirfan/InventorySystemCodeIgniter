

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
      <li class="active">Balance</li>
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
            <h3 class="box-title">Add Customer Balance</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('balance/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                  <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Date:</label>
                        <input type="date" class="col-sm-6" id="datePicker" name="date" autocomplete="off" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Time:</label>
                        <input type="time" class="col-sm-6" name="time" value="now" autocomplete="off" />
                    </div>
                </div>
<!--                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: <?php // echo date('Y-m-d') ?></label>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: <?php // echo date('h:i a') ?></label>
                </div>-->


                <div class="col-md-4 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select class="form-control select_group" id="customer_id" name="customer_id">
                        <option>Select</option>
                      <?php foreach ($customers as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Address</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_address" name="customer_address" autocomplete="off" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Phone</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_phone" name="customer_phone" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>                  
                  
                <div class="col-md-4 col-xs-12 pull pull-right">

                  <!-- <div class="form-group">
                    <label for="order_id">Orders</label>
                    <select class="form-control select_group" id="order_id" name="order_id">
                        <option>Select</option>
                    </select>
                  </div> -->
                  <div class="form-group">
                    <label for="order_amount" class="col-sm-5 control-label" style="text-align:left;">Total Amount</label>
                    <div class="col-sm-7">
                      <input type="number" class="form-control" id="order_amount" name="order_amount" step="any" autocomplete="off" readonly>
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label for="paid_amount" class="col-sm-5 control-label" style="text-align:left;">Paid Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="paid_amount" name="paid_amount" autocomplete="off" readonly>
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label for="pending_amount" class="col-sm-5 control-label" style="text-align:left;">Pending Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="pending_amount" name="pending_amount" autocomplete="off" readonly>
                      <input type="hidden" id="hidden_pending_amount" name="hidden_pending_amount">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="lease_amount" class="col-sm-5 control-label" style="text-align:left;">Add Lease Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="lease_amount" name="lease_amount" onkeyup="updateAmount()" autocomplete="off" required>
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <label for="payment_method" class="col-sm-5 control-label" style="text-align:left;">Payment Method</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="payment_method" autocomplete="off" required>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning">Back</a>
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
    $("#addBalanceNav").addClass('active');

    document.getElementById('datePicker').valueAsDate = new Date();
  }); // /document

  $(function(){     
    var d = new Date(),        
      h = d.getHours(),
      m = d.getMinutes();
    if(h < 10) h = '0' + h; 
    if(m < 10) m = '0' + m; 
    $('input[type="time"][value="now"]').each(function(){ 
    $(this).attr({'value': h + ':' + m});
    });
  });
  
    // get the customer information from the server

    $("#customer_id").change(function() {
    var customer_id = $("#customer_id").val();    
    $("#order_id").html('');
      $.ajax({
        url: base_url + 'balance/fetchCustomerDataById',
        type: 'post',
        data: {customer_id : customer_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          // $("#order_id").append('<option>Select</option>');
          // $.each(response.order_data,function(key, value)
          //       {
          //           $("#order_id").append('<option value=' + value.order_id + ' order_amount=' + value.net_amount + '>' + value.bill_no + '</option>');
                    
          //       });
          //console.log(response);
          $('#order_amount').val(response.order_data.order_amount);
          $('#paid_amount').val(response.balance_data.paid_amount);
          $('#pending_amount').val(response.order_data.order_amount - response.balance_data.paid_amount);
          $('#hidden_pending_amount').val(response.order_data.order_amount - response.balance_data.paid_amount);
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