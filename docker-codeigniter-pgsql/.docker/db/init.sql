-- Table: public.post

-- DROP TABLE IF EXISTS public.post;

CREATE DATABASE db_posty
    WITH
    OWNER = root
    ENCODING = 'UTF8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

GRANT ALL PRIVILEGES ON DATABASE db_posty TO root;