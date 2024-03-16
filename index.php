<?php
#**********************************************************************************#

				#***************************#
                #********** Tasks **********#
                #***************************#
/*
				[] Welche 10 Lizenzen greifen am häufigsten zu und wie oft?
				[] Lizenzverstöße - Eine Lizenz auf einem Gerät erlaubt?
				[] Welche Lizenz auf welcher Hardware
*/

#**********************************************************************************#

				#**************************#
                #********** ToDo **********#
                #**************************#
/*
				[x] Datei auslesen - Date zu groß und kann nicht ausgelesen werden
				[] Datei Zeilenweise auslesen

*/
#**********************************************************************************#

				#*******************************#
                #********** DEBUGGING **********#
                #*******************************#

				define('DEBUG', 	false);	// Debugging for main document
                define('DEBUG_V', 	false);	// Debugging for values
                define('DEBUG_F', 	false);	// Debugging for functions

#**********************************************************************************#

                // Dateipfad zur Logdatei
                $logDatei = './updatev12-access-pseudonymized.log';

#**********************************************************************************#

				#************************************#
                #********** Datei auslesen **********#
                #************************************#

				// Date zu groß und kann nicht ausgelesen werden
// 				$fileContentArray = file($logDatei);				
// if(DEBUG_V)		echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$arrayName <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)		print_r($array);					
// if(DEBUG_V)		echo "</pre>";



#**********************************************************************************#

?>

<!doctype html>

<html>
	
	<head>	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="./debug.css">		
		<title>Logdatei</title>
	</head>
	
	<body>	
		<h1>Logdatei auslesen</h1>

	</body>
	
</html>