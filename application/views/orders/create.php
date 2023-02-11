

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
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
            <h3 class="box-title">Add Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('orders/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Date:</label>
                        <input type="date" class="col-sm-6" name="date" id="datePicker" autocomplete="off" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 control-label">Time:</label>
                        <input type="time" class="col-sm-6" name="time" value="now" autocomplete="off" />
                    </div>
                </div>
                  <?php // echo date('Y-m-d') ?>
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
                      <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Enter Customer Address" autocomplete="off" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Phone</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Customer Phone" autocomplete="off">
                    </div>
                  </div>
                </div>
                
                
                <br /> <br/>
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:50%">Product</th>
                      <th style="width:10%">Qty</th>
                      <th style="width:10%">Rate</th>
                      <th style="width:20%">Amount</th>
                      <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>

                   <tbody>
                     <tr id="row_1">
                       <td>
                        <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width:100%;" onchange="getProductData(1)" required>
                            <option value=""></option>
                            <?php foreach ($products as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" price="<?php echo $v['price'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td><input type="text" name="qty[]" id="qty_1" class="form-control" required onkeyup="getTotal(1)"></td>
                        <td>
                          <input type="text" name="rate[]" id="rate_1" onkeyup="getTotal(1)" class="form-control" autocomplete="off">
                          <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control" autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="amount[]" id="amount_1" class="form-control" autocomplete="off">
                          <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control" autocomplete="off">
                        </td>
                        <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td>
                     </tr>
                   </tbody>
                </table>

                <br /> <br/>

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gross_amount" name="gross_amount" autocomplete="off">
                      <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                    </div>
                  </div>
                  <?php if($is_service_enabled == true): ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php if($is_vat_enabled == true): ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">Vat <?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="net_amount" name="net_amount" autocomplete="off">
                      <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="paid_amount" class="col-sm-5 control-label">Paid Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="paid_amount" name="paid_amount" autocomplete="off" value="0">
                    </div>
                  </div>
                 <div class="form-group">
                  <label for="payment_method" class="col-sm-5 control-label">Payment Method</label>
                  <div class="col-sm-7">
                  <select class="form-control" id="payment_method" name="payment_method">
                    <option value="1-Cash">Cash in hand</option>
                    <option value="2-BankTransfer">Bank Transfer</option>
                  </select>
                </div>
                 </div>
                 <div class="form-group">
                  <label for="order_status" class="col-sm-5 control-label">Payment Status</label>
                  <div class="col-sm-7">
                  <select class="form-control" id="order_status" name="order_status">
                    <option value="1">Pending</option>
                    <option value="2">Debit</option>
                    <option value="3">Paid</option>
                  </select>
                </div>
                 </div>

                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                <button type="submit" class="btn btn-primary">Create Order</button>
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

  function isDoubleClicked(element) {
      //if already clicked return TRUE to indicate this click is not allowed
      if (element.data("isclicked")) return true;

      //mark as clicked for 1 second
      element.data("isclicked", true);
      setTimeout(function () {
          element.removeData("isclicked");
      }, 1000);

      //return FALSE to indicate this click was allowed
      return false;
  }

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
  
    // Add new row in the table
    var row_id = 0; 
    $("#add_row").on('click', function() {
      if (isDoubleClicked($(this))) return;
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      //var row_id = count_table_tbody_tr + 1;
      // if($("#row_"+row_id).length < 1){
      //    row_id = count_table_tbody_tr + 1;
      // }else{
      //   row_id = row_id + 2;
      // }
      var tr_id,tr_number = 0;
      $("#product_info_table tbody tr").each(function() {

        tr_id = $(this).attr('id');
        tr_number = parseInt(tr_id.split("_").pop());
        // console.log(tr_id);
        // console.log(tr_number);
        if($("#"+tr_id).length>0){
            tr_number = tr_number +1;
        }else{

        }

      });

      row_id = tr_number;

      $.ajax({
          url: base_url + '/orders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
            
              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'" price="'+value.price+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="text" name="qty[]" id="qty_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" onkeyup="getTotal('+row_id+')"><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control"><input type="hidden" name="amount_value[]" id="amount_value_'+row_id+'" class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
              }
              else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();

          }
        });

      return false;
      row++;
    });
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
  
  function getTotal(row = null) {
    $('.loading').show();
    if(row) {
      $("#rate_value_"+row).val($("#rate_"+row).val());
      var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      
      subAmount();
      $('.loading').hide();

    } else {
      alert('no row !! please refresh the page');
      $('.loading').hide();
    }
  }

  // get the product information from the server
  function getProductData(row_id)
  {
    var price = $('option:selected', $('#product_'+row_id)).attr('price');
    //var product_id = $("#product_"+row_id).val();    
    // if(product_id == "") {
    //   $("#rate_"+row_id).val("");
    //   $("#rate_value_"+row_id).val("");

    //   $("#qty_"+row_id).val("");           

    //   $("#amount_"+row_id).val("");
    //   $("#amount_value_"+row_id).val("");

    // } else {
      // $.ajax({
        // url: base_url + 'orders/getProductValueById',
        // type: 'post',
        // data: {product_id : product_id},
        // dataType: 'json',
        // success:function(response) {
          // setting the rate value into the rate input field
          
          $("#rate_"+row_id).val(price);
          $("#rate_value_"+row_id).val(price);

          $("#qty_"+row_id).val(1);
          $("#qty_value_"+row_id).val(1);

          var total = Number(price) * 1;
          total = total.toFixed(2);
          $("#amount_"+row_id).val(total);
          $("#amount_value_"+row_id).val(total);
          
          subAmount();
      //   } // /success
      // }); // /ajax function to fetch the product data 
    //}
  }

  // calculate the total amount of the order
  function subAmount() {
    var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
    var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for(x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_"+count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val())/100) * vat_charge;
    vat = vat.toFixed(2);
    $("#vat_charge").val(vat);
    $("#vat_charge_value").val(vat);

    // service
    var service = (Number($("#gross_amount").val())/100) * service_charge;
    service = service.toFixed(2);
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);
    
    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    var discount = $("#discount").val();
    if(discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
      
    } // /else discount 

  } // /sub total amount

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
    //reassignid();
  }

  function reassignid(){
    var table = $("#product_info_table");
    var i = 0;
    $('#product_info_table > tbody  > tr').each(function(index, tr) { 
       $('#product_info_table > tbody  > tr').eq(i).prop('id', 'row_' + (i + 1));
       $('#product_info_table > tbody  > tr').find("td").text();
       i++;
    });
  }
  
    // get the customer information from the server

    $("#customer_id").change(function() {
    var customer_id = $("#customer_id").val();    

      $.ajax({
        url: base_url + 'customers/fetchCustomerDetailById',
        type: 'post',
        data: {customer_id : customer_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          
          $("#customer_address").val(response.address);
          $("#customer_phone").val(response.phone);

        } // /success
      }); // /ajax function to fetch the product data 
    });
</script>