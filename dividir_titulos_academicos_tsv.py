#!/usr/bin/python2.7
# coding=utf-8

import csv
from unicodedata import normalize
import re


def slq(id_titulo_academico,
        documento_docente,
        id_tipo_titulo_academico,
        titulo,
        id_universidad,
        paiscodigo,
        anno,
        id_modalidad_titulo_academico,
        resolucion,
        fecha_resolucion,
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
titulo,
id_universidad,
paiscodigo,
anno,
id_modalidad_titulo_academico,
resolucion,
fecha_resolucion,
entidad_convalidacion,
numero_acta,
fecha_acta,
numero_caso,
puntaje
) VALUES (
'%d',
'%s',
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
'%s',
'%s',
'%f'
);
    """ % (id_titulo_academico,
           documento_docente,
           id_tipo_titulo_academico,
           titulo,
           id_universidad,
           paiscodigo,
           anno,
           id_modalidad_titulo_academico,
           resolucion,
           fecha_resolucion,
           entidad_convalidacion,
           numero_acta,
           fecha_acta,
           numero_caso,
           puntaje)
    # print(sql)
    return sql

# https://gist.github.com/minichiello/194817


def elimina_acentos(cadena, codif='utf-8'):
    txt = cadena.decode(codif)
    return normalize('NFKD', txt).encode('ASCII', 'ignore')


def buscar_mejor_universidad(diccionario_ordenado, diccionario_mas_terminos):
    menor_num_term = 1000  # num grande
    mejor_universidad = ''
    for universidad in diccionario_ordenado:
        if diccionario_mas_terminos[universidad] < menor_num_term:
            menor_num_term = diccionario_mas_terminos[universidad]
            mejor_universidad = universidad
            if menor_num_term == 0:
                return mejor_universidad
    return mejor_universidad


def buscar_universidad(universidad):
    universidad = elimina_acentos(universidad).upper()
    diccionario = {}
    diccionario_mas_terminos = {}
    with open('kyron - Tabla universidades.csv', 'r') as csvfile:
        rows = csv.DictReader(csvfile, delimiter=",")
        rows_universidades = {}
        # Se hace un arreglo con todas las palabras coincidentes y las que no
        for row in rows:
            row_universidad = elimina_acentos(
                row['nombre_universidad']).upper()
            row_universidad = row_universidad[1:-1]  # quita primer y ultimo '
            #print(row_universidad, universidad)
            diccionario[row_universidad] = 0
            diccionario_mas_terminos[row_universidad] = 0
            rows_universidades[row_universidad] = row
            palabras = re.findall(r"[\w']+", universidad)
            for palabra in palabras:
                if row_universidad.find(palabra) > -1:
                    diccionario[row_universidad] += 1
                else:
                    diccionario_mas_terminos[row_universidad] += 1
            if len(palabras) != len(re.findall(r"[\w']+", row_universidad)):
                #print('palabra',palabras, re.findall(r"[\w']+", row_universidad))
                diccionario_mas_terminos[row_universidad] += 1
        # print(diccionario)
        # Se ordena el arreglo conforme a los términos coindidentes
        diccionario_ordenado = sorted(
            diccionario, key=diccionario.__getitem__, reverse=True)

        # Se busca la mejor universidad dentro de los que tienen más palabras
        # coincidentes y menos palabras restantes
        mejor_universidad = buscar_mejor_universidad(
            diccionario_ordenado, diccionario_mas_terminos)

        if diccionario_mas_terminos[mejor_universidad] > 0:
            print('Alerta, ubuscada:', universidad, ', uencontrada: ', elimina_acentos(
                rows_universidades[mejor_universidad]['nombre_universidad']))
            return False
        #print('Alerta2', universidad, mejor_universidad, diccionario_no_terminos[mejor_universidad], diccionario[mejor_universidad])
        id_universidad = rows_universidades[
            mejor_universidad]['id_universidad']

        # print(mejor_universidad)
        return int(id_universidad)
        #print(universidad, id_universidad, elimina_acentos(rows_universidades[mejor_universidad]['nombre_universidad']))
        # quit()

# http://www.tutorialspoint.com/python/python_classes_objects.htm


class pregrado_especial:

    def __init__(self, pregrado):
        self.es_especial = False
        self.puntaje = 178
        pregrado = elimina_acentos(pregrado).upper()
        if pregrado.find('MUSICA') > -1 or pregrado.find('MEDICIN'):
            self.es_especial = True
            self.puntaje = 183


class segunda_especializacion:
    cuenta = {}  # compartido por todos https://docs.python.org/3/tutorial/classes.html

    def __init__(self, especializacion, docente):
        if not self.cuenta.has_key(docente):
            self.cuenta[docente] = 0

        if self.cuenta[docente] == 0:
            self.puntaje = 20
            self.cuenta[docente] += 1
        elif self.cuenta[docente] == 1:
            print('segunda especializacion: ', self.cuenta[docente], docente)
            self.puntaje = 10
            self.cuenta[docente] += 1
        else:
            print('otra especializacion: ', self.cuenta[docente], docente)
            self.puntaje = 0


class segunda_maestria:
    cuenta = {}  # compartido por todos https://docs.python.org/3/tutorial/classes.html

    def __init__(self, maestria, docente):
        if not self.cuenta.has_key(docente):
            self.cuenta[docente] = 0

        if self.cuenta[docente] == 0:
            self.puntaje = 40
            self.cuenta[docente] += 1
        elif self.cuenta[docente] == 1:
            print('segunda maestria: ', self.cuenta[docente], docente)
            self.puntaje = 20
            self.cuenta[docente] += 1
        else:
            print('otra maestria: ', self.cuenta[docente], docente)
            self.puntaje = 0


class segundo_doctorado:
    cuenta = {}  # compartido por todos https://docs.python.org/3/tutorial/classes.html

    def __init__(self, doctorado, docente):
        if not self.cuenta.has_key(docente):
            self.cuenta[docente] = 0

        if self.cuenta[docente] == 0:
            self.puntaje = 120
            if segunda_maestria.cuenta.has_key(docente):
                print('doctorado con maestria: ', self.cuenta[docente], docente)
                self.puntaje = 80
            self.cuenta[docente] += 1
        elif self.cuenta[docente] == 1:
            print('segundo doctorado: ', self.cuenta[docente])
            self.puntaje = 20
            if segunda_maestria.cuenta.has_key(docente):
                print('segundo doctorado con maestria: ', self.cuenta[docente], docente)
                self.puntaje = 40
            self.cuenta[docente] += 1
        else:
            print('otro doctorado: ', self.cuenta[docente])
            if segunda_maestria.cuenta.has_key(docente) and self.cuenta[docente] == 3:
                print('tercer doctorado con maestria: ', self.cuenta[docente], docente)
                self.puntaje = 20
            self.puntaje = 0


def ano_fecha(fecha):
    # print(fecha)
    if fecha is None:
        return -1
    fecha = fecha.split('/')
    if len(fecha) == 3:
        anno = int(fecha[2])
    else:
        anno = -1
    return anno


def escribir_archivo(texto):
    fh = open("sql.txt", "a")
    fh.write(texto)
    fh.close

# http://es.stackoverflow.com/questions/763/c%c3%b3mo-negar-no-seleccionar-con-expresiones-regulares-en-php-o-javascript#11509
with open('kyron - Tabla Títulos Académicos - datos titulo_academico.tsv', 'r') as csvfile:
    rows = csv.DictReader(csvfile, delimiter="\t")
    sql = ''
    num_titulo = 0
    for row in rows:
        # print(row)
        num_titulo += 1
        if row['PREGRADO']:
            # print(row['PREGRADO'])
            universidad = ''
            id_universidad = buscar_universidad(row['INSTITUCION PREGRADO'])
            if id_universidad is False:
                print('Uni rara pre:', row['INSTITUCION PREGRADO'])
                id_universidad = -1
            anno = ano_fecha(row['FECHA PREGRADO'])
            puntaje = pregrado_especial(row['PREGRADO']).puntaje
            resolucion = ''
            fecha_resolucion = ''
            sql = slq(
                num_titulo,
                row['id_docente'],
                1,  # pregrado
                row['PREGRADO'],  # titulo
                id_universidad,  # id_universidad
                -1,  # paiscodigo
                anno,  # anno
                1,  # id_modalidad_titulo_academico
                resolucion,
                fecha_resolucion,
                universidad,  # entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                puntaje  # puntaje pregrado
            )
            # print(sql)
            escribir_archivo(sql)
        if row['ESPECIALIZACION']:
            # print(row['ESPECIALIZACION'])
            universidad = ''
            id_universidad = buscar_universidad(
                row['INSTITUCION ESPECIALIZACION'])
            if id_universidad is False:
                print('Uni rara esp:', row['INSTITUCION ESPECIALIZACION'])
                id_universidad = -1
            anno = ano_fecha(row['FECHA ESPECIALIZACION'])
            especializacion = segunda_especializacion(
                row['ESPECIALIZACION'], row['id_docente'])
            puntaje = especializacion.puntaje
            resolucion = ''
            fecha_resolucion = ''
            sql = slq(
                num_titulo,
                row['id_docente'],
                1,  # pregrado
                row['ESPECIALIZACION'],  # titulo
                id_universidad,  # id_universidad
                -1,  # paiscodigo
                anno,  # anno
                2,  # id_modalidad_titulo_academico
                resolucion,
                fecha_resolucion,
                universidad,  # entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                puntaje  # puntaje pregrado
            )
            # print(sql)
            escribir_archivo(sql)
        if row['MAESTRIA']:
            # print(row['MAESTRIA'])
            universidad = ''
            id_universidad = buscar_universidad(
                row['INSTITUCION MAESTRIA'])
            if id_universidad is False:
                print('Uni rara maes:', row['INSTITUCION MAESTRIA'])
                id_universidad = -1
            anno = ano_fecha(row['FECHA MAESTRIA'])
            maestria = segunda_maestria(
                row['MAESTRIA'], row['id_docente'])
            puntaje = maestria.puntaje
            resolucion = ''
            fecha_resolucion = ''
            sql = slq(
                num_titulo,
                row['id_docente'],
                1,  # pregrado
                row['MAESTRIA'],  # titulo
                id_universidad,  # id_universidad
                -1,  # paiscodigo
                anno,  # anno
                3,  # id_modalidad_titulo_academico
                resolucion,
                fecha_resolucion,
                universidad,  # entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                puntaje  # puntaje pregrado
            )
            # print(sql)
            escribir_archivo(sql)
        if row['DOCTORADO']:
            # print(row['DOCTORADO'])
            universidad = ''
            id_universidad = buscar_universidad(
                row['INSTITUCION DOCTORADO'])
            if id_universidad is False:
                print('Uni rara doc:', row['INSTITUCION DOCTORADO'])
                id_universidad = -1
            anno = ano_fecha(row['FECHA DOCTORADO'])
            doctorado = segundo_doctorado(
                row['DOCTORADO'], row['id_docente'])
            puntaje = doctorado.puntaje
            resolucion = ''
            fecha_resolucion = ''
            sql = slq(
                num_titulo,
                row['id_docente'],
                1,  # pregrado
                row['DOCTORADO'],  # titulo
                id_universidad,  # id_universidad
                -1,  # paiscodigo
                anno,  # anno
                4,  # id_modalidad_titulo_academico
                resolucion,
                fecha_resolucion,
                universidad,  # entidad_convalidacion
                'numero_acta',
                'fecha_acta',
                'numero_caso',
                puntaje  # puntaje pregrado
            )
            # print(sql)
            escribir_archivo(sql)
