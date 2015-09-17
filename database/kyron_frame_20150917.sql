--
-- PostgreSQL database dump
--

-- Dumped from database version 9.3.9
-- Dumped by pg_dump version 9.3.9
-- Started on 2015-09-17 12:33:43 COT

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 6 (class 2615 OID 59517)
-- Name: kyron; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA kyron;


SET search_path = kyron, pg_catalog;

SET default_with_oids = false;

--
-- TOC entry 172 (class 1259 OID 59518)
-- Name: kyron_bloque; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_bloque (
    id_bloque integer NOT NULL,
    nombre character(50) NOT NULL,
    descripcion character(255) DEFAULT NULL::bpchar,
    grupo character(200) NOT NULL
);


--
-- TOC entry 173 (class 1259 OID 59525)
-- Name: kyron_bloque_id_bloque_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_bloque_id_bloque_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2177 (class 0 OID 0)
-- Dependencies: 173
-- Name: kyron_bloque_id_bloque_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_bloque_id_bloque_seq OWNED BY kyron_bloque.id_bloque;


--
-- TOC entry 174 (class 1259 OID 59527)
-- Name: kyron_bloque_pagina; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_bloque_pagina (
    idrelacion integer NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    id_bloque integer DEFAULT 0 NOT NULL,
    seccion character(1) NOT NULL,
    posicion integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 175 (class 1259 OID 59533)
-- Name: kyron_bloque_pagina_idrelacion_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_bloque_pagina_idrelacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2178 (class 0 OID 0)
-- Dependencies: 175
-- Name: kyron_bloque_pagina_idrelacion_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_bloque_pagina_idrelacion_seq OWNED BY kyron_bloque_pagina.idrelacion;


--
-- TOC entry 190 (class 1259 OID 59641)
-- Name: kyron_configuracion; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_configuracion (
    id_parametro integer NOT NULL,
    parametro character(255) NOT NULL,
    valor character(255) NOT NULL
);


--
-- TOC entry 191 (class 1259 OID 59647)
-- Name: kyron_configuracion_id_parametro_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_configuracion_id_parametro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2179 (class 0 OID 0)
-- Dependencies: 191
-- Name: kyron_configuracion_id_parametro_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_configuracion_id_parametro_seq OWNED BY kyron_configuracion.id_parametro;


--
-- TOC entry 176 (class 1259 OID 59543)
-- Name: kyron_dbms; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_dbms (
    idconexion integer NOT NULL,
    nombre character varying(50) NOT NULL,
    dbms character varying(20) NOT NULL,
    servidor character varying(50) NOT NULL,
    puerto integer NOT NULL,
    conexionssh character varying(50) NOT NULL,
    db character varying(100) NOT NULL,
    esquema character varying(100) NOT NULL,
    usuario character varying(100) NOT NULL,
    password character varying(200) NOT NULL
);


--
-- TOC entry 177 (class 1259 OID 59549)
-- Name: kyron_dbms_idconexion_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_dbms_idconexion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2180 (class 0 OID 0)
-- Dependencies: 177
-- Name: kyron_dbms_idconexion_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_dbms_idconexion_seq OWNED BY kyron_dbms.idconexion;


--
-- TOC entry 178 (class 1259 OID 59551)
-- Name: kyron_estilo; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_estilo (
    usuario character(50) DEFAULT '0'::bpchar NOT NULL,
    estilo character(50) NOT NULL
);


--
-- TOC entry 179 (class 1259 OID 59555)
-- Name: kyron_logger; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_logger (
    id integer NOT NULL,
    evento character(255) NOT NULL,
    fecha character(50) NOT NULL
);


--
-- TOC entry 180 (class 1259 OID 59558)
-- Name: kyron_logger_id_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_logger_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2181 (class 0 OID 0)
-- Dependencies: 180
-- Name: kyron_logger_id_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_logger_id_seq OWNED BY kyron_logger.id;


--
-- TOC entry 181 (class 1259 OID 59560)
-- Name: kyron_pagina; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_pagina (
    id_pagina integer NOT NULL,
    nombre character(50) DEFAULT ''::bpchar NOT NULL,
    descripcion character(250) DEFAULT ''::bpchar NOT NULL,
    modulo character(50) DEFAULT ''::bpchar NOT NULL,
    nivel integer DEFAULT 0 NOT NULL,
    parametro character(255) NOT NULL
);


--
-- TOC entry 182 (class 1259 OID 59570)
-- Name: kyron_pagina_id_pagina_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_pagina_id_pagina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2182 (class 0 OID 0)
-- Dependencies: 182
-- Name: kyron_pagina_id_pagina_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_pagina_id_pagina_seq OWNED BY kyron_pagina.id_pagina;


--
-- TOC entry 183 (class 1259 OID 59572)
-- Name: kyron_subsistema; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_subsistema (
    id_subsistema integer NOT NULL,
    nombre character varying(250) NOT NULL,
    etiqueta character varying(100) NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    observacion text
);


--
-- TOC entry 184 (class 1259 OID 59579)
-- Name: kyron_subsistema_id_subsistema_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_subsistema_id_subsistema_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2183 (class 0 OID 0)
-- Dependencies: 184
-- Name: kyron_subsistema_id_subsistema_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_subsistema_id_subsistema_seq OWNED BY kyron_subsistema.id_subsistema;


--
-- TOC entry 185 (class 1259 OID 59581)
-- Name: kyron_tempformulario; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_tempformulario (
    id_sesion character(32) NOT NULL,
    formulario character(100) NOT NULL,
    campo character(100) NOT NULL,
    valor text NOT NULL,
    fecha character(50) NOT NULL
);


--
-- TOC entry 186 (class 1259 OID 59587)
-- Name: kyron_usuario; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_usuario (
    id_usuario integer NOT NULL,
    nombre character varying(50) DEFAULT ''::character varying NOT NULL,
    apellido character varying(50) DEFAULT ''::character varying NOT NULL,
    correo character varying(100) DEFAULT ''::character varying NOT NULL,
    telefono character varying(50) DEFAULT ''::character varying NOT NULL,
    imagen character(255) NOT NULL,
    clave character varying(100) DEFAULT ''::character varying NOT NULL,
    tipo character varying(255) DEFAULT ''::character varying NOT NULL,
    estilo character varying(50) DEFAULT 'basico'::character varying NOT NULL,
    idioma character varying(50) DEFAULT 'es_es'::character varying NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 187 (class 1259 OID 59602)
-- Name: kyron_usuario_id_usuario_seq; Type: SEQUENCE; Schema: kyron; Owner: -
--

CREATE SEQUENCE kyron_usuario_id_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2184 (class 0 OID 0)
-- Dependencies: 187
-- Name: kyron_usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: kyron; Owner: -
--

ALTER SEQUENCE kyron_usuario_id_usuario_seq OWNED BY kyron_usuario.id_usuario;


--
-- TOC entry 188 (class 1259 OID 59604)
-- Name: kyron_usuario_subsistema; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_usuario_subsistema (
    id_usuario integer DEFAULT 0 NOT NULL,
    id_subsistema integer DEFAULT 0 NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);


--
-- TOC entry 189 (class 1259 OID 59610)
-- Name: kyron_valor_sesion; Type: TABLE; Schema: kyron; Owner: -
--

CREATE TABLE kyron_valor_sesion (
    sesionid character(32) NOT NULL,
    variable character(20) NOT NULL,
    valor character(255) NOT NULL,
    expiracion bigint DEFAULT 0 NOT NULL
);


--
-- TOC entry 1998 (class 2604 OID 59614)
-- Name: id_bloque; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_bloque ALTER COLUMN id_bloque SET DEFAULT nextval('kyron_bloque_id_bloque_seq'::regclass);


--
-- TOC entry 2002 (class 2604 OID 59615)
-- Name: idrelacion; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_bloque_pagina ALTER COLUMN idrelacion SET DEFAULT nextval('kyron_bloque_pagina_idrelacion_seq'::regclass);


--
-- TOC entry 2027 (class 2604 OID 59649)
-- Name: id_parametro; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_configuracion ALTER COLUMN id_parametro SET DEFAULT nextval('kyron_configuracion_id_parametro_seq'::regclass);


--
-- TOC entry 2003 (class 2604 OID 59617)
-- Name: idconexion; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_dbms ALTER COLUMN idconexion SET DEFAULT nextval('kyron_dbms_idconexion_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 59618)
-- Name: id; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_logger ALTER COLUMN id SET DEFAULT nextval('kyron_logger_id_seq'::regclass);


--
-- TOC entry 2010 (class 2604 OID 59619)
-- Name: id_pagina; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_pagina ALTER COLUMN id_pagina SET DEFAULT nextval('kyron_pagina_id_pagina_seq'::regclass);


--
-- TOC entry 2012 (class 2604 OID 59620)
-- Name: id_subsistema; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_subsistema ALTER COLUMN id_subsistema SET DEFAULT nextval('kyron_subsistema_id_subsistema_seq'::regclass);


--
-- TOC entry 2022 (class 2604 OID 59621)
-- Name: id_usuario; Type: DEFAULT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_usuario ALTER COLUMN id_usuario SET DEFAULT nextval('kyron_usuario_id_usuario_seq'::regclass);


--
-- TOC entry 2153 (class 0 OID 59518)
-- Dependencies: 172
-- Data for Name: kyron_bloque; Type: TABLE DATA; Schema: kyron; Owner: -
--

INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-1, 'menuLateral                                       ', 'Menú lateral módulo de desarrollo.                                                                                                                                                                                                                             ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-2, 'pie                                               ', 'Pie de página módulo de desarrollo.                                                                                                                                                                                                                            ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-3, 'banner                                            ', 'Banner módulo de desarrollo.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-4, 'cruder                                            ', 'Módulo para crear módulos CRUD.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-5, 'desenlace                                         ', 'Módulo de gestión de desenlace.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-6, 'registro                                          ', 'Módulo para registrar páginas o módulos.                                                                                                                                                                                                                       ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-7, 'constructor                                       ', 'Módulo para diseñar páginas.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-8, 'contenidoCentral                                  ', 'Contenido página principal de desarrollo.                                                                                                                                                                                                                      ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-9, 'codificador                                       ', 'Módulo para decodificar cadenas.                                                                                                                                                                                                                               ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-10, 'plugin                                            ', 'Módulo para agregar plugin preconfigurados.                                                                                                                                                                                                                    ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-11, 'saraFormCreator                                   ', 'Módulo para crear formulario con la recomendación de bloques de SARA.                                                                                                                                                                                          ', 'development                                                                                                                                                                                             ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (1, 'bannerKyron                                       ', 'Módulo que contiene el banner del proyecto Kyrón.                                                                                                                                                                                                              ', 'gui                                                                                                                                                                                                     ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (2, 'piePagina                                         ', 'Módulo que contiene el pie de página del proyecto kyrón.                                                                                                                                                                                                       ', 'gui                                                                                                                                                                                                     ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (3, 'menuPrincipal                                     ', 'Módulo que contiene el menú principal de la aplicación.                                                                                                                                                                                                        ', 'gui                                                                                                                                                                                                     ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (4, 'indexacionRevistas                                ', 'Módulo que permite crear diferentes tab para navegar en una misma página                                                                                                                                                                                       ', 'asignacionPuntajes/salariales                                                                                                                                                                           ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (5, 'bloqueModelo1                                     ', 'Módulo prueba                                                                                                                                                                                                                                                  ', 'bloquesModelo                                                                                                                                                                                           ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (6, 'produccionDeLibros                                ', 'Producción de libros                                                                                                                                                                                                                                           ', 'asignacionPuntajes/salariales                                                                                                                                                                           ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (7, 'cartasEditor                                      ', 'Cartas al Editor                                                                                                                                                                                                                                               ', 'asignacionPuntajes/salariales                                                                                                                                                                           ');
INSERT INTO kyron_bloque (id_bloque, nombre, descripcion, grupo) VALUES (8, 'obrasArtisticas                                   ', 'Obras artísticas puntos salariales                                                                                                                                                                                                                             ', 'asignacionPuntajes/salariales                                                                                                                                                                           ');


--
-- TOC entry 2185 (class 0 OID 0)
-- Dependencies: 173
-- Name: kyron_bloque_id_bloque_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_bloque_id_bloque_seq', 9, true);


--
-- TOC entry 2155 (class 0 OID 59527)
-- Dependencies: 174
-- Data for Name: kyron_bloque_pagina; Type: TABLE DATA; Schema: kyron; Owner: -
--

INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (1, -1, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (2, -1, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (3, -1, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (4, -1, -8, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (5, -2, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (6, -2, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (7, -2, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (8, -2, -4, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (9, -3, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (10, -3, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (11, -3, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (12, -3, -5, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (13, -4, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (14, -4, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (15, -4, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (16, -4, -9, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (17, -5, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (18, -5, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (19, -5, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (20, -5, -6, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (21, -6, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (22, -6, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (23, -6, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (24, -6, -7, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (25, -7, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (26, -7, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (27, -7, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (28, -7, -10, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (29, -8, -1, 'B', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (30, -8, -2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (31, -8, -3, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (32, -8, -11, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (39, 2, 3, 'A', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (34, 1, 3, 'A', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (46, 4, 1, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (47, 4, 2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (48, 4, 3, 'A', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (45, 3, 6, 'C', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (49, 4, 7, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (42, 3, 1, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (43, 3, 2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (44, 3, 3, 'A', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (36, 1, 2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (37, 2, 1, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (38, 2, 2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (33, 1, 1, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (40, 2, 4, 'C', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (50, 5, 1, 'A', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (51, 5, 2, 'E', 1);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (52, 5, 3, 'A', 2);
INSERT INTO kyron_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (53, 5, 8, 'C', 1);


--
-- TOC entry 2186 (class 0 OID 0)
-- Dependencies: 175
-- Name: kyron_bloque_pagina_idrelacion_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_bloque_pagina_idrelacion_seq', 51, true);


--
-- TOC entry 2171 (class 0 OID 59641)
-- Dependencies: 190
-- Data for Name: kyron_configuracion; Type: TABLE DATA; Schema: kyron; Owner: -
--

INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (1, 'dbesquema                                                                                                                                                                                                                                                      ', 'kyron                                                                                                                                                                                                                                                          ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (2, 'prefijo                                                                                                                                                                                                                                                        ', 'kyron_                                                                                                                                                                                                                                                         ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (3, 'nombreAplicativo                                                                                                                                                                                                                                               ', 'Kyron                                                                                                                                                                                                                                                          ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (4, 'raizDocumento                                                                                                                                                                                                                                                  ', '/opt/lampp/htdocs/Kyron                                                                                                                                                                                                                                        ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (5, 'host                                                                                                                                                                                                                                                           ', 'http://localhost                                                                                                                                                                                                                                               ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (6, 'site                                                                                                                                                                                                                                                           ', '/Kyron                                                                                                                                                                                                                                                         ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (7, 'nombreAdministrador                                                                                                                                                                                                                                            ', 'administrador                                                                                                                                                                                                                                                  ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (8, 'claveAdministrador                                                                                                                                                                                                                                             ', 'Y6Pk0o96J5Jw3hOHLnqPjQhqt28s_oAkwMTrE1ZQ4J8                                                                                                                                                                                                                    ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (9, 'correoAdministrador                                                                                                                                                                                                                                            ', 'fernandotower@gmail.com                                                                                                                                                                                                                                        ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (10, 'enlace                                                                                                                                                                                                                                                         ', 'data                                                                                                                                                                                                                                                           ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (11, 'estiloPredeterminado                                                                                                                                                                                                                                           ', 'cupertino                                                                                                                                                                                                                                                      ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (12, 'moduloDesarrollo                                                                                                                                                                                                                                               ', 'moduloDesarrollo                                                                                                                                                                                                                                               ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (13, 'googlemaps                                                                                                                                                                                                                                                     ', '                                                                                                                                                                                                                                                               ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (14, 'recatchapublica                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (15, 'recatchaprivada                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (16, 'expiracion                                                                                                                                                                                                                                                     ', '5                                                                                                                                                                                                                                                              ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (17, 'instalado                                                                                                                                                                                                                                                      ', 'true                                                                                                                                                                                                                                                           ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (18, 'debugMode                                                                                                                                                                                                                                                      ', 'false                                                                                                                                                                                                                                                          ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (19, 'dbPrincipal                                                                                                                                                                                                                                                    ', 'kyron                                                                                                                                                                                                                                                          ');
INSERT INTO kyron_configuracion (id_parametro, parametro, valor) VALUES (20, 'hostSeguro                                                                                                                                                                                                                                                     ', 'https://localhost                                                                                                                                                                                                                                              ');


--
-- TOC entry 2187 (class 0 OID 0)
-- Dependencies: 191
-- Name: kyron_configuracion_id_parametro_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_configuracion_id_parametro_seq', 20, true);


--
-- TOC entry 2157 (class 0 OID 59543)
-- Dependencies: 176
-- Data for Name: kyron_dbms; Type: TABLE DATA; Schema: kyron; Owner: -
--

INSERT INTO kyron_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (1, 'estructura', 'pgsql', 'localhost', 5432, '', 'kyron', 'kyron', 'postgres', 'jeKtD4hu9Hc4JfGUUv-ulIHzadgJatH5AcvhmcL0muE');
INSERT INTO kyron_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (2, 'menu', 'pgsql', 'localhost', 5432, '', 'kyron', 'menu', 'postgres', 'jeKtD4hu9Hc4JfGUUv-ulIHzadgJatH5AcvhmcL0muE');
INSERT INTO kyron_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (3, 'docencia', 'pgsql', 'localhost', 5432, '', 'kyron', 'docencia', 'postgres', 'jeKtD4hu9Hc4JfGUUv-ulIHzadgJatH5AcvhmcL0muE');


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 177
-- Name: kyron_dbms_idconexion_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_dbms_idconexion_seq', 8, true);


--
-- TOC entry 2159 (class 0 OID 59551)
-- Dependencies: 178
-- Data for Name: kyron_estilo; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2160 (class 0 OID 59555)
-- Dependencies: 179
-- Data for Name: kyron_logger; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 180
-- Name: kyron_logger_id_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_logger_id_seq', 1, false);


--
-- TOC entry 2162 (class 0 OID 59560)
-- Dependencies: 181
-- Data for Name: kyron_pagina; Type: TABLE DATA; Schema: kyron; Owner: -
--

INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-1, 'development                                       ', 'Index módulo de desarrollo.                                                                                                                                                                                                                               ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-2, 'cruder                                            ', 'Generador módulos CRUD.                                                                                                                                                                                                                                   ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-3, 'desenlace                                         ', 'Analizar enlaces.                                                                                                                                                                                                                                         ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-4, 'codificador                                       ', 'Codificar/decodificar cadenas.                                                                                                                                                                                                                            ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-5, 'registro                                          ', 'Registrar páginas o módulos.                                                                                                                                                                                                                              ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-6, 'constructor                                       ', 'Diseñar páginas.                                                                                                                                                                                                                                          ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-7, 'plugin                                            ', 'Agregar plugin preconfigurados.                                                                                                                                                                                                                           ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-8, 'saraFormCreator                                   ', 'Módulo SARA form creator.                                                                                                                                                                                                                                 ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (3, 'produccionDeLibros                                ', 'Página que contiene el módulo de producción de libros                                                                                                                                                                                                     ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (4, 'cartasEditor                                      ', 'Página que contiene el módulo de cartas al editor                                                                                                                                                                                                         ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (1, 'index                                             ', 'Página principal del proyecto Kyrón.                                                                                                                                                                                                                      ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (2, 'revistasIndexadas                                 ', 'Página que contiene el módulo de revistas indexadas.                                                                                                                                                                                                      ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO kyron_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (5, 'obrasArtisticas                                   ', 'Página que contiene el módulo de obras artísticas puntos salariales                                                                                                                                                                                       ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');


--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 182
-- Name: kyron_pagina_id_pagina_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_pagina_id_pagina_seq', 8, true);


--
-- TOC entry 2164 (class 0 OID 59572)
-- Dependencies: 183
-- Data for Name: kyron_subsistema; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 184
-- Name: kyron_subsistema_id_subsistema_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_subsistema_id_subsistema_seq', 1, false);


--
-- TOC entry 2166 (class 0 OID 59581)
-- Dependencies: 185
-- Data for Name: kyron_tempformulario; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2167 (class 0 OID 59587)
-- Dependencies: 186
-- Data for Name: kyron_usuario; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 187
-- Name: kyron_usuario_id_usuario_seq; Type: SEQUENCE SET; Schema: kyron; Owner: -
--

SELECT pg_catalog.setval('kyron_usuario_id_usuario_seq', 1, false);


--
-- TOC entry 2169 (class 0 OID 59604)
-- Dependencies: 188
-- Data for Name: kyron_usuario_subsistema; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2170 (class 0 OID 59610)
-- Dependencies: 189
-- Data for Name: kyron_valor_sesion; Type: TABLE DATA; Schema: kyron; Owner: -
--



--
-- TOC entry 2031 (class 2606 OID 59623)
-- Name: kyron_bloque_pagina_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_bloque_pagina
    ADD CONSTRAINT kyron_bloque_pagina_pkey PRIMARY KEY (idrelacion);


--
-- TOC entry 2029 (class 2606 OID 59625)
-- Name: kyron_bloque_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_bloque
    ADD CONSTRAINT kyron_bloque_pkey PRIMARY KEY (id_bloque);


--
-- TOC entry 2045 (class 2606 OID 59651)
-- Name: kyron_configuracion_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_configuracion
    ADD CONSTRAINT kyron_configuracion_pkey PRIMARY KEY (id_parametro);


--
-- TOC entry 2033 (class 2606 OID 59629)
-- Name: kyron_dbms_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_dbms
    ADD CONSTRAINT kyron_dbms_pkey PRIMARY KEY (idconexion);


--
-- TOC entry 2035 (class 2606 OID 59631)
-- Name: kyron_estilo_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_estilo
    ADD CONSTRAINT kyron_estilo_pkey PRIMARY KEY (usuario, estilo);


--
-- TOC entry 2037 (class 2606 OID 59633)
-- Name: kyron_pagina_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_pagina
    ADD CONSTRAINT kyron_pagina_pkey PRIMARY KEY (id_pagina);


--
-- TOC entry 2039 (class 2606 OID 59635)
-- Name: kyron_subsistema_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_subsistema
    ADD CONSTRAINT kyron_subsistema_pkey PRIMARY KEY (id_subsistema);


--
-- TOC entry 2041 (class 2606 OID 59637)
-- Name: kyron_usuario_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_usuario
    ADD CONSTRAINT kyron_usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2043 (class 2606 OID 59639)
-- Name: kyron_valor_sesion_pkey; Type: CONSTRAINT; Schema: kyron; Owner: -
--

ALTER TABLE ONLY kyron_valor_sesion
    ADD CONSTRAINT kyron_valor_sesion_pkey PRIMARY KEY (sesionid, variable);


-- Completed on 2015-09-17 12:33:43 COT

--
-- PostgreSQL database dump complete
--

