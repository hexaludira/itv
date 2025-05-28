<?php
session_start();
header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: *");
if (isset($_SESSION['ses_nama']) == "") {
  header("location: login.php");
} else {
  $data_id = $_SESSION["ses_id"];
  $data_email = $_SESSION["ses_username"];
  $data_nama = $_SESSION["ses_nama"];
  $data_menu_wms = $_SESSION["ses_menuwms"];
  $data_menu_mesc = $_SESSION["ses_menumesc"];
  $data_menu_mesf = $_SESSION["ses_menumesf"];
  $data_menu_lapormas = $_SESSION["ses_menulapormas"];
  $data_menu_itinventory = $_SESSION["ses_menuitinventory"];
  $data_menu_hris = $_SESSION["ses_menuhris"];
  $data_menu_it = $_SESSION["ses_menuit"];
  $data_menu_ga = $_SESSION["ses_menuga"];
  $data_level = $_SESSION["ses_level"];
  $data_level_lm = $_SESSION["ses_level_lm"];
}
include "inc/koneksi.php";
?>


<!-- /template header -->
<?php include 'template_header.php' ?>
<!-- /template header -->  


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  
    <!-- Main content -->
    <?php
            if (isset($_GET['page'])) {
              $hal = $_GET['page'];

              switch ($hal) {
                case 'administrator-def':
                  include "sash/default/administrator.php";
                break;

              //Stock Opname
              case 'stockop_view':
                include "sash/administrator/stockop/stockop_view.php";
              break;

              //Stock Opname Detail
              case 'stockop_detail_view':
                include "sash/administrator/stockop/stockop_detail_view.php";
              break;

              //Scrap
              case 'scrap_view':
                include "sash/administrator/scrap/scrap_view.php";
              break;

              //Scrap Detail
              case 'scrap_detail_view':
                include "sash/administrator/scrap/scrap_detail_view.php";
              break;

              //Adjustment Order
              case 'adjustment_view':
                include "sash/administrator/adjustment/adj_view.php";
              break;

              //Adjustment Order Detail
              case 'adjustment_detail_view':
                include "sash/administrator/adjustment/adj_detail_view.php";
              break;

              //Business Partner
              case 'bp_view':
              include "sash/administrator/business_partner/bp_view.php";
              break;

              //Item General
              case 'item_view':
              include "sash/administrator/item_general/item_view.php";
              break;

              //Unit
              case 'unit_view':
              include "sash/administrator/unit/unit_view.php";
              break;

              //BOM
              case 'bom_view':
              include "sash/administrator/bom/bom_view.php";
              break;

              //BOM Blocked
              case 'bom_blocked_view':
              include "sash/administrator/bom/bom_blocked_view.php";
              break;

              //BOM Detail
              case 'bom_detail_view':
              include "sash/administrator/bom/bom_detail_view.php";
              break;

              //BOM Detail Blocked
              case 'bom_detail_blocked_view':
              include "sash/administrator/bom/bom_detail_blocked_view.php";
              break;

              //BOM Detail Blocked 2
              case 'bom_detail_blocked_view2':
              include "sash/administrator/bom/bom_detail_blocked_view2.php";
              break;

              //Purchase Order
              case 'po_view':
              include "sash/administrator/po/po_view.php";
              break;

              //Purchase Order Detail
              case 'po_detail_view':
              include "sash/administrator/po/po_detail_view.php";
              break;

              //Purchase Order Detail Blocked
              case 'po_detail_blocked_view':
              include "sash/administrator/po/po_detail_blocked_view.php";
              break;

              //KEK Document PO
              case 'exim_po_view':
              include "sash/administrator/exim/exim_po_view.php";
              break;

              //KEK Document PO Detail Blocked
              case 'exim_po_detail_blocked_view':
              include "sash/administrator/exim/exim_po_detail_blocked_view.php";
              break;

              //KEK Document SO
              case 'exim_so_view':
              include "sash/administrator/exim/exim_so_view.php";
              break;

              //KEK Document SO Detail Blocked
              case 'exim_so_detail_blocked_view':
              include "sash/administrator/exim/exim_so_detail_blocked_view.php";
              break;
              
              //Sales Order
              case 'so_view':
              include "sash/administrator/so/so_view.php";
              break;
  
              //Sales Order Detail
              case 'so_detail_view':
              include "sash/administrator/so/so_detail_view.php";
              break;
  
              //Sales Order Detail Blocked
              case 'so_detail_blocked_view':
              include "sash/administrator/so/so_detail_blocked_view.php";
              break;

              //Warehouse Order
              case 'wh_view':
              include "sash/administrator/warehouse/wh_order_view.php";
              break;

              //Warehouse Receive
              case 'wh_receive_view':
              include "sash/administrator/warehouse/wh_receive_view.php";
              break;

              //Warehouse Receive Pro
              case 'wh_receive_pro_view':
              include "sash/administrator/warehouse/wh_receive_pro_view.php";
              break;

              //Warehouse Deliver
              case 'wh_deliver_view':
              include "sash/administrator/warehouse/wh_deliver_view.php";
              break;

              //Warehouse Deliver Pro
              case 'wh_deliver_pro_view':
              include "sash/administrator/warehouse/wh_deliver_pro_view.php";
              break;

              //Inventory 360
              case 'inventory_view':
              include "sash/administrator/inventory/inventory_view.php";
              break;

              //Inventory per Item
              case 'inventory_per_item_view':
              include "sash/administrator/inventory/inventory_per_item_view.php";
              break;

              //Inventory per Item Detail
              case 'inventory_per_item_detail_view':
              include "sash/administrator/inventory/inventory_per_item_detail_view.php";
              break;

              //Production Order
              case 'pro_view':
              include "sash/administrator/pro/pro_view.php";
              break;

              //Production Order - Raw Material
              case 'pro_rm_view':
              include "sash/administrator/pro/pro_rm_view.php";
              break;

              //Production Order - Raw Material Blocked
              case 'pro_rm_blocked_view':
                include "sash/administrator/pro/pro_rm_blocked_view.php";
                break;

              //Production Order - Raw Material Usage
              case 'pro_rm_usage_view':
                include "sash/administrator/pro/pro_rm_usage_view.php";
                break;

              //Manage User
                case 'user_view':
                  include "sash/administrator/user/user_view.php";
                break;

              //REPORT
              case 'pemasukan_report_view':
                include "sash/administrator/report/pemasukan_report_view.php";
              break;
              case 'pengeluaran_report_view':
                include "sash/administrator/report/pengeluaran_report_view.php";
              break;
              case 'inventoryperitem_report_view':
                include "sash/administrator/report/inventoryperitem_report_view.php";
              break;

              //Manage My Account
                case 'me_manage':
                  include "sash/me.php";
                break;
                  
              //Sign Out
                case 'signout':
                  include "logout.php";
                break;

              //About
              case 'about':
                include "sash/administrator/about.php";
              break;
              //-------------/SASH------------- 

              }
            } else {
              if ($data_level == "1") {
                include "sash/default/administrator.php";
              } elseif ($data_level <> "1") {
                include "sash/default/user.php";
              }
            }
    ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- template footer -->
<?php include 'template_footer.php' ?>
<!-- /template footer -->
  
