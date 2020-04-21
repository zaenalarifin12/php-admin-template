<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Error !!!</title>
<meta name="descrition" content="An error occured"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="public/images/favicon.png" />
<style>
body {
	font-family: 'Open Sans','Segoe Ui';
	font-size: 1em;
}
.card {
	margin-bottom: 20px;
}
.border-danger {
	border: 1px solid #ffcbcb;;
}
.danger {
    background: #fbc5c5;
    color: #ef4949;
}

.border-warning {
	border: 1px solid #ffe0a7;
}
.warning {
	background: #ffe0a7;
    color: #ffa500;
}
.card-title, .card-content {
	padding: 20px;
}
.card-content {
	background: #FFFFFF;
	color: #000000;
}
p {
	margin: 4px 0;
}
</style>
</head>
<body>

<div class="card border-danger">
	<div class="card-title danger">
		ERROR !!!
	</div>
	<div class="card-content">
		<?=$content?>
	</div>
</div>
</body>
</html>