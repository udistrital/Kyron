#!/usr/bin/python
import psycopg2
import sys
import os
import csv

def writeCSV(table_name, columns, rows):
    with open(table_name + '.tsv', 'wb') as csvfile:
        filewriter = csv.writer(csvfile, delimiter='\t',
                                quotechar='"', quoting=csv.QUOTE_MINIMAL)
        filewriter.writerow(columns)
        for row in rows:
            print(row)
            filewriter.writerow(row)

def queryColumns(cursor, table_name):
    cursor.execute('SELECT * FROM docencia.%s WHERE 1=0;' % (table_name))

    rows = cursor.fetchall()

    # Extract the column names
    col_names = []
    for elt in cursor.description:
        col_names.append(elt[0])

    print(col_names)
    print(rows)
    writeCSV(table_name, col_names, rows)

def main():
    # Define our connection string
    # in ~/.bashrc
    # export KYRON_HOSTNAME='<hostname>'
    # export KYRON_USER='<username>'
    # export KYRON_PASSWORD='<password>'

    hostname = os.getenv('KYRON_HOSTNAME', None)
    dbname = 'kyron'
    username = os.getenv('KYRON_USER', None)
    password = os.getenv('KYRON_PASSWORD', None)

    conn_string = "host='%s' dbname='%s' user='%s' password='%s'" % (
        hostname, dbname, username, password)

    # print the connection string we will use to connect
    print "Connecting to database\n	->%s" % (conn_string)

    # get a connection, if a connect cannot be made an exception will be raised here
    conn = psycopg2.connect(conn_string)

    # conn.cursor will return a cursor object, you can use this cursor to perform queries
    cursor = conn.cursor()
    print "Connected!\n"
    queryColumns(cursor, 'capitulo_libro')
    queryColumns(cursor, 'caracter_video')
    queryColumns(cursor, 'cartas_editor')
    queryColumns(cursor, 'categoria_actual_docente')
    queryColumns(cursor, 'categoria_docente')
    queryColumns(cursor, 'categoria_puntaje')
    queryColumns(cursor, 'categoria_trabajogrado')
    queryColumns(cursor, 'ciudad')
    queryColumns(cursor, 'comunicacion_corta')
    queryColumns(cursor, 'contexto')
    queryColumns(cursor, 'contexto_ponencia')
    queryColumns(cursor, 'direccion_trabajogrado')
    queryColumns(cursor, 'direccion_trabajogrado_estudiante')
    queryColumns(cursor, 'docente')
    queryColumns(cursor, 'docente_proyectocurricular')
    queryColumns(cursor, 'editorial')
    queryColumns(cursor, 'estudio_postdoctoral_docente')
    queryColumns(cursor, 'evaluador_capitulo_libro')
    queryColumns(cursor, 'evaluador_libro_docente')
    queryColumns(cursor, 'evaluador_produccion_tecnicaysoftware')
    queryColumns(cursor, 'evaluador_produccion_video')
    queryColumns(cursor, 'excelencia_academica')
    queryColumns(cursor, 'experiencia_calificada')
    queryColumns(cursor, 'experiencia_direccion_academica')
    queryColumns(cursor, 'experiencia_docencia')
    queryColumns(cursor, 'experiencia_investigacion')
    queryColumns(cursor, 'experiencia_profesional')
    queryColumns(cursor, 'facultad')
    queryColumns(cursor, 'genero')
    queryColumns(cursor, 'libro_docente')
    queryColumns(cursor, 'modalidad_titulo_academico')
    queryColumns(cursor, 'novedad')
    queryColumns(cursor, 'obra_artistica')
    queryColumns(cursor, 'observacion_verificacion')
    queryColumns(cursor, 'pais')
    queryColumns(cursor, 'patente')
    queryColumns(cursor, 'ponencia')
    queryColumns(cursor, 'premio_docente')
    queryColumns(cursor, 'produccion_tecnicaysoftware')
    queryColumns(cursor, 'produccion_video')
    queryColumns(cursor, 'proyectocurricular')
    queryColumns(cursor, 'publicacion_impresa')
    queryColumns(cursor, 'resena_critica')
    queryColumns(cursor, 'revista_indexada')
    queryColumns(cursor, 'tipo_categoria_docente')
    queryColumns(cursor, 'tipo_dedicacion')
    queryColumns(cursor, 'tipo_documento')
    queryColumns(cursor, 'tipo_emisor_resolucion')
    queryColumns(cursor, 'tipo_entidad')
    queryColumns(cursor, 'tipo_experiencia_calificada')
    queryColumns(cursor, 'tipo_experiencia_investigacion')
    queryColumns(cursor, 'tipo_indexacion')
    queryColumns(cursor, 'tipo_libro')
    queryColumns(cursor, 'tipo_novedad')
    queryColumns(cursor, 'tipo_obra_artistica')
    queryColumns(cursor, 'tipo_observacion')
    queryColumns(cursor, 'tipo_patente')
    queryColumns(cursor, 'tipo_tecnicaysoftware')
    queryColumns(cursor, 'tipo_titulo_academico')
    queryColumns(cursor, 'tipo_trabajogrado')
    queryColumns(cursor, 'tipo_traduccion_articulo')
    queryColumns(cursor, 'titulo_academico')
    queryColumns(cursor, 'traduccion_articulo')
    queryColumns(cursor, 'traduccion_libro')
    queryColumns(cursor, 'universidad')
if __name__ == "__main__":
    main()
