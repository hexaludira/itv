
<?php

include "inc/koneksi.php";

?>
<!-- /template header -->
<?php include 'itv/itv_template_header.php' ?>
<!-- /template header -->  

<!-- main content -->
<div>
<?php
            if (isset($_GET['page']) == 'itv_index') {
                include "itv/default/itv_administrator.php";
                }
                
              elseif (isset($_GET['page']) <> 'itv_index') {   
                echo "<center><h1> ERROR !</h1></center>";
                }
          
?>
</div>
<!-- /main content -->  



