<?php include 'db.php';



if(isset($_POST['edit'])){
$q = mysqli_query($con,"SELECT * FROM student WHERE id = '{$_POST['id']}'");
$row = mysqli_fetch_array($q);
header("Content-type: text/x-json");
echo json_encode($row);
exit();

}

if(isset($_POST['delete'])){
	$id = $_POST['id'];
	$studentname = $_POST['studentname'];
	$gender = $_POST['gender'];
	$phone = $_POST['phone'];

	$insert = "DELETE FROM student WHERE id = $id ";
	$run_insert = mysqli_query($con,$insert);

	exit();

}


if(isset($_POST['saverecord'])){
	$studentname = $_POST['studentname'];
	$gender = $_POST['gender'];
	$phone = $_POST['phone'];
	


 $insert = "INSERT into student (student_name,gender,phone) VALUES ('$studentname','$gender','$phone')";
	$run_insert = mysqli_query($con,$insert);

	exit();

}

if(isset($_POST['update'])){
	$id = $_POST['id'];
	$studentname = $_POST['studentname'];
	$gender = $_POST['gender'];
	$phone = $_POST['phone'];


 $update = "UPDATE `student`  SET `student_name` = '$studentname',`gender` = '$gender', `phone`= '$phone' WHERE id = $id ";
	mysqli_query($con,$update);
echo 0;
	exit();

}

if(isset($_POST['show'])){
$select = "SELECT * FROM student ORDER BY student_name ASC ";
$run = mysqli_query($con,$select);
while($row = mysqli_fetch_array($run)){

$id = $row['id'];
	?>

   <tr>
   <td> <?php echo $row['id']; ?></td>
   	<td> <?php echo $row['student_name']; ?></td>
   	<td> <?php echo $row['gender']; ?></td>
   	<td> <?php echo $row['phone']; ?></td>
   	<td><a href="#" class="edit" data-id="<?php echo $row['id']; ?>">   Edit</a> | <a href="#" data-id="<?php echo $row['id']; ?> " class="delete"> Delete</a></td>
   </tr>

<?php
}
exit();
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ajax insert update delete</title>


</head>
<body>
	<table>
	<input type="hidden" id="id" value="">
		<tr>
			<td>Student Name</td>
			<td>:</td>
			<td><input type="text" name="studentname" id="studentname"> </td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>:</td>
			<td> <select name="gender" id="gender">
					<option >select</option>
				<option value="male">Male</option>
				<option value="female">female</option>
				
			</select> </td>
		</tr>
		<tr>
			<td>Phone</td>
			<td>:</td>
			<td><input type="tel" name="phone" id="phone"> </td>
		</tr>

		<tr>
		<td colspan="3">

		<input type="button" name="save" id="save" value="Save">
		<input type="button" name="update" id="update" value="Update">
		</td></tr>

		<table>
			<thead>
				<tr>
					<th>Id</th>
					<th>Student Name</th>
					<th>Gender</th>
					<th>Phone</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="showdata">
				
			</tbody>
		</table>
	
</table>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
		$(function(){

				// delete
				$('body').delegate('.delete','click',function(){
				var id = $(this).data('id');
				$.ajax({
					url : 'index.php',
					type:  'POST',
					async: false,
					data : {
						'delete'  : 1,
						'id'	: id,
					},
					success: function(d){
						alert("Delete successfully");
								showdata();
					}


			});

				});

				// end



			// edit

			$('body').delegate('.edit','click',function(){
				var id = $(this).data('id');
					$.ajax({
					url : 'index.php',
					type:  'POST',
					async: false,
					data : {
						'edit'  : 1,
						'id'	: id,
					},
					success: function(e){
						$('#id').val(e.id);
						$('#studentname').val(e.student_name);
						$('#gender').val(e.gender);
						$('#phone').val(e.phone);
					}


			});

			})

			// edit end

			showdata();
			// save data
			$('#save').click(function(){
				var studentname = $('#studentname').val();
				var gender = $('#gender').val();
				var phone = $('#phone').val();
				$.ajax({
					url : 'index.php',
					type:'POST',
					async: false,
					data : {
						'saverecord'  : 1,
						'studentname' : studentname,
						'gender'      : gender,
						'phone'       : phone
					},
					success: function(re){
						if(re ==0){
							alert("insert data success");
							$('#studentname').val("");
							$('#gender').val("");
							$('#phone').val("");
							showdata();
						}
					}

				});

			});
			// end save data

// update
$('#update').click(function(){
				var id = $('#id').val();
				var studentname = $('#studentname').val();
				var gender = $('#gender').val();
				var phone = $('#phone').val();
			$.ajax({
					url : 'index.php',
					type:'POST',
					async: false,
					data : {
						'update'      : 1,
						'id'		  : id,
						'studentname' : studentname,
						'gender'      : gender,
						'phone'       : phone
					},
					success: function(u){
						if(u == 0){
							alert("successfully");
							$('#studentname').val("");
							$('#gender').val("");
							$('#phone').val("");
							showdata();
						}
					}

				});

})
// end update


		});


function showdata(){

	$.ajax({
					url : 'index.php',
					type:'POST',
					async: false,
					data : {
						'show'  : 1,
						
					},
					success: function(data){
						$('#showdata').html(data);
					}

				});

}



$(document).ready(function(){


})

	</script>
</body>

</html>

