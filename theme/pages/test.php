<?php 
$checkbox1 = $_POST['liste'] ;  

if ($_POST["listouvme1" ]=="listouvme1")  
{  

for ($i=0; $i<sizeof ($checkbox1);$i++) 
{  

echo "<script>alert(\"la variable est nulle\")</script>";
  
}
}

header("Location: https://www.facebook.com/"); 
exit();
?>
