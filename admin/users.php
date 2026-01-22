<?php 
include("header.php");
include ("db.php");
?>

<!-- Mini-extra style to be apply to tables with the dataTable plugin  -->
    <style>
        .dataTable table tr {
            border: solid 1px black;
        }
    table, th, td {
  text-align: center;
}
    </style>



<script>
$(document).ready(function(){
    
    //Apply the datatables plugin to your table
    $('#myTable').DataTable();
    
});
</script>



<div class="col-md-3"></div>
 <div class="col-md-9">
	
	<h3>Users List</h3>
	<hr>
	
		<table class="table table-bordered" id="myTable">
		    <thead>
		        <tr>
    		        <th>Serial Number</th>
    		        <th>Name</th>
					<th>Email</th>
				
				
					<th>City</th>
					
					<th>Action</th>
					<th>Action</th>
				
				
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
					
					<?php
					
					
					$xyz = "select * from users";
					
					$query = mysqli_query($con, $xyz);
					
					$rows=mysqli_num_rows($query);
					$i=0;
					while($row= mysqli_fetch_array($query))
						
					{
						$i++;
						?>
						<td> <?php echo $i; ?> </td>
						<td> <?php echo $row['name']; ?> </td>
					
					<td> <?php echo $row['email']; ?> </td>
			
					
					
					<td> <?php echo $row['city']; ?> </td>
				
					
					<td><a href="edit_users.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a> </td>
				<td>	<a href="delete_users.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a> </td>

						
					
					
				</tr>
				
				<?php } ?>
		    </tbody>
		</table>
	</div>
</div>



