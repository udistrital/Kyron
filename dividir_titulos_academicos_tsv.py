#!/usr/bin/python2.7
# coding=utf-8

import csv
from unicodedata import normalize
import re

def slq(id_titulo_academico,
        documento_docente,
        id_tipo_titulo_academico,
        id_universidad,
        paiscodigo,
        id_modalidad_titulo_academico,
        entidad_convalidacion,
        numero_acta,
        fecha_acta,
        numero_caso,
        puntaje):
    sql = """
INSERT INTO docencia.titulo_academico(
id_titulo_academico,
documento_docente,
id_tipo_titulo_academico,
id_universidad,
paiscodigo,
id_modalidad_titulo_academico,
entidad_convalidacion,
numero_acta,
fecha_acta,
numero_caso,
puntaje
) VALUES (
'%d',
'%s',
'%d',
'%d',
'%d',
'%d',
'%s',
'%s',
'%s',
'%s',
'%f'
);
    """ % (id_titulo_academico,
           documento_docente,
           id_tipo_titulo_academico,
           id_universidad,
           paiscodigo,
           id_modalidad_titulo_academico,
           entidad_convalidacion,
           numero_acta,
           fecha_acta,
           numero_caso,
           puntaje)
    #print(sql)
    return sql

#https://gist.github.com/minichiello/194817
def elimina_acentos(cadena, codif='utf-8'):
    txt = cadena.decode(codif)
    return normalize('NFKD', txt).encode('ASCII','ignore')


def buscarUniversidad(universidad):
    universidad = elimina_acentos(universidad).upper()
    diccionario = {}
    diccionario_no_terminos = {}
    with open('kyron - Tabla universidades.csv', 'r') as csvfile:
        rows = csv.DictReader(csvfile, delimiter=",")
        rows_universidades = {}
        for row in rows:
            row_universidad = elimina_acentos(row['nombre_universidad']).upper()
            #print(row_universidad, universidad)
            diccionario[row_universidad] = 0
            diccionario_no_terminos[row_universidad] = 0
            rows_universidades[row_universidad] = row
            palabras = re.findall(r"[\w']+", universidad)
            for palabra in palabras:
                if row_universidad.find(palabra) > -1:
                    diccionario[row_universidad] += 1
                else:
                    diccionario_no_terminos[row_universidad] += 1
            if len(palabras) != len(re.findall(r"[\w']+", row_universidad)):
                diccionario_no_terminos[row_universidad] += 1
        #print(diccionario)
        diccionario_ordenado = sorted(diccionario, key=diccionario.__getitem__, reverse=True)
        mejor_universidad = diccionario_ordenado[0]

        if diccionario_no_terminos[mejor_universidad] > 0 :
            print('Alerta: ',universidad, elimina_acentos(rows_universidades[mejor_universidad]['nombre_universidad']))
            return False
        #print('Alerta2', universidad, mejor_universidad, diccionario_no_terminos[mejor_universidad], diccionario[mejor_universidad])
        id_universidad = rows_universidades[mejor_universidad]['id_universidad']

        #print(mejor_universidad)
        return int(id_universidad)
        #print(universidad, id_universidad, elimina_acentos(rows_universidades[mejor_universidad]['nombre_universidad']))
        #quit()


with open('kyron - Tabla Títulos Académicos - datos titulo_academico.tsv', 'r') as csvfile:
    rows = csv.DictReader(csvfile, delimiter="\t")
    pregrado = 0
    for row in rows:
        # print(row)
        universidad = ''
        id_universidad = buscarUniversidad(row['INSTITUCION PREGRADO'])
        if id_universidad is False:
            print('Hola:', row['INSTITUCION PREGRADO'])
            universidad = row['INSTITUCION PREGRADO']
        if row['PREGRADO']:
            #print(row['PREGRADO'])
            pregrado += 1
            sql = slq(
                pregrado,
                row['id_docente'],
                1,  # pregrado
                id_universidad,  # id_universidad
                -1,  # paiscodigo
                1,  # id_modalidad_titulo_academico
                universidad,  # entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                178  # puntaje pregrado
            )
            print(sql)
        if row['MAESTRIA']:
            print(row['MAESTRIA'])
        if row['DOCTORADO']:
            print(row['DOCTORADO'])
