
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Report
      <small>Customer Balance</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Customer Balance Report</li>
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
            <h3 class="box-title"><strong>Report Customer Balance: <?php echo $customer;?></strong></h3>
            <button class="btn btn-primary print_report" style="float: right; cursor: pointer;">Print Report</button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table" >
              <thead>
              <tr>
                <th>Bill Date</th>
                <th>Bill Detail</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Pending Amount</th>
              </tr>
              </thead>
              <tbody>
                  <?php
                  $total_amount = 0;
                  $paid_amount = 0;
                  $pending_amount = 0;
                  foreach ($data as $key => $value) {
                      ?>
                  <tr class="<?php echo $key;?>">
                      <td class="bill_no" style="display: none;"><?php if($value['bill_no'] == ''){echo 0;}else{echo $value['bill_no'];}
                        ?>
                      </td>
                      <td>
                        <?php 
                        echo $value['balance_paid_on'];
                        // if($value['bill_no'] == ''){
                        //   echo $value['balance_paid_on']; 
                        // }else{
                        //   echo $value['order_paid_on']; 
                        // }
                        ?>
                      </td>
                      <td><?php echo $value['bill_no']; ?><br>
                        <?php

                        if(array_key_exists('orderitems',$value)){
                          foreach ($value['orderitems'] as $key1 => $items) {
                            echo '<strong>Items: </strong>'.$items['qty'].' x '.$items['products']['name'].' => '.$items['rate'].'<br>';
                          }

                          echo '<strong>Order Amount: </strong>'.$value['gross_amount'].'<br>';
                        }else{
                          
                        }
                        
                        ?>

                      </td>
                      <td class="payment_by"><?php echo $value['payment_by']; ?></td>
                      <td class="total_amount"><?php echo $value['gross_amount']; ?></td>
                      <td class="paid_amount"><?php echo $value['paid_amount']; ?></td>
                      <td class="pending_amount"><?php echo $value['pending_amount']; ?></td>
                  </tr>
              	<?php
              		}
                ?>
              </tbody>
              
            </table>
          </div>
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

$(document).ready(function() {

  $("#mainBalanceNav").addClass('active');
  $("#manageBalanceNav").addClass('active');

  var pending_amount = 0;
  var total_amount_paid = 0;
  $('table > tbody  > tr').each(function(index, tr) {     
     if(index > 0){        
        if($('table > tbody  > tr').eq(index).find('td.bill_no').html() == 0 && $('table > tbody  > tr').eq(index-1).find('td.bill_no').html() != 0 || $('table > tbody  > tr').eq(index).find('td.bill_no').html() == $('table > tbody  > tr').eq(index-1).find('td.bill_no').html()){
          $('table > tbody  > tr').eq(index).find('td.total_amount').html(parseInt($('table > tbody  > tr').eq(index-1).find('td.pending_amount').html()));
        }else{
          $('table > tbody  > tr').eq(index).find('td.total_amount').html(parseInt($('table > tbody  > tr').eq(index-1).find('td.pending_amount').html()) + parseInt($('table > tbody  > tr').eq(index).find('td.total_amount').html()));
        }

        $('table > tbody  > tr').eq(index).find('td.pending_amount').html(parseInt($('table > tbody  > tr').eq(index).find('td.total_amount').html()) - parseInt($('table > tbody  > tr').eq(index).find('td.paid_amount').html()));
        // if(parseInt($('table > tbody  > tr').eq(index).find('td.lease_amount').html()) == 0){

        //   $('table > tbody  > tr').eq(index).find('td.pending_amount').html(parseInt($('table > tbody  > tr').eq(index).find('td.total_amount').html()) - parseInt($('table > tbody  > tr').eq(index).find('td.paid_amount').html()));

        // }else{

        //   $('table > tbody  > tr').eq(index).find('td.pending_amount').html(parseInt($('table > tbody  > tr').eq(index).find('td.total_amount').html()) - parseInt($('table > tbody  > tr').eq(index).find('td.lease_amount').html()));

        // }
     }

     if($('table > tbody  > tr').eq(index).find('td.paid_amount').html() == 0){
        $('table > tbody  > tr').eq(index).find('td.payment_by').html('');
     }
  });

  

});


$('.print_report').on("click", function () {
    $('#manageTable').printThis({
      importCSS: true,
      importStyle: true,
      loadCSS: "<?php echo base_url('assets/custom.css') ?>"
    });
});
</script>
