<div id="content">
 <?
    
    $pos = strpos($_GET['mod'], "http");
    if ($pos === false)
        $url = "modulo_fenix.php?mod=".$_GET['mod'];
    else
        $url = $_GET['mod']; 
 ?>   
    
<iframe src ="<?=$url?>" style="overflow-x: hidden; overflow-y: scroll; width:98%;height:98%;	margin: 5px 5px 5px 5px;border:1px solid white;"></iframe>

</div>