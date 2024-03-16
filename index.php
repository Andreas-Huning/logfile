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
				[x] Datei Zeilenweise auslesen
				[x] Anzahl der Datenreihen zählen
				[] Funktion zum Zählen der Seriennumern


*/
#**********************************************************************************#

				#*******************************#
                #********** DEBUGGING **********#
                #*******************************#

				define('DEBUG', 	true);	// Debugging for main document
                define('DEBUG_V', 	true);	// Debugging for values
                define('DEBUG_F', 	true);	// Debugging for functions

#**********************************************************************************#

				#***************************************#
                #********** Pfad zur Logdatei **********#
                #***************************************#

                $logDatei = './updatev12-access-pseudonymized.log';

#**********************************************************************************#

				#*******************************#
                #********** Variablen **********#
                #*******************************#

				$zeilenNummer = 1;

#**********************************************************************************#

				#************************************#
                #********** Datei auslesen **********#
                #************************************#

				// Datei zu groß und kann nicht ausgelesen werden
// 				$fileContentArray = file($logDatei);				
// if(DEBUG_V)		echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$arrayName <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
// if(DEBUG_V)		print_r($array);					
// if(DEBUG_V)		echo "</pre>";


#**********************************************************************************#

				#*****************************************#
                #********** READ DATA FROM FILE **********#
                #*****************************************#

				// Eine Zeile der Datei auslesen
				function readDatafromFile($datei,$zeilenNummer)
				{
if(DEBUG_F)			echo "<p class='debug function'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";

					// Datei im Lesemodus öffnen
					$handle = fopen($datei, "r");

					// Prüfen ob Datei geöffnet werden konnte
					if ($handle)
					{
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: LogDatei erfolgreich geöffnet <i>(" . basename(__FILE__) . ")</i></p>\n";				

						$aktuelleZeile = 1;

						// Jede Zeile lesen bis das Ende der Datei erreicht wird
						while(($zeile = fgets($handle)) !== false)
						{
							// Zeile gefunden 
							if($aktuelleZeile === $zeilenNummer)
							{
if(DEBUG)						echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Gesuchte Zeile wurde gefunden <i>(" . basename(__FILE__) . ")</i></p>\n";				

if(DEBUG_V)						echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$zeile: $zeile <i>(" . basename(__FILE__) . ")</i></p>\n";
								
								// Den Abschnitt mit der Seriennumer suchen
								preg_match('/serial=(\S+)/', $zeile, $matches);
								$serial = $matches[1]; // Serial extrahieren
if(DEBUG_V)						echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serial: $serial <i>(" . basename(__FILE__) . ")</i></p>\n";


								// Datei schließen
								fclose($handle);
if(DEBUG)						echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: LogDatei geschlossen <i>(" . basename(__FILE__) . ")</i></p>\n";				
								return $serial;

							}// Zeile gefunden END

								// Zeile hochzählen
								$aktuelleZeile++;
if(DEBUG)						echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Zeile in der Logdatei: \$aktuelleZeile: $aktuelleZeile   <i>(" . basename(__FILE__) . ")</i></p>\n";

						}// Jede Zeile lesen bis das Ende der Datei erreicht wird END


					}else
					{
if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: LogDatei konnte nicht geöffnet werden <i>(" . basename(__FILE__) . ")</i></p>\n";				

					}// Prüfen ob Datei geöffnet werden konnte END


				}// Eine Zeile der Datei auslesen END



#**********************************************************************************#

 				#*********************************************#
                #********** COUNT LINES IN LOG FILE **********#
                #*********************************************#

				// Funktion zum Zählen der Zeilen in der Datei
				function countLines($datei)
				{
if(DEBUG_F)			echo "<p class='debug function'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";

					// Zähler für alle Zeilen
					$zeilenZaehler=0;

					// Datei im Lesemodus öffnen
					$handle = fopen($datei, "r");

					// Prüfen ob Datei geöffnet werden konnte
					if ($handle) 
					{
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: LogDatei erfolgreich geöffnet <i>(" . basename(__FILE__) . ")</i></p>\n";				

						//feof — Prüft, ob ein Dateizeiger am Ende der Datei steht
						while (!feof($handle)) {
							
							//fgets — Liest die Zeile von der Position des Dateizeigers
							fgets($handle);

							// Zähle die Zeilen
							$zeilenZaehler++;
						}
						// Datei schließen
						fclose($handle);
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: LogDatei geschlossen <i>(" . basename(__FILE__) . ")</i></p>\n";				

if(DEBUG_V)				echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$zeilenZaehler: $zeilenZaehler <i>(" . basename(__FILE__) . ")</i></p>\n";

						// Anzahl der Zeilen zurückgeben
						return $zeilenZaehler;

					} else {
if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Die Datei konnte nicht geöffnet werden. <i>(" . basename(__FILE__) . ")</i></p>\n";				
					
					}// Prüfen ob Datei geöffnet werden konnte END

				}// Funktion zum Zählen der Zeilen in einer Datei END

#**********************************************************************************#


                #******************************************#
                #********** CALLING THE FUNCTION **********#
                #******************************************#

				// Eine Zeile auslesen
				$serail = readDatafromFile($logDatei, $zeilenNummer);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serail: $serail <i>(" . basename(__FILE__) . ")</i></p>\n";


				// Datensätze zählen
				$linesTotal = countLines($logDatei);
if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$linesTotal: $linesTotal <i>(" . basename(__FILE__) . ")</i></p>\n";


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