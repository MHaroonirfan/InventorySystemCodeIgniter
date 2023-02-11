

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-md-12 col-xs-12">
          <form class="form-inline" action="<?php echo base_url('reports/recovery') ?>" method="POST">
            <div class="form-group">
              <label for="date">From Date</label>
              <input type="date" name="from_date" value="<?php echo $from_date; ?>" />
            </div>
              <div class="form-group">
              <label for="date">To Date</label>
              <input type="date" name="to_date" value="<?php echo $to_date; ?>" />
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>

        <br /> <br />


        <div class="col-md-12 col-xs-12">

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
            
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recovery Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatables" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Pending Amount</th>
                    <!-- <th>Date</th> -->
                </tr>
                </thead>
                <tbody>

                  <?php
                  $total = 0;
                  $total_paid_amount = 0;
                  $total_pending_amount = 0;
                  //print_r($results);
                  foreach ($results['customer_data'] as $k => $value){ 
                    if($value['order_amount'][0]['gross_amount'] != ''){
                      $paid_amount = ($value['order_amount'][0]['balance_data'][0]['paid_amount'] != '')? $value['order_amount'][0]['balance_data'][0]['paid_amount']:0;
                  ?>
                    <tr>
                      <td><?php echo $value['name']; ?></td>
                      <td><?php echo $value['order_amount'][0]['gross_amount']; ?></td>
                      <td><?php echo $paid_amount; ?></td>
                      <td><?php echo $value['order_amount'][0]['gross_amount'] - $paid_amount; ?></td>
                      
                    </tr>
                  <?php
                  
                  if(count($value) > 1) {
                      $gross_amount = $value['order_amount'][0]['gross_amount'];
                      $total = $total+$gross_amount;
                      
                      $paid_amount_new = $paid_amount;
                      $total_paid_amount = $total_paid_amount+$paid_amount_new;
                      
                      $pending_amount = $value['order_amount'][0]['gross_amount'] - $paid_amount;
                      $total_pending_amount = $total_pending_amount+$pending_amount;
                  }
                    }
                   } ?>
                  
                </tbody>
                <tbody>
                  <tr>
                    <th>Total Amount</th>
                    <th>
                      <?php //echo $company_currency . ' ' . array_sum($parking_data); ?>
                      <?php echo $total; ?>
                    </th>
                  </tr>
                  <tr>
                    <th>Total Paid Amount</th>
                    <th><?php echo $total_paid_amount; ?></th>
                  </tr>
                  <tr>
                    <th>Total Pending Amount</th>
                    <th><?php echo $total_pending_amount; ?></th>
                  </tr>
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
      $("#mainReportsNav").addClass('active');
      $("#saleReportNav").addClass('active');
    }); 

  </script>
