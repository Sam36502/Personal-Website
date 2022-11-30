<?php

	// Reads all the files in this folder ('cept for this one, duh)
	// And provides a simple download link for all of them.

	$path    = './';
	$files = scandir($path);
	$files = array_diff(scandir($path), array('.', '..'));
	
	// Remove this file ('index.php') & The upload script ('UploadFiles.bat') from the list
	$index = array_search('index.php', $files);
	if($index !== FALSE){
		unset($files[$index]);
	}
	$index = array_search('UploadFiles.bat', $files);
	if($index !== FALSE){
		unset($files[$index]);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../personal/style/main.css" type="text/css">

    <title>Personal Page</title>
</head>
<body>
    <header><a href="../personal/index.html">&lt;--- Back to main page</a></header>
    
    <h1>Filesharing</h1>
    <p>
        Here are files I wanted to share with people but they were
		too big for discord, and I can't be bothered using any
		other service.
    </p>

	<h2>Files:</h2>
	<ul>
		<?php
			foreach ($files as $file) {
				echo '<li><a href="' . $file . '" download rel="noopener noreferrer" target="_blank">' . $file . '</a></li>';
			}
		?>
	</ul>

</body>
</html>