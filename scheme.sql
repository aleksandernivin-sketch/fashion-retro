--
-- PostgreSQL database dump
--

\restrict vowrgsSBZPUpKuaoRfmeMhEttEeKjEPOhmmeAZPeg9WyieieLfKVfptKfkrd1Lc

-- Dumped from database version 18.4 (Debian 18.4-1.pgdg13+1)
-- Dumped by pg_dump version 18.4 (Debian 18.4-1.pgdg13+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: nivin
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO nivin;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: nivin
--

COMMENT ON SCHEMA public IS '';


--
-- Name: схема ДБ nws; Type: SCHEMA; Schema: -; Owner: nivin
--

CREATE SCHEMA "схема ДБ nws";


ALTER SCHEMA "схема ДБ nws" OWNER TO nivin;

--
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: article_hub; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.article_hub (
    article_id integer NOT NULL,
    hub_id integer NOT NULL
);


ALTER TABLE public.article_hub OWNER TO nivin;

--
-- Name: article_stats; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.article_stats (
    article_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    views_total integer DEFAULT 0,
    downloads_count integer DEFAULT 0,
    is_active boolean DEFAULT true,
    sort_order integer DEFAULT 0,
    author_id integer DEFAULT 1,
    views_24h integer DEFAULT 0,
    last_viewed timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.article_stats OWNER TO nivin;

--
-- Name: COLUMN article_stats.last_viewed; Type: COMMENT; Schema: public; Owner: nivin
--

COMMENT ON COLUMN public.article_stats.last_viewed IS 'Время последнего просмотра статьи';


--
-- Name: article_tag; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.article_tag (
    article_id integer NOT NULL,
    tag_id integer NOT NULL
);


ALTER TABLE public.article_tag OWNER TO nivin;

--
-- Name: article_translations; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.article_translations (
    id integer NOT NULL,
    article_id integer NOT NULL,
    lang character varying(2) NOT NULL,
    title character varying(512) NOT NULL,
    content text,
    seo_desc text,
    seo_intro text,
    meta_keywords text,
    meta_description text
);


ALTER TABLE public.article_translations OWNER TO nivin;

--
-- Name: article_translations_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.article_translations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.article_translations_id_seq OWNER TO nivin;

--
-- Name: article_translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.article_translations_id_seq OWNED BY public.article_translations.id;


--
-- Name: articles; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.articles (
    id integer NOT NULL,
    slug character varying(255) NOT NULL,
    is_active boolean DEFAULT true,
    meta_json jsonb DEFAULT '{}'::jsonb,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    author_id integer DEFAULT 1,
    download_count integer DEFAULT 0,
    sort_order integer DEFAULT 0,
    product_id integer
);


ALTER TABLE public.articles OWNER TO nivin;

--
-- Name: articles_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.articles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.articles_id_seq OWNER TO nivin;

--
-- Name: articles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.articles_id_seq OWNED BY public.articles.id;


--
-- Name: authors; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.authors (
    id integer NOT NULL,
    author_name character varying(255) NOT NULL,
    author_avatar character varying(255),
    author_about text
);


ALTER TABLE public.authors OWNER TO nivin;

--
-- Name: authors_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.authors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.authors_id_seq OWNER TO nivin;

--
-- Name: authors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.authors_id_seq OWNED BY public.authors.id;


--
-- Name: hub_translations; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.hub_translations (
    id integer NOT NULL,
    hub_id integer,
    lang character varying(2) NOT NULL,
    title character varying(255) NOT NULL,
    h1 character varying(255),
    description text,
    keywords text,
    content_top text,
    content_bottom text
);


ALTER TABLE public.hub_translations OWNER TO nivin;

--
-- Name: hub_translations_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.hub_translations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hub_translations_id_seq OWNER TO nivin;

--
-- Name: hub_translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.hub_translations_id_seq OWNED BY public.hub_translations.id;


--
-- Name: hub_unit_relations; Type: VIEW; Schema: public; Owner: nivin
--

CREATE VIEW public.hub_unit_relations AS
 SELECT hub_id,
    article_id AS unit_id
   FROM public.article_hub;


ALTER VIEW public.hub_unit_relations OWNER TO nivin;

--
-- Name: hubs; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.hubs (
    id integer NOT NULL,
    slug character varying(255) NOT NULL,
    type character varying(50) DEFAULT 'category'::character varying,
    is_active boolean DEFAULT true,
    hub_order integer DEFAULT 0,
    parent_id integer,
    is_pillar boolean DEFAULT false
);


ALTER TABLE public.hubs OWNER TO nivin;

--
-- Name: hubs_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.hubs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hubs_id_seq OWNER TO nivin;

--
-- Name: hubs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.hubs_id_seq OWNED BY public.hubs.id;


--
-- Name: orders; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.orders (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    user_id integer NOT NULL,
    product_id integer NOT NULL,
    amount numeric(10,2) NOT NULL,
    currency character(3) DEFAULT 'EUR'::bpchar,
    payment_status character varying(20) DEFAULT 'pending'::character varying,
    payment_system character varying(50),
    download_token uuid DEFAULT gen_random_uuid(),
    download_count integer DEFAULT 0,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    paid_at timestamp with time zone
);


ALTER TABLE public.orders OWNER TO nivin;

--
-- Name: product_translations; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.product_translations (
    id integer NOT NULL,
    product_id integer NOT NULL,
    lang character varying(2) NOT NULL,
    title character varying(512) NOT NULL,
    short_description text,
    content text,
    meta_title character varying(512),
    meta_description text,
    meta_keywords text
);


ALTER TABLE public.product_translations OWNER TO nivin;

--
-- Name: product_translations_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.product_translations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_translations_id_seq OWNER TO nivin;

--
-- Name: product_translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.product_translations_id_seq OWNED BY public.product_translations.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.products (
    id integer NOT NULL,
    slug character varying(255) NOT NULL,
    status integer DEFAULT 0,
    base_price numeric(10,2) DEFAULT 0.00,
    product_json jsonb DEFAULT '{}'::jsonb,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.products OWNER TO nivin;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO nivin;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- Name: tag_translations; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.tag_translations (
    id integer NOT NULL,
    tag_id integer,
    lang character varying(5) NOT NULL,
    title character varying(255) NOT NULL
);


ALTER TABLE public.tag_translations OWNER TO nivin;

--
-- Name: tag_translations_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.tag_translations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tag_translations_id_seq OWNER TO nivin;

--
-- Name: tag_translations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.tag_translations_id_seq OWNED BY public.tag_translations.id;


--
-- Name: tags; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.tags (
    id integer NOT NULL,
    slug character varying(100) NOT NULL,
    is_system boolean DEFAULT false,
    tag_order integer DEFAULT 0,
    lang character varying(2) DEFAULT 'ua'::character varying NOT NULL,
    title character varying(255)
);


ALTER TABLE public.tags OWNER TO nivin;

--
-- Name: tags_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.tags_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tags_id_seq OWNER TO nivin;

--
-- Name: tags_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.tags_id_seq OWNED BY public.tags.id;


--
-- Name: units; Type: VIEW; Schema: public; Owner: nivin
--

CREATE VIEW public.units AS
 SELECT a.id,
    a.id AS unit_id,
    a.slug,
    a.slug AS unit_slug,
    a.is_active,
    ((a.meta_json ->> 'parent_id'::text))::integer AS parent_id,
    t.title,
    t.title AS unit_name,
    t.title AS seo_title
   FROM (public.articles a
     LEFT JOIN public.article_translations t ON (((a.id = t.article_id) AND ((t.lang)::text = 'ua'::text))));


ALTER VIEW public.units OWNER TO nivin;

--
-- Name: users; Type: TABLE; Schema: public; Owner: nivin
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255),
    tg_id bigint,
    password_hash text,
    full_name character varying(255),
    lang character(2) DEFAULT 'uk'::bpchar,
    is_verified boolean DEFAULT false,
    verification_code character varying(6),
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO nivin;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: nivin
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO nivin;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: nivin
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: article_translations id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_translations ALTER COLUMN id SET DEFAULT nextval('public.article_translations_id_seq'::regclass);


--
-- Name: articles id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.articles ALTER COLUMN id SET DEFAULT nextval('public.articles_id_seq'::regclass);


--
-- Name: authors id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.authors ALTER COLUMN id SET DEFAULT nextval('public.authors_id_seq'::regclass);


--
-- Name: hub_translations id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hub_translations ALTER COLUMN id SET DEFAULT nextval('public.hub_translations_id_seq'::regclass);


--
-- Name: hubs id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hubs ALTER COLUMN id SET DEFAULT nextval('public.hubs_id_seq'::regclass);


--
-- Name: product_translations id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.product_translations ALTER COLUMN id SET DEFAULT nextval('public.product_translations_id_seq'::regclass);


--
-- Name: products id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- Name: tag_translations id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tag_translations ALTER COLUMN id SET DEFAULT nextval('public.tag_translations_id_seq'::regclass);


--
-- Name: tags id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tags ALTER COLUMN id SET DEFAULT nextval('public.tags_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: article_hub article_hub_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_hub
    ADD CONSTRAINT article_hub_pkey PRIMARY KEY (article_id, hub_id);


--
-- Name: article_stats article_stats_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_stats
    ADD CONSTRAINT article_stats_pkey PRIMARY KEY (article_id);


--
-- Name: article_tag article_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_tag
    ADD CONSTRAINT article_tag_pkey PRIMARY KEY (article_id, tag_id);


--
-- Name: article_translations article_translations_article_id_lang_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_translations
    ADD CONSTRAINT article_translations_article_id_lang_key UNIQUE (article_id, lang);


--
-- Name: article_translations article_translations_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_translations
    ADD CONSTRAINT article_translations_pkey PRIMARY KEY (id);


--
-- Name: articles articles_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_pkey PRIMARY KEY (id);


--
-- Name: articles articles_slug_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.articles
    ADD CONSTRAINT articles_slug_key UNIQUE (slug);


--
-- Name: authors authors_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.authors
    ADD CONSTRAINT authors_pkey PRIMARY KEY (id);


--
-- Name: hub_translations hub_translations_hub_id_lang_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hub_translations
    ADD CONSTRAINT hub_translations_hub_id_lang_key UNIQUE (hub_id, lang);


--
-- Name: hub_translations hub_translations_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hub_translations
    ADD CONSTRAINT hub_translations_pkey PRIMARY KEY (id);


--
-- Name: hubs hubs_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hubs
    ADD CONSTRAINT hubs_pkey PRIMARY KEY (id);


--
-- Name: hubs hubs_slug_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hubs
    ADD CONSTRAINT hubs_slug_key UNIQUE (slug);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- Name: product_translations product_translations_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.product_translations
    ADD CONSTRAINT product_translations_pkey PRIMARY KEY (id);


--
-- Name: product_translations product_translations_product_id_lang_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.product_translations
    ADD CONSTRAINT product_translations_product_id_lang_key UNIQUE (product_id, lang);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: products products_slug_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_slug_key UNIQUE (slug);


--
-- Name: tag_translations tag_translations_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tag_translations
    ADD CONSTRAINT tag_translations_pkey PRIMARY KEY (id);


--
-- Name: tag_translations tag_translations_tag_id_lang_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tag_translations
    ADD CONSTRAINT tag_translations_tag_id_lang_key UNIQUE (tag_id, lang);


--
-- Name: tags tags_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id);


--
-- Name: tags tags_slug_lang_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tags
    ADD CONSTRAINT tags_slug_lang_key UNIQUE (slug, lang);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_tg_id_key; Type: CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_tg_id_key UNIQUE (tg_id);


--
-- Name: idx_articles_created_at; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_articles_created_at ON public.articles USING btree (created_at DESC);


--
-- Name: idx_orders_token; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_orders_token ON public.orders USING btree (download_token, payment_status);


--
-- Name: idx_product_translations_lang; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_product_translations_lang ON public.product_translations USING btree (lang);


--
-- Name: idx_products_slug; Type: INDEX; Schema: public; Owner: nivin
--

CREATE UNIQUE INDEX idx_products_slug ON public.products USING btree (slug);


--
-- Name: idx_stats_created_at; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_stats_created_at ON public.article_stats USING btree (created_at DESC);


--
-- Name: idx_stats_views; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_stats_views ON public.article_stats USING btree (views_total DESC);


--
-- Name: idx_users_verification; Type: INDEX; Schema: public; Owner: nivin
--

CREATE INDEX idx_users_verification ON public.users USING btree (email, verification_code);


--
-- Name: article_hub article_hub_article_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_hub
    ADD CONSTRAINT article_hub_article_id_fkey FOREIGN KEY (article_id) REFERENCES public.articles(id) ON DELETE CASCADE;


--
-- Name: article_hub article_hub_hub_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_hub
    ADD CONSTRAINT article_hub_hub_id_fkey FOREIGN KEY (hub_id) REFERENCES public.hubs(id) ON DELETE CASCADE;


--
-- Name: article_tag article_tag_tag_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_tag
    ADD CONSTRAINT article_tag_tag_id_fkey FOREIGN KEY (tag_id) REFERENCES public.tags(id) ON DELETE CASCADE;


--
-- Name: article_stats fk_article; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_stats
    ADD CONSTRAINT fk_article FOREIGN KEY (article_id) REFERENCES public.articles(id) ON DELETE CASCADE;


--
-- Name: article_translations fk_article; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.article_translations
    ADD CONSTRAINT fk_article FOREIGN KEY (article_id) REFERENCES public.articles(id) ON DELETE CASCADE;


--
-- Name: product_translations fk_product; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.product_translations
    ADD CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- Name: hub_translations hub_translations_hub_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.hub_translations
    ADD CONSTRAINT hub_translations_hub_id_fkey FOREIGN KEY (hub_id) REFERENCES public.hubs(id) ON DELETE CASCADE;


--
-- Name: orders orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: tag_translations tag_translations_tag_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: nivin
--

ALTER TABLE ONLY public.tag_translations
    ADD CONSTRAINT tag_translations_tag_id_fkey FOREIGN KEY (tag_id) REFERENCES public.tags(id) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: nivin
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- PostgreSQL database dump complete
--

\unrestrict vowrgsSBZPUpKuaoRfmeMhEttEeKjEPOhmmeAZPeg9WyieieLfKVfptKfkrd1Lc

