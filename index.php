<?php
#**********************************************************************************#

				#*******************************#
                #********** BENCHMARK **********#
                #*******************************#

				//TimeStamp für Benchmark setzen I
				$starttime =  microtime(true);

#**********************************************************************************#

				#***************************#
                #********** Tasks **********#
                #***************************#
/*
				[x] Welche 10 Lizenzen greifen am häufigsten zu und wie oft?
				[x] Lizenzverstöße - Eine Lizenz auf einem Gerät erlaubt?
				[x] Welche Lizenz auf welcher Hardware
*/

#**********************************************************************************#

				#**************************#
                #********** ToDo **********#
                #**************************#
/*
				[x] Datei auslesen - Datei zu groß und kann nicht ausgelesen werden
				[x] Datei Zeilenweise auslesen
				[x] Anzahl der Datenreihen zählen
				[x] Funktion zum Zählen der Seriennumern
				[x] Funktion zum analysieren von Lizenzverstöße
				[x] Laufzeit zu lange beim Einlesen / wird Blockweise eingelesen
				[] Fehlermeldung: Warning: gzdecode(): data error in C:\xampp\htdocs\index.php on line 320 / Kommt ca 10 mal insgesamt
				[x] Bearbeiten von 919000 Zeilen ca. 5 Minuten  

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

                #**********************************************#
                #********** COUNT LICENSE VIOLATIONS **********#
                #**********************************************#

                // Funktion zum Zählen der Verstöße gegen die Regel für jede Seriennummer
                function zaehleVerstoesse($datei,$blockSize = 50) 
				{
if(DEBUG_F)		    echo "<p class='debug function'>🌀 <b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\n";
					
					$verstoesse = []; // Array zum Speichern der Verstöße
					$macAdressen = []; // Array zum Speichern der MAC-Adressen
					$zeilenZaehler = 1;	// Zähler für alle Zeilen
											
					
if(DEBUG_V)	        echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$datei: $datei <i>(" . basename(__FILE__) . ")</i></p>\n";

					// Datei im Lesemodus öffnen
					$handle = fopen($datei, "r");

					// Prüfen ob Datei geöffnet werden konnte
					if ($handle) 
					{
if(DEBUG)	            echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Die Datei konnte geöffnet werden. <i>(" . basename(__FILE__) . ")</i></p>\n";				

						$lineCounter = 0;
						// Solange nicht das Ende der Datei erreicht wurde
						while (!feof($handle)) 
						{
							$lines = [];
							// Lese den nächsten Block an Zeilen und in array speichern
							for ($i = 0; $i < $blockSize && ($zeile = fgets($handle)) !== false; $i++) {
								$lines[] = $zeile;
								$lineCounter++;
							}
if(DEBUG_V)	                echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$lineCounter: $lineCounter <i>(" . basename(__FILE__) . ")</i></p>\n";

							// Verarbeite die Zeilen des Blocks aus dem Array
							foreach ($lines as $zeile) 
							{	
								// Den Abschnitt mit der Seriennumer suchen
								preg_match('/serial=(\S+)/', $zeile, $matcheSerial);// Muster sucht nach dem String und endet beim Leerzeichen

								// Überprüfen ob eine Seriennummer vorhanden ist
								if (isset($matcheSerial[1])) 
								{
									$serial = $matcheSerial[1]; // Serial extrahieren
// if(DEBUG_V)							echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$serial: $serial <i>(" . basename(__FILE__) . ")</i></p>\n";
							
									// Seriennummer zählen
									if (isset($serialCounts[$serial])) 
									{
// if(DEBUG)								echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Seriennummer bereits im Array, hochzählen <i>(" . basename(__FILE__) . ")</i></p>\n";				

										$serialCounts[$serial]++;
									} else {
// if(DEBUG)								echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: Seriennummer noch nicht im Array, wird mit 1 initialisiert <i>(" . basename(__FILE__) . ")</i></p>\n";				

										$serialCounts[$serial] = 1;

									}// Seriennummer zählen END

								}// Überprüfen ob eine Seriennummer vorhanden ist END

								// Finde den Index des specs-Felds
								$specsIndex = strpos($zeile, 'specs=');

								// Prüfen ob Spec vorhanden ist
								if($specsIndex !== false)
								{
// if(DEBUG)	                    	echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: String specs= gefunden <i>(" . basename(__FILE__) . ")</i></p>\n";				

									// Herausziehen des specs-Felds
									$specs = substr($zeile, $specsIndex);
									$specs = substr($specs, strpos($specs, '=') + 1);

// if(DEBUG_V)	                    	echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$specs: $specs <i>(" . basename(__FILE__) . ")</i></p>\n";

									// Dekodiere die specs
									if($specs !== NULL){
// if(DEBUG)	                    		echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Dekodieren der Spec <i>(" . basename(__FILE__) . ")</i></p>\n";				

										$specsDecoded = json_decode(gzdecode(base64_decode($specs)), true);
									}else{
if(DEBUG)	                    		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Dekodieren der Spec fehlgeschlagen <i>(" . basename(__FILE__) . ")</i></p>\n";				

										$specsDecoded = null;

									}// Dekodiere die specs END
								
								} else {
// if(DEBUG)	                    	echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: String specs= nicht gefunden <i>(" . basename(__FILE__) . ")</i></p>\n";				
									$specsDecoded = null;
								
								}// Prüfen ob Spec vorhanden ist END
/*
if(DEBUG_V)	                    	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$specsDecoded <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	                    	print_r($specsDecoded);					
if(DEBUG_V)	                    	echo "</pre>"; 				
*/
									// Mac-Adresse und Seriennummer prüfen 
									if ($specsDecoded !== null)
									{
										$mac = $specsDecoded['mac'];
// if(DEBUG_V)	                    		echo "<p class='debug value'><b>Line " . __LINE__ . "</b>: \$mac: $mac <i>(" . basename(__FILE__) . ")</i></p>\n";
														
										// Überprüfe, ob die MAC-Adresse bereits im Array vorhanden ist
										if (!in_array($mac, $macAdressen)) 
										{
// if(DEBUG)	                        		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: MAC Adresse ist noch nicht vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\n";
                                    		$macAdressen[] = $mac; // Füge die MAC-Adresse dem Array hinzu

											// Prüfen, ob die Seriennummer bereits im Array (Verstöße) vorhanden ist
                                        	if (isset($verstoesse[$serial])) 
											{
// if(DEBUG)	                            		echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Die Seriennummer ist bereits im Array (Verstöße) vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\n";
											
												// Wenn ja, erhöhe den Verstoßzähler um eins
												$verstoesse[$serial]++;
											} else {
// if(DEBUG)	                            		echo "<p class='debug'><b>Line " . __LINE__ . "</b>: Die Seriennummer ist nicht im Array (Verstöße) vorhanden. <i>(" . basename(__FILE__) . ")</i></p>\n";
											
												// Wenn nicht, setze den Verstoßzähler auf eins
												$verstoesse[$serial] = 1;
											}// Prüfen, ob die Seriennummer bereits im Array (Verstöße) vorhanden ist END

										}// Überprüfe, ob die MAC-Adresse bereits im Array vorhanden ist END
										
										// CPU in Array speichern
										$cpu = $specsDecoded['cpu'];
										if (!isset($cpuSeriennummern[$cpu])) 
										{
											// $cpuSeriennummern[$cpu] = [];
											$cpuSeriennummern[$cpu] = 1;
										}
										// $cpuSeriennummern[$cpu][]=$serial;
										$cpuSeriennummern[$cpu]++;


										
									}// Mac-Adresse und Seriennummer prüfen END

								// Zähle die Zeilen
								$zeilenZaehler++;

							}// Verarbeite die Zeilen des Blocks aus dem Array

						}// Solange nicht das Ende der Datei erreicht wurde END

						// Datei schließen
						fclose($handle);
if(DEBUG)				echo "<p class='debug hint'><b>Line " . __LINE__ . "</b>: LogDatei geschlossen <i>(" . basename(__FILE__) . ")</i></p>\n";				

	                    // Array in absteigender Reihenfolge sortieren
						arsort($verstoesse);
						arsort($serialCounts);

						$daten['linesTotal'] 	= $zeilenZaehler;
						$daten['serialNumbers'] = $serialCounts;
						$daten['verstoesse'] 	= $verstoesse;
						$daten['cpu'] 			= $cpuSeriennummern;
						// $daten['spec'] 			= $specsDecoded;
/*
if(DEBUG_V)	            echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$daten <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	            print_r($daten);					
if(DEBUG_V)	            echo "</pre>"; 		
*/
						return $daten;			


					} else {
if(DEBUG)	            echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: Die Datei konnte nicht geöffnet werden. <i>(" . basename(__FILE__) . ")</i></p>\n";				
										
										
					} // Prüfen ob Datei geöffnet werden konnte END 


				}// Funktion zum Zählen der Verstöße gegen die Regel für jede Seriennummer END


#**********************************************************************************#

                #******************************************#
                #********** CALLING THE FUNCTION **********#
                #******************************************#

				// Zählen der Lizenzverstöße
                $datenArray = zaehleVerstoesse($logDatei);
/*
if(DEBUG_V)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$datenArray['cpu'] <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	print_r($datenArray['cpu']);					
if(DEBUG_V)	echo "</pre>";
*/
/*
if(DEBUG_V)	echo "<pre class='debug value'><b>Line " . __LINE__ . "</b>: \$datenArray['spec'] <i>(" . basename(__FILE__) . ")</i>:<br>\n";					
if(DEBUG_V)	print_r($datenArray['spec']);					
if(DEBUG_V)	echo "</pre>";
*/

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
		<br>
		<hr>
		<br>
		<h2> <?php echo (isset($datenArray['linesTotal'])) ? "Anzahl Datensätze / Zeilen:".$datenArray['linesTotal']:''; ?></h2>
		<br>
		<hr>
		<br>
        <?php
            // Array der Seriennummern ausgeben
            $counter = 0;
			if(isset($datenArray['serialNumbers']))
			{
				echo "<h2>Die häufigsten 10 Seriennummern:</h2>";
				foreach ($datenArray['serialNumbers'] as $serial => $count) {
					echo "<p>Seriennummer: $serial, Anzahl: $count</p>";
					$counter++;
					if ($counter >= 10) {
						break; // Schleife abbrechen, wenn 10 Seriennummern ausgegeben wurden
					}
				}
			}
        ?>
		<br>
		<hr>
		<br>
		<?php
            // Array der Verstöße ausgeben
            $counter = 0;
			if(isset($datenArray['verstoesse']))
			{
				echo "<h2>Die ersten 10 Verstöße mit Seriennummern auf mehreren mac-Adressen:</h2>";
				foreach ($datenArray['verstoesse'] as $verstoss => $count) {
					echo "<p>Seriennummer: $verstoss, Anzahl der verschieden Mac-Adressen: $count</p>";
					$counter++;
					if ($counter >= 10) {
						break; // Schleife abbrechen, wenn 10 Seriennummern ausgegeben wurden
					}
				}
			}
        ?>
		<br>
		<hr>
		<br>
		<?php
            // Array der 10 meisten CPU`s ausgeben
            $counter = 0;
			if(isset($datenArray['cpu']))
			{
				echo "<h2>Die ersten 10 CPU`s mit den meisten Lizenzen:</h2>";
				foreach ($datenArray['cpu'] as $cpu => $count) {
					echo "<p>Hardware: $cpu, Anzahl der Lizenzen: $count</p>";
					$counter++;
					if ($counter >= 10) {
						break; // Schleife abbrechen, wenn 10 Seriennummern ausgegeben wurden
					}
				}
			}
        ?>
		<br>
		<hr>
		<br>
		<?php		
            // Zeitstempel für Benchmark setzen II
            $endtime =  microtime(true);
            // Differenz zwischen $starttime und $endtime berechnen
            $runtime = $endtime - $starttime;

            // Wenn die Laufzeit größer als 60 Sekunden ist
            if ($runtime >= 60) {
                $minutes = floor($runtime / 60); // Berechne Minuten
                $seconds = $runtime % 60; // Berechne verbleibende Sekunden
                $runtime_display = "$minutes Minuten und $seconds Sekunden";
            } else {
                $runtime_display = round($runtime, 5) . " Sekunden"; // Ansonsten, zeige Sekunden
            }
            $millisekunde = $runtime * 1000; // Millisekunden

        ?>
        <h3>Ausführungszeit des PHP Scriptes</h3>
        <p><?= $runtime_display ?></p>
        <p><?= $millisekunde ?> Millisekunden</p>
		<br>
		<hr>
		<br>
	</body>
	
</html>