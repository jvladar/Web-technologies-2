<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    
    <script> $(document).ready(function() {
    $('#my').DataTable( {
    } );} );
    </script>

</head>
<body>
<table id="my" class ="display">
<thead>
  <tr>
    <th>Nazov</th>
    <th>Velkost</th>
    <th>Datum</th>
  </tr>
</thead>
<tbody>
    <?php
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $dir="files/";
        $dir_path="";
        if($_GET["folder"]){
            $dir = $dir . $_GET["folder"]."/";
            $dir_path = $_GET["folder"]."/";
        }

        $folderik = "http://147.175.98.163/cv1/index.php?";
        $subory = scandir($dir);
        echo "<br/>";

        if($dir_path!="" && $dir_path!="/"){
            $temp = $dir_path;
            $path_parts = pathinfo($temp);
            $temp = substr($temp,0,-strlen($path_parts['filename'])-2);
            echo "<a href=\"{$folderik}folder={$temp}\">"."BACK"."</a> <br/>";}

        foreach($subory as $subor){
            if (!in_array($subor,array("..",".")))
            {
                if(is_dir($dir.$subor)){
                    echo "<tr>";
                    echo "<td><a href=\"{$folderik}folder={$dir_path}{$subor}\">".$subor."</a></td> <br/>";
                    echo '<td></td>';
                    echo '<td></td>';
                    echo "</tr>";
                }else{
                    echo "<tr>";
                    echo '<td>'. $subor.'</td>';
                    echo '<td>'. filesize($dir.$subor). " bytes " .'</td>';
                    echo "<td>" . date("F d Y H:i:s.", filectime($dir.$subor))."</span><br/>";
                    echo "</tr>";
                }
            }
        }
    ?>
</tbody>
</table>
<br>
<form action="upload.php" method="post" id="profileData" enctype="multipart/form-data">
 <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="filename">Filename</label>
                <input name="filename" type="text" id="filename" class="form-control" placeholder="File name">
            </div>
        </div>
    </div>
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</body>
</html>