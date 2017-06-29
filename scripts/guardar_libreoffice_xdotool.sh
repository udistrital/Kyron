#!/bin/bash

# rationale: debido a que las imagenes no tienen guardardada la
# rotacion en la imagen si no como metadato, se abren las imagenes
# con gimp y se automatiza la conversión
# se ejecuta con:
# sleep 5 && for i in `seq 1 10`; do sleep 1 && ./guardar_libreoffice_xdotool.sh; done

# click file menu
xdotool mousemove --sync 20 84
xdotool click 1
sleep 1

# click save as option
xdotool mousemove --sync 73 461
xdotool click 1
sleep 1

# click select format
xdotool mousemove --sync 1110 1019
xdotool click 1
xdotool key Down
xdotool key Down
xdotool key Down
xdotool key Down
xdotool key Down

# enter to accept format
xdotool key Return

# enter in Save dialog button
xdotool key Return
sleep 1

# enter in dialog are you sure tu use XLSX?
xdotool key Return
xdotool key Return
sleep 1

# close file
xdotool key "Ctrl+w"
