import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

df = pd.read_csv('resources/glucosa.csv', sep=';')
#df.describe()

#df.set_index('Year').plot()
lasernm = 785
lasercm1 =10000000.0 / lasernm

def cm1tonm(cm1):
    global lasercm1
    deltacm1 = lasercm1 - cm1
    nm = 10000000.0 / deltacm1
    return nm

velocidad_luz = 299792458

def nmtofreq(nm):
    global velocidad_luz
    longitud_onda_m = nm / 1000000000.0
    return velocidad_luz/(longitud_onda_m)

def freqtoterahz(hz):
    return hz / 1000000000000.0

df[ 'longitud_onda_nm' ] = df[ 'cm-1' ].apply( lambda x: cm1tonm( x ) )

df[ 'frecuencia' ] = df[ 'longitud_onda_nm' ].apply( lambda x: nmtofreq( x ) )

df[ 'frecuencia_tera_hz' ] = df[ 'frecuencia' ].apply( lambda x: freqtoterahz( x ) )

def normalize(x, max1):
    return x/max1;

max1 = df[ 'intensidad' ].max()

df[ 'intensidad_normalizada' ] = df[ 'intensidad' ].apply( lambda x: normalize( x, max1 ) )


##df.plot(x='cm-1', y='intensidad', marker='.')
#ax = df.plot(x='longitud_onda_nm', y='intensidad', marker='.')
ax = df.plot(x='longitud_onda_nm', y='intensidad_normalizada', marker='.')
##plt.show()
#df.plot(x='frecuencia', y='intensidad', marker='.')

#df.plot(x='frecuencia_tera_hz', y='intensidad', marker='.')

#plt.show()

#df2 = pd.read_csv('resources/BP 104 FS.csv', sep='\t')
#df2 = pd.read_csv('resources/SFH 229.csv', sep='\t')
#df2 = pd.read_csv('resources/SFH 229 FA.csv', sep='\t')
#df2 = pd.read_csv('resources/TCS3200.csv', sep='\t')
#df2 = pd.read_csv('resources/VEMD6060X01.csv', sep='\t')
df2 = pd.read_csv('resources/OPR2101.csv', sep=';')

# https://codepen.io/realjameal/pen/gpzZGw
# var path = document.getElementById('path')
# var text=""; var pathLength = Math.floor( path.getTotalLength() );
# for (var i=0; i<pathLength; i++) {pt = path.getPointAtLength(i);text+=pt.y + ";"+pt.x + "\n"}
# copy(text);

#df2.plot()
#df2.head()
df2.plot(x='longitud', y='sensibilidad', marker='.', ax=ax, title='SFH 229')
plt.show()

#df.plot()
#plt.show()
#plt.plot([1,2,3,4])
#plt.ylabel('some numbers')
#plt.show()