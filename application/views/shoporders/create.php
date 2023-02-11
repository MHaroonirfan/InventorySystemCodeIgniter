

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Transfer Stock From Warehouse to Shop</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Transfer Stock From Warehouse to Shop</li>
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
            <h3 class="box-title">Add Transfer Stock From Warehouse to Shop</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('shoporders/create') ?>" method="post" class="form-horizontal">
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
                <br /> <br/>
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:50%">Product</th>
                      <th style="width:10%">Qty</th>
                      <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>

                   <tbody>
                     <tr id="row_1">
                       <td>
                        <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width:100%;" onchange="getProductData(1)" required>
                            <option value=""></option>
                            <?php foreach ($products as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" qty="<?php echo $v['qty'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td><input type="number" name="qty[]" id="qty_1" class="form-control" required></td>
                        <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td>
                     </tr>
                   </tbody>
                </table>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Create Transfer Stock</button>
                <a href="<?php echo base_url('shoporders/') ?>" class="btn btn-warning">Back</a>
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

    $("#mainShopOrdersNav").addClass('active');
    $("#addShopOrderNav").addClass('active'); 
  
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
          url: base_url + '/shoporders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
            
              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'" qty="'+value.qty+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number" name="qty[]" id="qty_'+row_id+'" class="form-control"></td>'+
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
  
  // get the product information from the server
  function getProductData(row_id)
  {
    var qty = $('option:selected', $('#product_'+row_id)).attr('qty');
    if(qty == 0){
      alert('Product Stock is out');
    }else{
    // var product_id = $("#product_"+row_id).val();    
    // if(product_id == "") {
    //   $("#qty_"+row_id).val("");
    // } else {
    //   $.ajax({
    //     url: base_url + 'shoporders/getProductValueById',
    //     type: 'post',
    //     data: {product_id : product_id},
    //     dataType: 'json',
    //     success:function(response) {
    //         $("#qty_"+row_id).attr({
    //             "max" : response.qty,        // substitute your own
    //             "min" : 1          // values (or variables) here
    //         });
          // setting the rate value into the rate input field
          $("#qty_"+row_id).val(qty);
    }
    //     } // /success
    //   }); // /ajax function to fetch the product data 
    // }
  }

  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
  }

</script>