<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.15/datatables.min.css"/>

	</head>
	<body>
		<div style="width:80%; margin: 0 auto">
		<table id="tblData">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
			</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.15/datatables.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#tblData').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "./data.php",
				"columnDefs": [
					{ className: "dt-body-right", "targets": [ 2 ] }
				]
			});
		});
	</script>
	</body>
</html>