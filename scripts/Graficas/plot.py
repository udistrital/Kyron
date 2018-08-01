import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

#df = pd.read_csv('resources/data-log-test.csv', sep=',')
df = pd.read_csv('resources/data-log-1532709448617.csv', sep=',')
#df.describe()
# df['fecha_log'].min() to df['fecha_log'].max()
df['fecha_log'] = pd.to_datetime(df['fecha_log'])

prob = df['accion'].value_counts(normalize=False)
threshold = 0.02
mask = prob > threshold
tail_prob = prob.loc[~mask].sum()
prob = prob.loc[mask]
prob['other'] = tail_prob
prob.plot(kind='bar')
plt.xticks(rotation=25)
plt.show()

prob = df['accion'].value_counts(normalize=False)
prob.plot(kind='bar')
plt.xticks(rotation=25)
plt.show()

serief = df['fecha_log'].value_counts()
serief.plot(kind='hist')
plt.show()

exit()

#df.set_index('Year').plot()
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
