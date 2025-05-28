<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="dist/img/itinventory.ico" alt="IT™ - SASH" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">IT Inventory Gen 2.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?= $data_nama; ?></a>
        </div>
      </div>

<!-- Sidebar Menu -->
<!-- level administrator -->
      <?php
          if ($data_level == "1") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=bp_view" class="nav-link">
              <i class="nav-icon fas fa-address-card"></i>
              <p>Business Partner</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=item_view" class="nav-link">
              <i class="nav-icon fas fa-shapes"></i>
              <p>Item General</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=unit_view" class="nav-link">
              <i class="nav-icon fas fa-monument"></i>
              <p>Unit</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=bom_view" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Bill of Material</p>
            </a>
          </li>
          <li class="nav-header">EXIM</li>
          <li class="nav-item">
            <a href="?page=exim_po_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document PO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=exim_so_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document SO</p>
            </a>
          </li>
          <li class="nav-header">PURCHASE</li>
          <li class="nav-item">
            <a href="?page=po_view" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Purchase Order</p>
            </a>
          </li>
          <li class="nav-header">SALES</li>
          <li class="nav-item">
            <a href="?page=so_view" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Sales Order</p>
            </a>
          </li>
          <li class="nav-header">PRODUCTION</li>
          <li class="nav-item">
            <a href="?page=pro_view" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Production Order</p>
            </a>
          </li>
          <li class="nav-header">SCRAP</li>
          <li class="nav-item">
            <a href="?page=scrap_view" class="nav-link">
              <i class="nav-icon fas fa-trash"></i>
              <p>Scrap</p>
            </a>
          </li>
          <li class="nav-header">WAREHOUSE</li>
          <li class="nav-item">
            <a href="?page=wh_view" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Warehouse Order</p>
            </a>
          </li>
          <li class="nav-header">INVENTORY</li>
          <li class="nav-item">
            <a href="?page=inventory_view" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Inventory 360°</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventory_per_item_view" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">ADJUSTMENT</li>
          <li class="nav-item">
            <a href="?page=adjustment_view" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Adjustment Order</p>
            </a>
          </li>
          <li class="nav-header">STOCK OPNAME</li>
          <li class="nav-item">
            <a href="?page=stockop_view" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Stock Opname</p>
            </a>
          </li>
          <li class="nav-header">SYSTEM</li>
          <li class="nav-item">
            <a href="?page=user_view" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>Manage User</p>
            </a>
          </li>
          <li class="nav-header">REPORT</li>
          <li class="nav-item">
            <a href="?page=pemasukan_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Pemasukan per Dokumen Pabean</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=pengeluaran_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-import"></i>
              <p>Pengeluaran per Dokumen Pabean</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventoryperitem_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-lines"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level administrator --> 
<!-- level user exim po -->
      <?php
      if ($data_level == "2") {
      ?>
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="?page=administrator-def" class="nav-link active">
          <i class="nav-icon fas fa-chart-pie fa-spin"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-header">EXIM</li>
      <li class="nav-item">
        <a href="?page=exim_po_view" class="nav-link">
          <i class="nav-icon fas fa-file"></i>
          <p>KEK Document PO</p>
        </a>
      </li>
      <li class="nav-item">
            <a href="?page=exim_so_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document SO</p>
            </a>
          </li>
      <li class="nav-header">PROFILE</li>
      <li class="nav-item">
        <a href="?page=me_manage" class="nav-link">
          <i class="nav-icon fas fa-user"></i>
          <p>Manage My Account</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Sign Out</p>
        </a>
      </li>
      <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
    </ul>
  </nav>
</div>
<?php
      } 
?>
<!-- /.level user exim po --> 
<!-- level user exim so -->
<?php
          if ($data_level == "3") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">EXIM</li>
          <li class="nav-item">
            <a href="?page=exim_po_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>KEK Document PO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=exim_so_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document SO</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user exim so --> 
<!-- level user purchase -->
<?php
          if ($data_level == "4") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">EXIM</li>
          <li class="nav-item">
            <a href="?page=exim_po_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document PO</p>
            </a>
          </li>
          <li class="nav-header">PURCHASE</li>
          <li class="nav-item">
            <a href="?page=po_view" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Purchase Order</p>
            </a>
          </li>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user purchase --> 
<!-- level user sales -->
<?php
          if ($data_level == "5") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">SALES</li>
          <li class="nav-item">
            <a href="?page=so_view" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Sales Order</p>
            </a>
         <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user sales --> 
<!-- level user production -->
<?php
          if ($data_level == "6") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=bom_view" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Bill of Material</p>
            </a>
          </li>
          <li class="nav-header">PRODUCTION</li>
          <li class="nav-item">
            <a href="?page=pro_view" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Production Order</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user production --> 
 <!-- level user production & warehouse-->
<?php
          if ($data_level == "10") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=bom_view" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Bill of Material</p>
            </a>
          </li>
          <li class="nav-header">PRODUCTION</li>
          <li class="nav-item">
            <a href="?page=pro_view" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Production Order</p>
            </a>
          </li>
          <li class="nav-header">WAREHOUSE</li>
          <li class="nav-item">
            <a href="?page=wh_view" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Warehouse Order</p>
            </a>
          </li>
          <li class="nav-header">INVENTORY</li>
          <li class="nav-item">
            <a href="?page=inventory_view" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Inventory 360°</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventory_per_item_view" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user production & warehouse --> 
<!-- level user warehouse -->
<?php
          if ($data_level == "7") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">WAREHOUSE</li>
          <li class="nav-item">
            <a href="?page=wh_view" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Warehouse Order</p>
            </a>
          </li>
          <li class="nav-header">INVENTORY</li>
          <li class="nav-item">
            <a href="?page=inventory_view" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Inventory 360°</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventory_per_item_view" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user warehouse --> 
<!-- level user bea cukai -->
<?php
          if ($data_level == "8") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">INVENTORY</li>
          <li class="nav-item">
            <a href="?page=inventory_view" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Inventory 360°</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventory_per_item_view" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user bea cukai --> 
<!-- level user superadmin -->
<?php
          if ($data_level == "9") {
          ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?page=administrator-def" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie fa-spin"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MASTER DATA</li>
          <li class="nav-item">
            <a href="?page=bp_view" class="nav-link">
              <i class="nav-icon fas fa-address-card"></i>
              <p>Business Partner</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=item_view" class="nav-link">
              <i class="nav-icon fas fa-shapes"></i>
              <p>Item General</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=unit_view" class="nav-link">
              <i class="nav-icon fas fa-monument"></i>
              <p>Unit</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=bom_view" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Bill of Material</p>
            </a>
          </li>
          <li class="nav-header">EXIM</li>
          <li class="nav-item">
            <a href="?page=exim_po_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document PO</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=exim_so_view" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>KEK Document SO</p>
            </a>
          </li>
          <li class="nav-header">PURCHASE</li>
          <li class="nav-item">
            <a href="?page=po_view" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Purchase Order</p>
            </a>
          </li>
          <li class="nav-header">SALES</li>
          <li class="nav-item">
            <a href="?page=so_view" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Sales Order</p>
            </a>
          </li>
          <li class="nav-header">PRODUCTION</li>
          <li class="nav-item">
            <a href="?page=pro_view" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>Production Order</p>
            </a>
          </li>
          <li class="nav-header">SCRAP</li>
          <li class="nav-item">
            <a href="?page=scrap_view" class="nav-link">
              <i class="nav-icon fas fa-trash"></i>
              <p>Scrap</p>
            </a>
          </li>
          <li class="nav-header">WAREHOUSE</li>
          <li class="nav-item">
            <a href="?page=wh_view" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Warehouse Order</p>
            </a>
          </li>
          <li class="nav-header">INVENTORY</li>
          <li class="nav-item">
            <a href="?page=inventory_view" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Inventory 360°</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventory_per_item_view" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">ADJUSTMENT</li>
          <li class="nav-item">
            <a href="?page=adjustment_view" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Adjustment Order</p>
            </a>
          </li>
          <li class="nav-header">STOCK OPNAME</li>
          <li class="nav-item">
            <a href="?page=stockop_view" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <p>Stock Opname</p>
            </a>
          </li>
          <li class="nav-header">REPORT</li>
          <li class="nav-item">
            <a href="?page=pemasukan_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Pemasukan per Dokumen Pabean</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=pengeluaran_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-import"></i>
              <p>Pengeluaran per Dokumen Pabean</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=inventoryperitem_report_view" class="nav-link">
              <i class="nav-icon fas fa-file-lines"></i>
              <p>Inventory per Item</p>
            </a>
          </li>
          <li class="nav-header">PROFILE</li>
          <li class="nav-item">
            <a href="?page=me_manage" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Manage My Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link" onclick="return confirm('Do you really wanna to sign out ?')">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Sign Out</p>
            </a>
          </li>
          <li class="nav-header">OTHER</li>
          <li class="nav-item">
            <a href="?page=about" class="nav-link">
              <i class="nav-icon fas fa-tag"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <?php
          } 
    ?>
<!-- /.level user superadmin --> 
<!-- /.sidebar-menu -->
</aside>