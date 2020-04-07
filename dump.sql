--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 11.2

-- Started on 2020-04-08 02:46:40

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- TOC entry 2888 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 198 (class 1255 OID 84003)
-- Name: upd_timestamp(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE OR REPLACE FUNCTION public.upd_timestamp() RETURNS trigger
    LANGUAGE plpgsql
    AS $$

BEGIN

    NEW.date_update = CURRENT_TIMESTAMP;

    RETURN NEW;

END;

$$;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 197 (class 1259 OID 83990)
-- Name: clients; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    login character varying(50) NOT NULL,
    password character varying(32),
    email character varying(50),
    name character varying,
    surname character varying,
    phone character varying,
    image character varying,
    address text,
    date_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    date_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    active boolean DEFAULT false,
    club_type integer DEFAULT 0
);


--
-- TOC entry 2889 (class 0 OID 0)
-- Dependencies: 197
-- Name: TABLE clients; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE public.clients IS 'Таблица клиентов';


--
-- TOC entry 196 (class 1259 OID 83988)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2890 (class 0 OID 0)
-- Dependencies: 196
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- TOC entry 2752 (class 2604 OID 83993)
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- TOC entry 2882 (class 0 OID 83990)
-- Dependencies: 197
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.clients VALUES (13, 'octoalex8', '098f6bcd4621d373cade4e832627b4f6', 'funyloony8@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (15, 'octoalex10', '098f6bcd4621d373cade4e832627b4f6', 'funyloony10@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (14, 'octoalex9', '098f6bcd4621d373cade4e832627b4f6', 'funyloony9@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (6, 'octoalex1', '098f6bcd4621d373cade4e832627b4f6', 'funyloony1@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (18, 'octoalex13', '098f6bcd4621d373cade4e832627b4f6', 'funyloony13@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (21, 'octoalex16', '098f6bcd4621d373cade4e832627b4f6', 'funyloony16@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (10, 'octoalex5', '098f6bcd4621d373cade4e832627b4f6', 'funyloony5@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (19, 'octoalex14', '098f6bcd4621d373cade4e832627b4f6', 'funyloony14@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (11, 'octoalex6', '098f6bcd4621d373cade4e832627b4f6', 'funyloony6@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (8, 'octoalex3', '098f6bcd4621d373cade4e832627b4f6', 'funyloony3@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (9, 'octoalex4', '098f6bcd4621d373cade4e832627b4f6', 'funyloony4@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (12, 'octoalex7', '098f6bcd4621d373cade4e832627b4f6', 'funyloony7@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (20, 'octoalex15', '098f6bcd4621d373cade4e832627b4f6', 'funyloony15@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (7, 'octoalex2', '098f6bcd4621d373cade4e832627b4f6', 'funyloony2@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (16, 'octoalex11', '098f6bcd4621d373cade4e832627b4f6', 'funyloony11@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (17, 'octoalex12', '098f6bcd4621d373cade4e832627b4f6', 'funyloony12@gmail.com', 'Alex', 'Octo', '222', '5bd651be9f61595419beef91602a1027.png', '222', '2020-04-06 20:52:32.889449', '2020-04-07 21:10:19.585233', false, 0);
INSERT INTO public.clients VALUES (1, 'octoalex', '16c75dbf8dc6239f9d74b96299404446', 'funyloony@gmail.com', 'Alex', 'Octo', '222', '0d1731bc571ba3775cbd6bdd5f451d06.jpg', '222', '2020-04-06 20:52:32.889449', '2020-04-08 01:34:12.426774', true, 1);
INSERT INTO public.clients VALUES (23, 'homyak', 'c6c210edeec5455ec52a7cf116c705ba', 'alex.str@jazztour.ru', 'Alexander', 'Streltsov', '+7(999)608-32-83', '', '58, prospekt Klykova, Kursk - 305000 (Russian Federation)', '2020-04-08 01:52:15.814189', '2020-04-08 01:52:15.814189', true, 2);


--
-- TOC entry 2891 (class 0 OID 0)
-- Dependencies: 196
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.clients_id_seq', 23, true);


--
-- TOC entry 2757 (class 1259 OID 84001)
-- Name: clients_email_uindex; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX clients_email_uindex ON public.clients USING btree (email);


--
-- TOC entry 2758 (class 1259 OID 84002)
-- Name: clients_login_uindex; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX clients_login_uindex ON public.clients USING btree (login);



DO $$
    DECLARE
        t text;
    BEGIN
        FOR t IN
            SELECT  table_name FROM information_schema.columns
            WHERE column_name = 'date_create'
            LOOP
                EXECUTE format('CREATE TRIGGER update_updatedAt_%I
                        BEFORE UPDATE ON public.%I
                        FOR EACH ROW EXECUTE PROCEDURE upd_timestamp()',
                               t,t);
            END loop;
    END;
$$ language 'plpgsql';