<?php
 include("conn.php");
 if(isset($_POST['insert']))
 {
     $name=$_POST['name'];
     $dob=$_POST['date'];
     $age=$_POST['age'];
     $address=$_POST['address'];
     $state=$_POST['state1'];
     $city=$_POST['city'];

     $sql="INSERT INTO patient_details (`name`,`dob`,`age`,`address`,`state`,`city`) VALUES('$name','$dob',$age,'$address',$state,$city)";
     if(!mysqli_query($con,$sql))
	 {
		echo "NOt Inserted";
	 }
	  else
	 {
		
		header('location:crud.php');
		echo "Inserted";
	 }
 }

?>
<?php
	if(isset($_POST['btnedit']))
	{
		$x=$_POST['edit'];
		$usql = "SELECT * FROM patient_details AS pd JOIN city AS c ON pd.city=c.id JOIN states AS s ON pd.state=s.id WHERE name='$x'";
		$uresult= mysqli_query($con,$usql);
		$urow	=	mysqli_fetch_assoc($uresult);
        
        
	}
		?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>PD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
      $("#state1").on('change',function(){
          var stateId=$(this).val();
         
          $.ajax({
              method:"POST",
              url:"ajax.php",
              data:{id:stateId},
              dataType:"html",
              success:function(data){
                  $("#city").html(data);
                //   alert("Data: " + data);
              }
          });
      });
  });
</script>
</head>

<style>
    .row{
        margin:10px;
    }
 </style>   
<body>
    <div class="container">
        <div class="col-md-12">
          <section style="background-color:#3399ff;">  
           <center><h2>Patient Details</h2></center>
          </section>
            <center><form method="POST">
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="name">Name</lable>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($urow['name'])) { echo $urow['name']; }?>"></input> 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="date">Date</lable>
                </div>
                <div class="col-md-7">
                    <input type="date" class="form-control" name="date" id="date" value="<?php if(isset($urow['dob'])) { echo $urow['dob']; }?>"></input> 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="age">Age</lable>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="age" id="age" value="<?php if(isset($urow['age'])) { echo $urow['age']; }?>"></input> 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="address">Address</lable>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="address" id="address" value="<?php if(isset($urow['address'])) { echo $urow['address']; }?>"></input> 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="state">State</lable>
                </div>
                <div class="col-md-7">
                    <select  class="form-control" name="state1" id="state1" value="<?php if(isset($urow['state_name'])) { echo $urow['state_name']; }?>">
                    <option>Select Any State</option>
                      <?php
                             $query= "SELECT * FROM states";
                             $res= mysqli_query($con,$query);
                             while($row=mysqli_fetch_array($res)){
                               
	 
                     ?>	  	 
	                 <option value="<?php echo $row['id']; ?>"><?php echo $row['state_name'];?></option>
                    <?php	 
                            }
                    ?>
                    </select>                 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                <div class="col-md-5">
                    <lable for="city">City</lable>
                </div>
                <div class="col-md-7">
                    <select  class="form-control" name="city" id="city" value="<?php if(isset($urow['city_name'])) { echo $urow['city_name']; }?>">
                   
                    </select> 
                </div>
            </div>
            <div class="col-md-8 row pt3">
                 <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" name="insert" id="insert">Insert</button>
                </div>
                <div class="col-md-6">
                     <button type="submit" class="btn btn-success" name="update">Update</button> 
                </div>
              
            </div>
            </form></center>
        </div>
    </div>
    <section>
        <div>
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Date of birth</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        $pdata="SELECT * FROM patient_details AS pd JOIN city AS c ON pd.city=c.id JOIN states AS s ON pd.state=s.id";
                        $pres= mysqli_query($con,$pdata);
                        while($prow=mysqli_fetch_array($pres))
                        {
                        ?>
                    <tr>
                       
                        <td><?php echo $prow['name'];?></td>
                        <td><?php echo $prow['dob'];?></td>
                        <td><?php echo $prow['age'];?></td>
                        <td><?php echo $prow['address'];?></td>
                        <td><?php echo $prow['state_name'];?></td>
                        <td><?php echo $prow['city_name'];?></td>
                        <td>
                         <form method="POST">  
                         <input type="hidden" name="edit" value="<?php echo $prow["name"];?>">
                         <input type="submit" class="btn btn-success offset-5" name="btnedit" value="Edit" >
                         <input type="submit" class="btn btn-success offset-5" name="btndelete" value="delete" >
                        </form>
                        </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
<?php
if(isset($_POST['update']))
{
    $name=$_POST['name'];
    $dob=$_POST['date'];
    $age=$_POST['age'];
    $address=$_POST['address'];
    $state=$_POST['state1'];
    $city=$_POST['city'];

    $sql="UPDATE patient_details SET name='$name',dob='$dob',age=$age,address='$address',state=$state,city=$city WHERE name='$name'";
    if(!mysqli_query($con,$sql))
    {
       echo "Not update";
    }
     else
    {
        ?>
        <script>
            window.location="crud.php";
        </script>
        <?php
       echo "update";
    
    }
}

?>
<?php
	if(isset($_POST['btndelete']))
	{
		$a=$_POST['edit'];
        
	
	$query = "DELETE FROM patient_details WHERE name='$a'";

 mysqli_query($con,$query);

?>
        <script>
			window.location="crud.php";
		</script>
		<?php
	}

?>