<?php  
 $connect = mysqli_connect("localhost", "root", "1234", "concredito");  
 if(isset($_POST["query"]))  
 {  
      $output = '';  
      $query = "SELECT * FROM clientes WHERE nombre LIKE '%".$_POST["query"]."%'";  
      $result = mysqli_query($connect, $query);  
      $output = '<ul class="list-unstyled">';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                  
				$output .= '<li>'.$row["clave_cliente"]." -".$row["nombre"]." ".$row["apellido_pat"]." " .$row["apellido_mat"].'</li>';  
           }  
      }  
      else  
      {  
           $output .= '<li>no esta</li>';  
      }  
      $output .= '</ul>';  
      echo $output;  
 }  
 ?>  