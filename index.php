<?php 
session_start();
require("config.inc.php");
require("includes/funciones.php");
include('lib/adodb/adodb.inc.php'); # load code common to ADOdb
include("includes/top_page.php"); 
?>
<div class="container-fluid fondo02">		
    <header class="">    	
	<?php include("includes/header.php"); ?>        
    </header>     
    <nav class="navbar navbar-default navbar-static-top" role="navigation">	
        <?php include("includes/menu.php"); ?>
    </nav>		    
    <section class="container-fluid fondo">
        <?php include("includes/pages.php"); ?>         
    </section>		
    <footer class="container">   	   
        <?php include("includes/footer.php"); ?>        
    </footer>        
</div>
<?php include("includes/bottom_page.php"); ?>