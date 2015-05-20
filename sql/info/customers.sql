-- CUSTOMERs

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.customers CASCADE;

CREATE TABLE info.customers (
        id serial NOT NULL,
        name character varying(100) NOT NULL,
        name_en character varying(100) NOT NULL,

        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT customers_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_customers_name_name_en
	ON info.customers USING btree (name, name_en);

CREATE INDEX idx_customers_enable
	ON info.customers USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_customers__version
	ON info.customers USING btree (_version DESC NULLS LAST);

INSERT INTO info.customers (name, name_en)
    VALUES ('ที.ซี. ฟาร์มาซูติคอลอุตสาหกรรม', 'T.C. Pharmaceutical industries company limited');