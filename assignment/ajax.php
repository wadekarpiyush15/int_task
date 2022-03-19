<?php

    include("conn.php");
    if(isset($_POST['id'])){
       
        $id=$_POST['id'];

        $query="SELECT * FROM city WHERE state_id='$id'";
        $res= mysqli_query($con,$query);
        while($row=mysqli_fetch_array($res))
        {
            $id=$row['id'];
            $city=$row['city_name'];
            echo "<option value='$id'> $city</option>";
        }
    }