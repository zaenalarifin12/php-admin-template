<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Error !!!</title>
<meta name="descrition" content="An Error Occured"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
html, body {
	height: 100%;
	margin: 0;
	padding: 0;
	background-color: rgb(198, 219, 241);
}
body {
	font-family: 'Open Sans','Segoe Ui', 'Arial';
	font-size: 26px;
	color: #3a526c;
}

.error-container{
	display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 100%;
    height: 100%;
    text-align: center;
    margin: 0;
    min-height: 200px;
    align-items: center;
}
.error-container h1{
	margin: 0 0 10px 0;
}
@media screen and (max-width: 550px) {
	body {
		font-size: 16px;
		padding: 25px;
	}
	
}

@media screen and (min-width: 550px) and (max-width: 860px) {
	body {
		font-size: 20px;
		padding: 20px;
	}
	
}
</style>
</head>
<body>
<div class="error-container">
	<h1>Program Error...</h1>
	<div>Maaf, terjadi error pada program kami, mohon menghubungi admin</div>
</div>
</body>
</html>