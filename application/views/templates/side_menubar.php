<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <?php if($user_permission): ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Add User</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>


          <?php if(in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
            <li id="brandNav">
              <a href="<?php echo base_url('brands/') ?>">
                <i class="glyphicon glyphicon-tags"></i> <span>Brands</span>
              </a>
            </li>
          <?php endif; ?>

        <?php if(in_array('createExpense', $user_permission) || in_array('updateExpense', $user_permission) || in_array('viewExpense', $user_permission) || in_array('deleteExpense', $user_permission)): ?>
            <li id="brandNav">
              <a href="<?php echo base_url('expenses/') ?>">
                <i class="fa fa-money"></i> <span>Expenses</span>
              </a>
            </li>
          <?php endif; ?>
            
          <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
            <li id="categoryNav">
              <a href="<?php echo base_url('category/') ?>">
                <i class="fa fa-files-o"></i> <span>Category</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if(in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
            <li id="storeNav">
              <a href="<?php echo base_url('stores/') ?>">
                <i class="fa fa-files-o"></i> <span>Stores</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if(in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
          <li id="attributeNav">
            <a href="<?php echo base_url('attributes/') ?>">
              <i class="fa fa-files-o"></i> <span>Attributes</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if(in_array('createSupplier', $user_permission) || in_array('updateSupplier', $user_permission) || in_array('viewSupplier', $user_permission) || in_array('deleteSupplier', $user_permission)): ?>
            <li id="supplierNav">
              <a href="<?php echo base_url('suppliers/') ?>">
                <i class="fa fa-users"></i> <span>Suppliers</span>
              </a>
            </li>
          <?php endif; ?>
            
          <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
            <li class="treeview" id="mainProductNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Products</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createProduct', $user_permission)): ?>
                  <li id="addProductNav"><a href="<?php echo base_url('products/create') ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
                <?php endif; ?>
                <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                <li id="manageProductNav"><a href="<?php echo base_url('products') ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

            <?php if(in_array('createCustomer', $user_permission) || in_array('updateCustomer', $user_permission) || in_array('viewCustomer', $user_permission) || in_array('deleteCustomer', $user_permission)): ?>
            <li id="customerNav">
              <a href="<?php echo base_url('customers/') ?>">
                <i class="fa fa-users"></i> <span>Customers</span>
              </a>
            </li>
          <?php endif; ?>
            
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addOrderNav"><a href="<?php echo base_url('orders/create') ?>"><i class="fa fa-circle-o"></i> Add Order</a></li>
                <?php endif; ?>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('orders') ?>"><i class="fa fa-circle-o"></i> Manage Orders</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
          <?php if(in_array('createShopOrder', $user_permission) || in_array('updateShopOrder', $user_permission) || in_array('viewShopOrder', $user_permission) || in_array('deleteShopOrder', $user_permission)): ?>
            <li class="treeview" id="mainShopOrdersNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span> Transfer Stock</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createShopOrder', $user_permission)): ?>
                  <li id="addShopOrderNav"><a href="<?php echo base_url('shoporders/create') ?>"><i class="fa fa-circle-o"></i> Add Transfer Stock</a></li>
                <?php endif; ?>
                <?php if(in_array('updateShopOrder', $user_permission) || in_array('viewShopOrder', $user_permission) || in_array('deleteShopOrder', $user_permission)): ?>
                <li id="manageShopOrdersNav"><a href="<?php echo base_url('shoporders') ?>"><i class="fa fa-circle-o"></i> Manage Transfer Stock</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>


          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainPurchaseNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Purchase</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addPurchaseNav"><a href="<?php echo base_url('purchase/create') ?>"><i class="fa fa-circle-o"></i> Add Purchase</a></li>
                <?php endif; ?>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="managePurchaseNav"><a href="<?php echo base_url('purchase') ?>"><i class="fa fa-circle-o"></i> Manage Purchases</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

            <?php if(in_array('createBalance', $user_permission) || in_array('updateBalance', $user_permission) || in_array('viewBalance', $user_permission) || in_array('deleteBalance', $user_permission)): ?>
            <li class="treeview" id="mainBalanceNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Balance</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createBalance', $user_permission)): ?>
                  <li id="addBalanceNav"><a href="<?php echo base_url('balance/create') ?>"><i class="fa fa-circle-o"></i> Add Balance</a></li>
                <?php endif; ?>
                <?php if(in_array('updateBalance', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageBalanceNav"><a href="<?php echo base_url('balance') ?>"><i class="fa fa-circle-o"></i> Manage Balance</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
            
            <?php if(in_array('accounts', $user_permission)): ?>
            <li class="treeview" id="mainAccountsNav">
              <a href="#">
                <i class="glyphicon glyphicon-stats"></i>
                <span>Accounts</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('accounts', $user_permission)): ?>
                  <li id="cashAccountNav"><a href="<?php echo base_url('accounts/cash') ?>"><i class="fa fa-circle-o"></i> Cash Orders</a></li>
                <?php endif; ?>
                <?php if(in_array('accounts', $user_permission)): ?>
                <li id="bankAccountNav"><a href="<?php echo base_url('accounts/bank') ?>"><i class="fa fa-circle-o"></i> Bank Orders</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
            
            <?php if(in_array('viewReports', $user_permission)): ?>
            <li class="treeview" id="mainReportsNav">
              <a href="#">
                <i class="glyphicon glyphicon-stats"></i>
                <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('viewReports', $user_permission)): ?>
                  <li id="reportNav"><a href="<?php echo base_url('reports/') ?>"><i class="fa fa-circle-o"></i> Reports</a></li>
                <?php endif; ?>
                <?php if(in_array('viewSales', $user_permission)): ?>
                <li id="saleReportNav"><a href="<?php echo base_url('reports/sale') ?>"><i class="fa fa-circle-o"></i> Sales</a></li>
                <?php endif; ?>
                <?php if(in_array('viewPurchases', $user_permission)): ?>
                <li id="prchaseReporttNav"><a href="<?php echo base_url('reports/purchase') ?>"><i class="fa fa-circle-o"></i> Purchases</a></li>
                <?php endif; ?>
                <?php if(in_array('viewRecovery', $user_permission)): ?>
                <li id="prchaseReporttNav"><a href="<?php echo base_url('reports/recovery') ?>"><i class="fa fa-circle-o"></i> Recovery</a></li>
                <?php endif; ?>
                <?php if(in_array('viewRecovery', $user_permission)): ?>
                <li id="expenseReporttNav"><a href="<?php echo base_url('expenses/report') ?>"><i class="fa fa-circle-o"></i> Expenses Report</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
      
          <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Company</span></a></li>
          <?php endif; ?>

        

        <!-- <li class="header">Settings</li> -->

        <?php if(in_array('viewProfile', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profile</span></a></li>
        <?php endif; ?>
        <?php if(in_array('updateSetting', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
        <?php endif; ?>

        <?php endif; ?>
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>