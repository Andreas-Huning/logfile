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
								preg_match('/serial=(\S+)/', $zeile, $matches);// Muster sucht nach dem String und endet beim Leerzeichen
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

				// Funktion zum Zählen der Zeilen in einer Datei
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

 				#**********************************************#
                #********** COUNT SERIAL IN LOG FILE **********#
                #**********************************************#

				// Funktion zum Zählen der Seriennummern
				function countSerial($datei)
				{
if(DEBUG_F)			echo "<p class='debug function'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";

if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$datei: $datei <i>(" . basename(__FILE__) . ")</i></p>\n";
// if(DEBUG_V)			echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$linesTotal: $linesTotal <i>(" . basename(__FILE__) . ")</i></p>\n";
/*
					// Seriennummern auslesen - Zu viele Schleifen da bei jedem Aufruf der ReadDatafromFile erneut bei 1 angefangen wird zu zählen
					for($aktuelleZeile = 1;$aktuelleZeile <= 1000; $aktuelleZeile++)
					{
if(DEBUG_V)				echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$aktuelleZeile: $aktuelleZeile <i>(" . basename(__FILE__) . ")</i></p>\n";

						$serial = readDatafromFile($datei, $aktuelleZeile);
if(DEBUG_V)				echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serial: $serial <i>(" . basename(__FILE__) . ")</i></p>\n";

					}// Seriennummern auslesen END
*/
					// Datei im Lesemodus öffnen
					$handle = fopen($datei, "r");

					// Prüfen ob Datei geöffnet werden konnte
					if ($handle) 
					{
if(DEBUG)	            echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Datei konnte geöffnet werden. <i>(" . basename(__FILE__) . ")</i></p>\n";				

						// Zähler für alle Zeilen
						$zeilenZaehler=1;

						// Jede Zeile lesen bis das Ende der Datei erreicht wird
						while(($zeile = fgets($handle)) !== false)
						{
							// Den Abschnitt mit der Seriennumer suchen
							preg_match('/serial=(\S+)/', $zeile, $matches);// Muster sucht nach dem String und endet beim Leerzeichen

							// Überprüfen ob eine Seriennummer vorhanden ist
							if (isset($matches[1])) 
							{
								$serial = $matches[1]; // Serial extrahieren
// if(DEBUG_V)						echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serial: $serial <i>(" . basename(__FILE__) . ")</i></p>\n";
							
								// Seriennummer zählen
								if (isset($serialCounts[$serial])) 
								{
// if(DEBUG)							echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Seriennummer bereits im Array, hochzählen <i>(" . basename(__FILE__) . ")</i></p>\n";				

									$serialCounts[$serial]++;
								} else {
// if(DEBUG)							echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Seriennummer noch nicht im Array, wird mit 1 initialisiert <i>(" . basename(__FILE__) . ")</i></p>\n";				

									$serialCounts[$serial] = 1;

								}// Seriennummer zählen END

							}// Überprüfen ob eine Seriennummer vorhanden ist END

							// Zähle die Zeilen
							$zeilenZaehler++;
							
						}// Jede Zeile lesen bis das Ende der Datei erreicht wird END

						// Datei schließen
						fclose($handle);
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: LogDatei geschlossen <i>(" . basename(__FILE__) . ")</i></p>\n";				

						// Array in absteigender Reihenfolge sortieren
						arsort($serialCounts);

						$daten['linesTotal'] = $zeilenZaehler;
						$daten['serialNumbers'] = $serialCounts;
/*
if(DEBUG_V)	            echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$daten <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	            print_r($daten);					
if(DEBUG_V)	            echo "</pre>"; 
*/
						// Array zurückgeben für Ausgabe auf der Seite
						return $daten; 

					} else {
if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Die Datei konnte nicht geöffnet werden. <i>(" . basename(__FILE__) . ")</i></p>\n";				
					
					} // Prüfen ob Datei geöffnet werden konnte END 

				}// Funktion zum Zählen der Seriennummern END


#**********************************************************************************#


                #******************************************#
                #********** CALLING THE FUNCTION **********#
                #******************************************#

				// Eine Zeile auslesen
				// $serial = readDatafromFile($logDatei, $zeilenNummer);
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serial: $serial <i>(" . basename(__FILE__) . ")</i></p>\n";


				// Datensätze zählen
				// $linesTotal = countLines($logDatei);
// if(DEBUG_V)		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$linesTotal: $linesTotal <i>(" . basename(__FILE__) . ")</i></p>\n";

				// Zählen der häufigsten Seriennummer
				$serialCounts = countSerial($logDatei);

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
        <h2>Anzahl Datensätze / Zeilen: <?php echo $serialCounts['linesTotal']; ?></h2>

        <h2>Die ersten 10 Seriennummern:</h2>
        <?php
            // Array der Seriennummern ausgeben
            $counter = 0;
            foreach ($serialCounts['serialNumbers'] as $serial => $count) {
                echo "<p>Seriennummer: $serial, Anzahl: $count</p>";
                $counter++;
                if ($counter >= 10) {
                    break; // Schleife abbrechen, wenn 10 Seriennummern ausgegeben wurden
                }
            }
        ?>
	</body>
	
</html>