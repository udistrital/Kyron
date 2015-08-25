--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.4
-- Dumped by pg_dump version 9.2.7
-- Started on 2015-03-16 12:49:09 COT

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 6 (class 2615 OID 17010)
-- Name: arkaFrame; Type: SCHEMA; Schema: -; Owner: arka_frame
--

CREATE SCHEMA "arkaFrame";


ALTER SCHEMA "arkaFrame" OWNER TO arka_frame;

--
-- TOC entry 9 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 3346 (class 0 OID 0)
-- Dependencies: 9
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 298 (class 1259 OID 17509)
-- Name: arka_bloque; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_bloque (
    id_bloque integer NOT NULL,
    nombre character(50) NOT NULL,
    descripcion character(255) DEFAULT NULL::bpchar,
    grupo character(200) NOT NULL
);


ALTER TABLE public.arka_bloque OWNER TO arka_frame;

--
-- TOC entry 299 (class 1259 OID 17516)
-- Name: arka_bloque_id_bloque_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_bloque_id_bloque_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_bloque_id_bloque_seq OWNER TO arka_frame;

--
-- TOC entry 3348 (class 0 OID 0)
-- Dependencies: 299
-- Name: arka_bloque_id_bloque_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_bloque_id_bloque_seq OWNED BY arka_bloque.id_bloque;


--
-- TOC entry 300 (class 1259 OID 17518)
-- Name: arka_bloque_pagina; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_bloque_pagina (
    idrelacion integer NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    id_bloque integer DEFAULT 0 NOT NULL,
    seccion character(1) NOT NULL,
    posicion integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.arka_bloque_pagina OWNER TO arka_frame;

--
-- TOC entry 301 (class 1259 OID 17524)
-- Name: arka_bloque_pagina_idrelacion_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_bloque_pagina_idrelacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_bloque_pagina_idrelacion_seq OWNER TO arka_frame;

--
-- TOC entry 3349 (class 0 OID 0)
-- Dependencies: 301
-- Name: arka_bloque_pagina_idrelacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_bloque_pagina_idrelacion_seq OWNED BY arka_bloque_pagina.idrelacion;


--
-- TOC entry 302 (class 1259 OID 17526)
-- Name: arka_configuracion; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_configuracion (
    id_parametro integer NOT NULL,
    parametro character(255) NOT NULL,
    valor character(255) NOT NULL
);


ALTER TABLE public.arka_configuracion OWNER TO arka_frame;

--
-- TOC entry 303 (class 1259 OID 17532)
-- Name: arka_configuracion_id_parametro_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_configuracion_id_parametro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_configuracion_id_parametro_seq OWNER TO arka_frame;

--
-- TOC entry 3350 (class 0 OID 0)
-- Dependencies: 303
-- Name: arka_configuracion_id_parametro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_configuracion_id_parametro_seq OWNED BY arka_configuracion.id_parametro;


--
-- TOC entry 304 (class 1259 OID 17534)
-- Name: arka_dbms; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_dbms (
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


ALTER TABLE public.arka_dbms OWNER TO arka_frame;

--
-- TOC entry 305 (class 1259 OID 17540)
-- Name: arka_dbms_idconexion_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_dbms_idconexion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_dbms_idconexion_seq OWNER TO arka_frame;

--
-- TOC entry 3351 (class 0 OID 0)
-- Dependencies: 305
-- Name: arka_dbms_idconexion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_dbms_idconexion_seq OWNED BY arka_dbms.idconexion;


--
-- TOC entry 306 (class 1259 OID 17542)
-- Name: arka_estilo; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_estilo (
    usuario character(50) DEFAULT '0'::bpchar NOT NULL,
    estilo character(50) NOT NULL
);


ALTER TABLE public.arka_estilo OWNER TO arka_frame;

--
-- TOC entry 307 (class 1259 OID 17546)
-- Name: arka_logger; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_logger (
    id integer NOT NULL,
    evento character(255) NOT NULL,
    fecha character(50) NOT NULL
);


ALTER TABLE public.arka_logger OWNER TO arka_frame;

--
-- TOC entry 308 (class 1259 OID 17549)
-- Name: arka_logger_id_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_logger_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_logger_id_seq OWNER TO arka_frame;

--
-- TOC entry 3352 (class 0 OID 0)
-- Dependencies: 308
-- Name: arka_logger_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_logger_id_seq OWNED BY arka_logger.id;


--
-- TOC entry 309 (class 1259 OID 17551)
-- Name: arka_pagina; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_pagina (
    id_pagina integer NOT NULL,
    nombre character(50) DEFAULT ''::bpchar NOT NULL,
    descripcion character(250) DEFAULT ''::bpchar NOT NULL,
    modulo character(50) DEFAULT ''::bpchar NOT NULL,
    nivel integer DEFAULT 0 NOT NULL,
    parametro character(255) NOT NULL
);


ALTER TABLE public.arka_pagina OWNER TO arka_frame;

--
-- TOC entry 310 (class 1259 OID 17561)
-- Name: arka_pagina_id_pagina_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_pagina_id_pagina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_pagina_id_pagina_seq OWNER TO arka_frame;

--
-- TOC entry 3353 (class 0 OID 0)
-- Dependencies: 310
-- Name: arka_pagina_id_pagina_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_pagina_id_pagina_seq OWNED BY arka_pagina.id_pagina;


--
-- TOC entry 311 (class 1259 OID 17563)
-- Name: arka_subsistema; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_subsistema (
    id_subsistema integer NOT NULL,
    nombre character varying(250) NOT NULL,
    etiqueta character varying(100) NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    observacion text
);


ALTER TABLE public.arka_subsistema OWNER TO arka_frame;

--
-- TOC entry 312 (class 1259 OID 17570)
-- Name: arka_subsistema_id_subsistema_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_subsistema_id_subsistema_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_subsistema_id_subsistema_seq OWNER TO arka_frame;

--
-- TOC entry 3354 (class 0 OID 0)
-- Dependencies: 312
-- Name: arka_subsistema_id_subsistema_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_subsistema_id_subsistema_seq OWNED BY arka_subsistema.id_subsistema;


--
-- TOC entry 313 (class 1259 OID 17572)
-- Name: arka_tempformulario; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_tempformulario (
    id_sesion character(32) NOT NULL,
    formulario character(100) NOT NULL,
    campo character(100) NOT NULL,
    valor text NOT NULL,
    fecha character(50) NOT NULL
);


ALTER TABLE public.arka_tempformulario OWNER TO arka_frame;

--
-- TOC entry 314 (class 1259 OID 17578)
-- Name: arka_usuario; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_usuario (
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


ALTER TABLE public.arka_usuario OWNER TO arka_frame;

--
-- TOC entry 315 (class 1259 OID 17593)
-- Name: arka_usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: arka_frame
--

CREATE SEQUENCE arka_usuario_id_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arka_usuario_id_usuario_seq OWNER TO arka_frame;

--
-- TOC entry 3355 (class 0 OID 0)
-- Dependencies: 315
-- Name: arka_usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: arka_frame
--

ALTER SEQUENCE arka_usuario_id_usuario_seq OWNED BY arka_usuario.id_usuario;


--
-- TOC entry 316 (class 1259 OID 17595)
-- Name: arka_usuario_subsistema; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_usuario_subsistema (
    id_usuario integer DEFAULT 0 NOT NULL,
    id_subsistema integer DEFAULT 0 NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.arka_usuario_subsistema OWNER TO arka_frame;

--
-- TOC entry 317 (class 1259 OID 17601)
-- Name: arka_valor_sesion; Type: TABLE; Schema: public; Owner: arka_frame; Tablespace: 
--

CREATE TABLE arka_valor_sesion (
    sesionid character(32) NOT NULL,
    variable character(20) NOT NULL,
    valor character(255) NOT NULL,
    expiracion bigint DEFAULT 0 NOT NULL
);


ALTER TABLE public.arka_valor_sesion OWNER TO arka_frame;

--
-- TOC entry 3168 (class 2604 OID 17667)
-- Name: id_bloque; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_bloque ALTER COLUMN id_bloque SET DEFAULT nextval('arka_bloque_id_bloque_seq'::regclass);


--
-- TOC entry 3172 (class 2604 OID 17668)
-- Name: idrelacion; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_bloque_pagina ALTER COLUMN idrelacion SET DEFAULT nextval('arka_bloque_pagina_idrelacion_seq'::regclass);


--
-- TOC entry 3173 (class 2604 OID 17669)
-- Name: id_parametro; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_configuracion ALTER COLUMN id_parametro SET DEFAULT nextval('arka_configuracion_id_parametro_seq'::regclass);


--
-- TOC entry 3174 (class 2604 OID 17670)
-- Name: idconexion; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_dbms ALTER COLUMN idconexion SET DEFAULT nextval('arka_dbms_idconexion_seq'::regclass);


--
-- TOC entry 3176 (class 2604 OID 17671)
-- Name: id; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_logger ALTER COLUMN id SET DEFAULT nextval('arka_logger_id_seq'::regclass);


--
-- TOC entry 3181 (class 2604 OID 17672)
-- Name: id_pagina; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_pagina ALTER COLUMN id_pagina SET DEFAULT nextval('arka_pagina_id_pagina_seq'::regclass);


--
-- TOC entry 3183 (class 2604 OID 17673)
-- Name: id_subsistema; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_subsistema ALTER COLUMN id_subsistema SET DEFAULT nextval('arka_subsistema_id_subsistema_seq'::regclass);


--
-- TOC entry 3193 (class 2604 OID 17674)
-- Name: id_usuario; Type: DEFAULT; Schema: public; Owner: arka_frame
--

ALTER TABLE ONLY arka_usuario ALTER COLUMN id_usuario SET DEFAULT nextval('arka_usuario_id_usuario_seq'::regclass);


--
-- TOC entry 3322 (class 0 OID 17509)
-- Dependencies: 298
-- Data for Name: arka_bloque; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-1, 'menuLateral                                       ', 'Menú lateral módulo de desarrollo.                                                                                                                                                                                                                             ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-2, 'pie                                               ', 'Pie de página módulo de desarrollo.                                                                                                                                                                                                                            ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-3, 'banner                                            ', 'Banner módulo de desarrollo.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-4, 'cruder                                            ', 'Módulo para crear módulos CRUD.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-5, 'desenlace                                         ', 'Módulo de gestión de desenlace.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-6, 'registro                                          ', 'Módulo para registrar páginas o módulos.                                                                                                                                                                                                                       ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-7, 'constructor                                       ', 'Módulo para diseñar páginas.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-8, 'contenidoCentral                                  ', 'Contenido página principal de desarrollo.                                                                                                                                                                                                                      ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (-9, 'codificador                                       ', 'Módulo para decodificar cadenas.                                                                                                                                                                                                                               ', 'development                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (1, 'loginArka                                         ', 'Login Principal                                                                                                                                                                                                                                                ', 'registro                                                                                                                                                                                                ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (2, 'pie                                               ', 'Pie de pagina                                                                                                                                                                                                                                                  ', 'gui                                                                                                                                                                                                     ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (3, 'menu                                              ', 'menu sistema Arka                                                                                                                                                                                                                                              ', 'gui                                                                                                                                                                                                     ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (4, 'registrarOrdenCompra                              ', 'Bloque que permite la gestion de Compras                                                                                                                                                                                                                       ', 'inventarios/gestionCompras                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (5, 'consultaOrdenCompra                               ', 'Bloque que permite la gestion  de consulta y modificación de las Ordenes de  Compras                                                                                                                                                                           ', 'inventarios/gestionCompras                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (7, 'registrarOrdenServicios                           ', 'Bloque que permite el registro de  Ordenes de  Servicios                                                                                                                                                                                                       ', 'inventarios/gestionCompras                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (8, 'consultaOrdenServicios                            ', 'Bloque que permite el Consulta y Modificación de  Ordenes de  Servicios                                                                                                                                                                                        ', 'inventarios/gestionCompras                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (10, 'registrarActa                                     ', 'Bloque para registrar acta recibido del bien                                                                                                                                                                                                                   ', 'inventarios/gestionActa                                                                                                                                                                                 ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (11, 'registrarEntradas                                 ', 'Bloque que permite el registro de la Entrada                                                                                                                                                                                                                   ', 'inventarios/gestionEntradas                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (12, 'consultaEntradas                                  ', 'Bloque que permite el registro de la Entrada                                                                                                                                                                                                                   ', 'inventarios/gestionEntradas                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (13, 'modificarEntradas                                 ', 'Bloque que permite el registro de la Entrada                                                                                                                                                                                                                   ', 'inventarios/gestionEntradas                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (14, 'catalogo                                          ', 'Bloque para gestionar catalogos                                                                                                                                                                                                                                ', 'inventarios                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (15, 'consultarActa                                     ', 'Bloque para consultar y modificar registros de acta                                                                                                                                                                                                            ', 'inventarios/gestionActa                                                                                                                                                                                 ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (16, 'radicarAsignar                                    ', 'Bloque para gestionar radicados                                                                                                                                                                                                                                ', 'inventarios                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (19, 'modificarSalidas                                  ', 'Bloque que permite el Modificar de Salidas del Almacen                                                                                                                                                                                                         ', 'inventarios/gestionSalidas                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (21, 'registrarElemento                                 ', 'bloque que permite la carga de elementos                                                                                                                                                                                                                       ', 'inventarios/gestionElementos                                                                                                                                                                            ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (18, 'registrarSalidas                                  ', 'Bloque que permite el registro de Salidas del Almacen                                                                                                                                                                                                          ', 'inventarios/gestionSalidas                                                                                                                                                                              ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (20, 'reportico                                         ', 'Bloque para gestionar reportes                                                                                                                                                                                                                                 ', 'inventarios                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (22, 'modificarElemento                                 ', 'bloque que permite consulta y modificacion de elementos                                                                                                                                                                                                        ', 'inventarios/gestionElementos                                                                                                                                                                            ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (23, 'asignarInventario                                 ', 'bloque para asignar inventarios                                                                                                                                                                                                                                ', 'inventarios/asignarInventarioC                                                                                                                                                                          ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (24, 'descargarInventario                               ', 'bloque para dar paso al paz y salvo                                                                                                                                                                                                                            ', 'inventarios/asignarInventarioC                                                                                                                                                                          ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (25, 'radicarEntradaSalida                              ', 'bloque para gestionar entrada  y salida de elementos                                                                                                                                                                                                           ', 'inventarios                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (6, 'gestionContrato                                   ', 'Bloque para subida de contratos para compras                                                                                                                                                                                                                   ', 'inventarios                                                                                                                                                                                             ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (26, 'consultarAsignacion                               ', 'bloque para modificar los elementos de un contratista                                                                                                                                                                                                          ', 'inventarios/asignarInventarioC                                                                                                                                                                          ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (27, 'bannerUsuario                                     ', 'bloque para mostrar el banner del usuario                                                                                                                                                                                                                      ', 'gui                                                                                                                                                                                                     ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (28, 'generarPazSalvo                                   ', 'bloque para generar el paz y salvo del contratista                                                                                                                                                                                                             ', 'inventarios/asignarInventarioC                                                                                                                                                                          ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (29, 'registrarDepreciacion                             ', 'Bloque para gestión la depreciación de elemento                                                                                                                                                                                                                ', 'inventarios/gestionDepreciacion                                                                                                                                                                         ');
INSERT INTO arka_bloque (id_bloque, nombre, descripcion, grupo) VALUES (30, 'modificarDepreciacion                             ', 'bloque para modificar la depreciacion generada                                                                                                                                                                                                                 ', 'inventarios/gestionDepreciacion                                                                                                                                                                         ');


--
-- TOC entry 3356 (class 0 OID 0)
-- Dependencies: 299
-- Name: arka_bloque_id_bloque_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_bloque_id_bloque_seq', 12, true);


--
-- TOC entry 3324 (class 0 OID 17518)
-- Dependencies: 300
-- Data for Name: arka_bloque_pagina; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (1, -1, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (2, -1, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (4, -1, -8, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (5, -2, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (6, -2, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (8, -2, -4, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (9, -3, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (10, -3, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (12, -3, -5, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (13, -4, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (14, -4, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (16, -4, -9, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (17, -5, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (18, -5, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (20, -5, -6, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (21, -6, -1, 'B', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (22, -6, -2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (24, -6, -7, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (25, 1, 1, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (26, 2, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (27, 3, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (28, 4, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (31, 5, 4, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (32, 5, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (35, 6, 6, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (34, 6, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (38, 7, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (37, 7, 5, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (40, 8, 7, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (41, 8, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (43, 9, 8, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (44, 9, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (45, 10, 10, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (47, 10, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (48, 11, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (49, 11, 11, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (51, 12, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (52, 12, 12, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (55, 14, 14, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (56, 15, 15, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (58, 15, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (59, 13, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (61, 13, 13, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (62, 16, 16, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (64, 16, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (68, 18, 18, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (69, 18, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (71, 19, 19, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (72, 19, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (74, 20, 20, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (75, 20, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (78, 21, 21, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (79, 21, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (81, 22, 22, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (82, 22, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (83, 23, 23, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (84, 23, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (86, 24, 24, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (88, 24, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (89, 25, 25, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (90, 25, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (93, 26, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (94, 26, 26, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (98, 28, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (99, 28, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (97, 28, 28, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (100, 28, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (101, 29, 29, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (29, 2, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (102, 29, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (103, 29, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (104, 29, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (92, 26, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (30, 5, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (33, 6, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (36, 7, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (39, 8, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (42, 9, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (46, 10, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (91, 25, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (87, 24, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (105, 30, 30, 'C', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (85, 23, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (80, 22, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (77, 21, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (106, 30, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (50, 11, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (76, 20, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (53, 12, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (107, 30, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (57, 15, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (73, 19, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (70, 18, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (60, 13, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (63, 16, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (108, 30, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (54, 14, 3, 'A', 2);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (109, 14, 2, 'E', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (110, 14, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (96, 26, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (95, 2, 27, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (23, -6, -3, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (7, -2, -3, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (3, -1, -3, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (19, -5, -3, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (15, -4, -3, 'A', 1);
INSERT INTO arka_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) VALUES (11, -3, -3, 'A', 1);


--
-- TOC entry 3357 (class 0 OID 0)
-- Dependencies: 301
-- Name: arka_bloque_pagina_idrelacion_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_bloque_pagina_idrelacion_seq', 27, true);


--
-- TOC entry 3326 (class 0 OID 17526)
-- Dependencies: 302
-- Data for Name: arka_configuracion; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (1, 'dbesquema                                                                                                                                                                                                                                                      ', 'public                                                                                                                                                                                                                                                         ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (3, 'nombreAplicativo                                                                                                                                                                                                                                               ', 'Sistema Gestión Almacén y Inventarios                                                                                                                                                                                                                          ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (4, 'raizDocumento                                                                                                                                                                                                                                                  ', '/usr/local/apache/htdocs/arka                                                                                                                                                                                                                                  ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (6, 'site                                                                                                                                                                                                                                                           ', '/arka                                                                                                                                                                                                                                                          ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (7, 'nombreAdministrador                                                                                                                                                                                                                                            ', 'administrador                                                                                                                                                                                                                                                  ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (8, 'claveAdministrador                                                                                                                                                                                                                                             ', 'W52QhoIjYQEOoG8kLhZrJEOEHriupwYsVc4VtHFzr9U=                                                                                                                                                                                                                   ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (9, 'correoAdministrador                                                                                                                                                                                                                                            ', 'as@udistral.edu.co                                                                                                                                                                                                                                             ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (10, 'enlace                                                                                                                                                                                                                                                         ', 'data                                                                                                                                                                                                                                                           ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (12, 'moduloDesarrollo                                                                                                                                                                                                                                               ', 'moduloDesarrollo                                                                                                                                                                                                                                               ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (13, 'googlemaps                                                                                                                                                                                                                                                     ', '                                                                                                                                                                                                                                                               ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (14, 'recatchapublica                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (15, 'recatchaprivada                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (2, 'prefijo                                                                                                                                                                                                                                                        ', 'arka_                                                                                                                                                                                                                                                          ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (17, 'instalado                                                                                                                                                                                                                                                      ', 'true                                                                                                                                                                                                                                                           ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (18, 'debugMode                                                                                                                                                                                                                                                      ', 'false                                                                                                                                                                                                                                                          ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (19, 'dbPrincipal                                                                                                                                                                                                                                                    ', 'arka                                                                                                                                                                                                                                                           ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (11, 'estiloPredeterminado                                                                                                                                                                                                                                           ', 'smoothness                                                                                                                                                                                                                                                     ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (5, 'host                                                                                                                                                                                                                                                           ', 'http://10.20.2.28                                                                                                                                                                                                                                              ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (16, 'expiracion                                                                                                                                                                                                                                                     ', '666666                                                                                                                                                                                                                                                         ');
INSERT INTO arka_configuracion (id_parametro, parametro, valor) VALUES (20, 'hostSeguro                                                                                                                                                                                                                                                     ', 'https://10.20.2.28                                                                                                                                                                                                                                             ');


--
-- TOC entry 3358 (class 0 OID 0)
-- Dependencies: 303
-- Name: arka_configuracion_id_parametro_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_configuracion_id_parametro_seq', 20, true);


--
-- TOC entry 3328 (class 0 OID 17534)
-- Dependencies: 304
-- Data for Name: arka_dbms; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (2, 'inventarios', 'pgsql', '10.20.0.38', 5432, '', 'arka', 'arka_inventarios', 'arka_inventarios', '5Tr58Y37FXOua8IlDFXwhDGh7BNSZzmO2AExESe9WvQ=');
INSERT INTO arka_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (3, 'catalogo', 'pgsql', '10.20.0.38', 5432, '', 'arka', 'catalogo', 'catalogodba', 'aaV5SrrvccZMAOUNiGpsFJzMF_-NkANsQo_jBzrfHWM');
INSERT INTO arka_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) VALUES (1, 'estructura', 'pgsql', '10.20.2.28', 5432, '', 'arka', 'public', 'postgres', '2dCCtrbKw8rYq7Y-I55uwPo0pMtzWm_kq-imaVYAxo0');


--
-- TOC entry 3359 (class 0 OID 0)
-- Dependencies: 305
-- Name: arka_dbms_idconexion_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_dbms_idconexion_seq', 4, true);


--
-- TOC entry 3330 (class 0 OID 17542)
-- Dependencies: 306
-- Data for Name: arka_estilo; Type: TABLE DATA; Schema: public; Owner: arka_frame
--



--
-- TOC entry 3331 (class 0 OID 17546)
-- Dependencies: 307
-- Data for Name: arka_logger; Type: TABLE DATA; Schema: public; Owner: arka_frame
--



--
-- TOC entry 3360 (class 0 OID 0)
-- Dependencies: 308
-- Name: arka_logger_id_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_logger_id_seq', 1, false);


--
-- TOC entry 3333 (class 0 OID 17551)
-- Dependencies: 309
-- Data for Name: arka_pagina; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-1, 'development                                       ', 'Index módulo de desarrollo.                                                                                                                                                                                                                               ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-2, 'cruder                                            ', 'Generador módulos CRUD.                                                                                                                                                                                                                                   ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-3, 'desenlace                                         ', 'Analizar enlaces.                                                                                                                                                                                                                                         ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-4, 'codificador                                       ', 'Codificar/decodificar cadenas.                                                                                                                                                                                                                            ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-5, 'registro                                          ', 'Registrar páginas o módulos.                                                                                                                                                                                                                              ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (-6, 'constructor                                       ', 'Diseñar páginas.                                                                                                                                                                                                                                          ', 'development                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (1, 'index                                             ', 'Pagina Principal                                                                                                                                                                                                                                          ', 'general                                           ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (2, 'indexAlmacen                                      ', 'Pagina principal almacen                                                                                                                                                                                                                                  ', 'almacen                                           ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (3, 'indexInventarios                                  ', 'Pagina principal inventarios                                                                                                                                                                                                                              ', 'inventarios                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (4, 'indexContabilidad                                 ', 'Pagina principal contabilidad                                                                                                                                                                                                                             ', 'contabilidad                                      ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (5, 'registrarOrdenCompra                              ', 'Pagni que permite el registro de orden de Compra                                                                                                                                                                                                          ', 'gestión Compras                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (6, 'gestionContrato                                   ', 'Pagina para gestionar contratos                                                                                                                                                                                                                           ', 'inventarios                                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (7, 'consultaOrdenCompra                               ', 'Pagina que permite la Consulta y Modificación de orden de Compra                                                                                                                                                                                          ', 'gestión Compras                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (8, 'registrarOrdenServicios                           ', 'Pagina que permite el registro  de orden de Servicios                                                                                                                                                                                                     ', 'gestión Compras                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (9, 'consultaOrdenServicios                            ', 'Pagina que permite el consulta y modificacion  de orden de Servicios                                                                                                                                                                                      ', 'gestión Compras                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (10, 'registrarActa                                     ', 'Pagina para registrar acta de recibido del bien                                                                                                                                                                                                           ', 'gestión Acta                                      ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (11, 'registrarEntradas                                 ', 'Pagina que permite el registro de Entradas                                                                                                                                                                                                                ', 'gestión Entradas                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (12, 'consultaEntradas                                  ', 'Pagina que permite el consultar y asiganar el estado  de Entradas                                                                                                                                                                                         ', 'gestión Entradas                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (13, 'modificarEntradas                                 ', 'Pagina que permite el modificar las Entradas                                                                                                                                                                                                              ', 'gestión Entradas                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (14, 'catalogo                                          ', 'Pagina de gestion de catalogos                                                                                                                                                                                                                            ', 'gestión catalogo                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (15, 'consultarActa                                     ', 'Pagina para gestionarl registros de acta de recibido                                                                                                                                                                                                      ', 'gestiòn Acta                                      ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (16, 'radicarAsignar                                    ', 'Pagina para gestionar radicados                                                                                                                                                                                                                           ', 'gestion radicacion                                ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (18, 'registrarSalidas                                  ', 'Pagina que permite el registro de salidas                                                                                                                                                                                                                 ', 'gestión Salidas                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (19, 'modificarSalidas                                  ', 'Pagina que permite el Consulta y Modificar Salidas                                                                                                                                                                                                        ', 'gestión Salidas                                   ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (20, 'reportico                                         ', 'Pagina para gestionar reportes                                                                                                                                                                                                                            ', 'gestión reportes                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (21, 'registrarElemento                                 ', 'Pagina que permite el registro de elementos                                                                                                                                                                                                               ', 'gestion Elementos                                 ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (22, 'modificarElemento                                 ', 'Pagina que permite el consulta y modificación de elementos                                                                                                                                                                                                ', 'gestion Elementos                                 ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (23, 'asignarInventarioC                                ', 'Pagina para asignar inventarios                                                                                                                                                                                                                           ', 'gestion asignar inventarios                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (25, 'radicarEntradaSalida                              ', 'Pagina para gestionar la radcacion de entrada y salida de elementos                                                                                                                                                                                       ', 'gestión radicación                                ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (24, 'descargarInventario                               ', 'Pagina para dar paso al paz y salvo al eliminar elementos asignados                                                                                                                                                                                       ', 'gestión asignar inventarios                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (26, 'consultarAsignacion                               ', 'Pagina para modificar los elementos asignados a un contratista                                                                                                                                                                                            ', 'gestión asignar inventarios                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (28, 'generarPazSalvo                                   ', 'Pagina para generar el paz y salvo del contratista respecto a elementos                                                                                                                                                                                   ', 'gestión asignar inventarios                       ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (29, 'registrarDepreciacion                             ', 'Pagina para gestionar la depreciacion de los elementos                                                                                                                                                                                                    ', 'gestión depreciación                              ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO arka_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) VALUES (30, 'modificarDepreciacion                             ', 'Pagina para modificar la depreciacion generada                                                                                                                                                                                                            ', 'gestión depreciación                              ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');


--
-- TOC entry 3361 (class 0 OID 0)
-- Dependencies: 310
-- Name: arka_pagina_id_pagina_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_pagina_id_pagina_seq', 1, false);


--
-- TOC entry 3335 (class 0 OID 17563)
-- Dependencies: 311
-- Data for Name: arka_subsistema; Type: TABLE DATA; Schema: public; Owner: arka_frame
--



--
-- TOC entry 3362 (class 0 OID 0)
-- Dependencies: 312
-- Name: arka_subsistema_id_subsistema_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_subsistema_id_subsistema_seq', 1, false);


--
-- TOC entry 3337 (class 0 OID 17572)
-- Dependencies: 313
-- Data for Name: arka_tempformulario; Type: TABLE DATA; Schema: public; Owner: arka_frame
--



--
-- TOC entry 3338 (class 0 OID 17578)
-- Dependencies: 314
-- Data for Name: arka_usuario; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_usuario (id_usuario, nombre, apellido, correo, telefono, imagen, clave, tipo, estilo, idioma, estado) VALUES (1100000, 'Almacen', 'Pruebas', 'esanchez1988@gmail.com', '3018946', '                                                                                                                                                                                                                                                               ', 'eab41e38426312cf48baaaf80af9ee88b6023a44', '1', 'basico', 'es_es', 1);
INSERT INTO arka_usuario (id_usuario, nombre, apellido, correo, telefono, imagen, clave, tipo, estilo, idioma, estado) VALUES (1100001, 'Inventarios', 'Pruebas', 'esanchez1988@gmail.com', '3018946', '                                                                                                                                                                                                                                                               ', 'eab41e38426312cf48baaaf80af9ee88b6023a44', '', 'basico', 'es_es', 1);
INSERT INTO arka_usuario (id_usuario, nombre, apellido, correo, telefono, imagen, clave, tipo, estilo, idioma, estado) VALUES (1100002, 'Contabilidad', 'Pruebas', 'esanchez1988@gmail.com', '3018946', '                                                                                                                                                                                                                                                               ', 'eab41e38426312cf48baaaf80af9ee88b6023a44', '', 'basico', 'es_es', 1);


--
-- TOC entry 3363 (class 0 OID 0)
-- Dependencies: 315
-- Name: arka_usuario_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: arka_frame
--

SELECT pg_catalog.setval('arka_usuario_id_usuario_seq', 1, true);


--
-- TOC entry 3340 (class 0 OID 17595)
-- Dependencies: 316
-- Data for Name: arka_usuario_subsistema; Type: TABLE DATA; Schema: public; Owner: arka_frame
--



--
-- TOC entry 3341 (class 0 OID 17601)
-- Dependencies: 317
-- Data for Name: arka_valor_sesion; Type: TABLE DATA; Schema: public; Owner: arka_frame
--

INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('e51b7ec37930f42cfc9caebd3e708151', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1463507753);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('aa134f681d97e44f0ca8b771c2932ca4', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1463595159);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('b37c0018e0ccf5345ecf556dece50297', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1463595509);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('3173bc23d4b46f487f8b203483ea32a8', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1463595509);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('929082c88bedb2db64f2d3ab23366dfb', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1463774192);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('0460415b9adcf41a38ed1efa268e229b', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1464109146);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('048e1d95fbf4a98a90fd76e3abbf9a96', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1464200639);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('585070d79285ab710d03bbd5c5a1001a', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1464450709);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('c2d88de04fecbb227bfd0f2faecf5073', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1464531349);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('d91351d46783c442df5733d7b6586fdc', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1464881959);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('36c1f1018d38d680a90afc9899e19b03', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465311299);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('e583f6d70ca93031c7622a2758c300d6', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465414590);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('6319d106b056999d9b9b85be0a45055f', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465414763);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('edfc1f7d4dccf95a407c23fe6805fe97', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465415776);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('2b55274dbc2ea73734427b09ba5ef6a8', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465497945);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('6e0e987f61e0bef4bcbbcc9251835d89', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465857878);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('664b1b0e2e7d22dd76927e0f42bbc75a', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1465929742);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('15b8fb8a938f334f1058c1b1a34a6bd0', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1466285169);
INSERT INTO arka_valor_sesion (sesionid, variable, valor, expiracion) VALUES ('65d301a0a3b3f6bf302c694f901e1e16', 'idUsuario           ', '1100000                                                                                                                                                                                                                                                        ', 1466393209);


--
-- TOC entry 3201 (class 2606 OID 17807)
-- Name: arka_bloque_pagina_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_bloque_pagina
    ADD CONSTRAINT arka_bloque_pagina_pkey PRIMARY KEY (idrelacion);


--
-- TOC entry 3199 (class 2606 OID 17809)
-- Name: arka_bloque_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_bloque
    ADD CONSTRAINT arka_bloque_pkey PRIMARY KEY (id_bloque);


--
-- TOC entry 3203 (class 2606 OID 17811)
-- Name: arka_configuracion_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_configuracion
    ADD CONSTRAINT arka_configuracion_pkey PRIMARY KEY (id_parametro);


--
-- TOC entry 3205 (class 2606 OID 17813)
-- Name: arka_dbms_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_dbms
    ADD CONSTRAINT arka_dbms_pkey PRIMARY KEY (idconexion);


--
-- TOC entry 3207 (class 2606 OID 17815)
-- Name: arka_estilo_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_estilo
    ADD CONSTRAINT arka_estilo_pkey PRIMARY KEY (usuario, estilo);


--
-- TOC entry 3209 (class 2606 OID 17817)
-- Name: arka_pagina_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_pagina
    ADD CONSTRAINT arka_pagina_pkey PRIMARY KEY (id_pagina);


--
-- TOC entry 3211 (class 2606 OID 17819)
-- Name: arka_subsistema_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_subsistema
    ADD CONSTRAINT arka_subsistema_pkey PRIMARY KEY (id_subsistema);


--
-- TOC entry 3213 (class 2606 OID 17821)
-- Name: arka_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_usuario
    ADD CONSTRAINT arka_usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 3215 (class 2606 OID 17823)
-- Name: arka_valor_sesion_pkey; Type: CONSTRAINT; Schema: public; Owner: arka_frame; Tablespace: 
--

ALTER TABLE ONLY arka_valor_sesion
    ADD CONSTRAINT arka_valor_sesion_pkey PRIMARY KEY (sesionid, variable);


--
-- TOC entry 3347 (class 0 OID 0)
-- Dependencies: 9
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO arka_frame;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-03-16 12:49:09 COT

--
-- PostgreSQL database dump complete
--

