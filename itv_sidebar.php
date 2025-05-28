<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="dist/img/itinventory.png" alt="" class="" style="width:70px;height:15px;">
      <span class="brand-text font-weight-light">IT Inventory</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

<!-- Sidebar Menu -->
<!-- level administrator -->
      <?php
          if ($data_level == "1") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=itv_index" class="nav-link">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">LNSW MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=itv_trx_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Trx Type Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_itemcat_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Item Category Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_doc_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Document Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_unit_code" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Unit Code</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=company_view" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Company</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=po_view_doc" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK's Document PO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=so_view_doc" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK's Document SO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=po_view" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Purchase Order</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=so_view" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Sales Order</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=item_view" class="nav-link">
              <i class="nav-icon fas fa-stream"></i>
              <p>Registered Item in LNSW</p>
            </a>
          </li>
          <li class="nav-header">SUBMIT TO LNSW</li>
          <li class="nav-item">
            <a href="?page=beg_balance_view" class="nav-link">
              <i class="nav-icon fas fa-th-list"></i>
              <p>Beginning Balance</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=receipt_pur_view" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>Receipt From Purchase</p>
            </a>
            <li class="nav-item">
            <a href="?page=issued_sales_view" class="nav-link">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>Issued To Sales</p>
            </a>
          </li>
          </li><li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas  fa-hand-holding"></i>
              <p>Internal Receipt</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-luggage-cart"></i>
              <p>Internal Issued</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Adjustment</p>
            </a>
          </li>
          </li>
          <li class="nav-header">ACTION</li>
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link">
              <i class="nav-icon fas fa-close"></i>
              <p>Close</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level administrator --> 
<!-- level user test -->
<?php
          if ($data_level == "2") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=itv_index" class="nav-link">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">LNSW MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=itv_trx_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Trx Type Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_itemcat_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Item Category Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_doc_type" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Document Code</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=itv_unit_code" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Unit Code</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Company</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK's Document PO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK's Document SO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Purchase Order</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Sales Order</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-stream"></i>
              <p>Registered Item in LNSW</p>
            </a>
          </li>
          <li class="nav-header">SUBMIT TO LNSW</li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-th-list"></i>
              <p>Beginning Balance</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=receipt_pur_view" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>Receipt From Purchase</p>
            </a>
            <li class="nav-item">
            <a href="?page=issued_sales_view" class="nav-link">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>Issued To Sales</p>
            </a>
          </li>
          </li><li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas  fa-hand-holding"></i>
              <p>Internal Receipt</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-luggage-cart"></i>
              <p>Internal Issued</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Adjustment</p>
            </a>
          </li>
          </li>
          <li class="nav-header">ACTION</li>
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link">
              <i class="nav-icon fas fa-close"></i>
              <p>Close</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user test --> 
<!-- /.sidebar-menu -->
</aside>