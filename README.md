# Loxberry Plugin: Guntamatic
Dieses Plugin ruft jede Minute den Status des Guntamatic Kessel ab und sendet die Daten über UDP an den gewählten Miniserver. Mittels virtuellem Ausgang kann der Miniserver die folgenden Befehle:

            "kesselfreigabeAUTO"
            "kesselfreigabeAUS"
            "kesselfreigabeEIN"

            "reglerAUS
            "reglerNORMAL
            "reglerWarmwasser
            "reglerHandbetrieb
            "HK0AUS
            "HK0NORMAL
            "HK0HEIZEN
            "HK0ABSENKEN
            "HK1AUS
            "HK1NORMAL
            "HK1HEIZEN
            "HK1ABSENKEN
            "HK2AUS
            "HK2NORMAL
            "HK2HEIZEN
            "HK2ABSENKEN

            "HK3AUS
            "HK3NORMAL
            "HK3HEIZEN
            "HK3ABSENKEN
                        
            "HK4AUS"
            "HK4NORMAL"
            "HK4HEIZEN"
            "HK4ABSENKEN"
            "HK5AUS"
            "HK5NORMAL"
            "HK5HEIZEN"
            "HK5ABSENKEN"
            "HK6AUS"
            "HK6NORMAL"
            "HK6HEIZEN"
            "HK6ABSENKEN"						
            "HK7AUS"
            "HK7NORMAL"
            "HK7HEIZEN"
            "HK7ABSENKEN"						
            "HK8AUS"
            "HK8NORMAL"
            "HK8HEIZEN"
            "HK8ABSENKEN"					
            "WW0Nachladen"
            "WW1Nachladen"
            "WW2Nachladen"
            "WWZus0Nachladen"
            "WWZus1Nachladen"
            "WWZus2Nachladen"	

Der UDP Port kann in den PlugIn Settings gewählt werden.
Jede Minute sendet das Plugin einen String an den Miniserver im Format {"status":" ","program":" ","kesseltemp":" ","co2":" ","leistung":" ","pufferO":" ","pufferU":" ","aussentemp":" ","warmwasser":" ","pumpeHP0":" ","asche":" ","stoerung":" ","vorlauf":" "}

Pumpen, Brandschutzklappe, STB, TKS1 und Kesselfreigabe schicken 1 für EIN und 0 für AUS
Für die Programme wird 0 für AUS, 1 für NORMAL und 2 für HEIZEN übertragen
Betrieb gibt 0 für AUS, 1 für REGELUNG und 2 für NACHLAUF aus.

## Feedback und Diskussion
Das PlugIn wird von mir noch weiterentwickelt und ich freue mich über Anregungen und Feedback.

## Change-Log
## Known-Issues
- 
