#!/usr/bin/python2.7
# coding=utf-8

import csv


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
    print(sql)

with open('kyron - Tabla Títulos Académicos - datos titulo_academico.tsv', 'r') as csvfile:
    rows = csv.DictReader(csvfile, delimiter="\t")
    pregrado = 0
    for row in rows:
        # print(row)
        if row['PREGRADO']:
            print(row['PREGRADO'])
            pregrado += 1
            slq(
                pregrado,
                row['id_docente'],
                1,#pregrado
                -1,#id_universidad
                -1,#paiscodigo
                1,#id_modalidad_titulo_academico
                'U Circulo',#entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                178#puntaje
            )
        if row['MAESTRIA']:
            print(row['MAESTRIA'])
        if row['DOCTORADO']:
            print(row['DOCTORADO'])
