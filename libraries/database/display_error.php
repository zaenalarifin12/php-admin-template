<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Error !!!</title>
<meta name="descrition" content="An Error Occured"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
	font-family: 'Open Sans','Segoe Ui';
	font-size: 1em;
}
.card {
	
}
.border-danger {
	border: 1px solid #ffcbcb;;
}
.danger {
    background: #fbc5c5;
    color: #ef4949;
}
.card-title, .card-content {
	padding: 20px;
}
p {
	margin: 4px 0;
}
</style>
</head>
<body>
<div class="card border-danger">
	<div class="card-title danger">
		<?=$title?>
	</div>
	<div class="card-content">
		<?=$content?>
	</div>
</div>
</body>
</html>