                   <?php
				$me = $myadmin->InfoLogger($_SESSION['comm']);
				 ?>	
<!-- Left side column. contains the logo and sidebar -->
<script type="text/javascript">
function autocomplet() {
	var keyword = $('#entreprise_cl_id').val();
	$.ajax({
		url: 'ajax_refresh.php',
		type: 'POST',
		data: {keyword:keyword},
		success:function(data){
			$('#entreprise_cl_list_id').show();
			$('#entreprise_cl_list_id').html(data);
		}
	});
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#entreprise_cl_id').val(item);
	// hide proposition list
	$('#entreprise_cl_list_id').hide();
}
</script>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="img/<?= $me['avatar'] ?>" class="img-circle" style="max-width: 45px; height: 45px;"alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $me['nom_comm'].' '.$me['pnom_comm'] ?></p>
          <a href="profile.php?comm=<?= $me['id_comm'] ?>"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
	  
	  <form <?php if($page!='home'){ ?> action="recherche.php" <?php } else {?> action="recherche.php" <?php } ?> method="POST" class="sidebar-form">
        <div class="input-group">
          
          <span class="input-group-btn">
		         <input type="text" name="recherche" class="form-control" placeholder="Recherche..." id="entreprise_cl_id" onkeyup="autocomplet()">
				 <ul id="entreprise_cl_list_id"></ul>
				 
                <button type="submit" name="search"  class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPALE</li>
        
		<li class="<?php if($page=='home') { echo 'active'; } ?>">           <!-- mouhem-->
          <a href="home.php">
            <i class="fa fa-dashboard"></i> <span>TABLEAU DE BORD</span>
          </a>
        </li>
		
        
            <li  <?php if($page==2) { echo 'class="active"'; } ?>><a href="total_clients.php"><i class="fa fa-database"></i><span> Liste Total</span></a></li>  
            <li  <?php if($page==1) { echo 'class="active"'; } ?>><a href="mesclients.php"><i class="fa fa-users"></i> <span>Mes Clients </span></a></li>
			<li  <?php if($page==3) { echo 'class="active"'; } ?>><a href="add_clients"><i class="fa fa-user-plus"></i><span> Nouveau</span></a></li>
           <li  <?php if($page==20) { echo 'class="active"'; } ?>><a href="listeouverte.php"><i class="fa fa-users"></i><span> Liste Ouverte</span> </a></li>
        <li  <?php if($page==13) { echo 'class="active"'; } ?>><a href="recherche"><i class="fa fa-search"></i><span> Recherche</span></a></li>
		
        <li <?php if($page==12) { echo 'class="active"'; } ?> >
          <a href="listNoir.php">
            <i class="fa fa-user-times"></i> <span>Liste Noire</span>
          </a>
        </li>  
		
		<li <?php if($page==5) { echo 'class="active"'; } ?> >
          <a href="evennement.php">
            <i class="fa fa-calendar"></i> <span>Mes Evénements</span>
          </a>
        </li>
		
		<li <?php if($page==9) { echo 'class="active"'; } ?> >
          <a href="rappels.php">
            <i class="fa fa-bullhorn"></i> <span>Rappels</span>
          </a>
        </li>
		     <?php
				if($_SESSION['comm'] == 1)
				{
					 ?>
					 <li><a href="clientdeleterequest.php"><i class="fa fa-circle-o"></i> <span>Clients à Supprimer</span></a></li>
					 <?php
				           }
					?>  
		 
		          
				
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
        <?php
        // put your code here
        ?>
