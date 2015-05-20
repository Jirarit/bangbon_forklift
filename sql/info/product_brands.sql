-- BRANDs of product

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.product_brands CASCADE;

CREATE TABLE info.product_brands (
        id smallserial NOT NULL,
        name character varying(100) NOT NULL,
        name_en character varying(100) NOT NULL,
        
        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT product_brands_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_product_brands_name_name_en
	ON info.product_brands USING btree (name, name_en);

CREATE INDEX idx_product_brands_enable
	ON info.product_brands USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_product_brands__version
	ON info.product_brands USING btree (_version DESC NULLS LAST);

INSERT INTO info.product_brands (name, name_en) VALUES ('CAT', 'CAT');

INSERT INTO info.product_brands (name, name_en) VALUES ('TOYOTA', 'TOYOTA');

INSERT INTO info.product_brands (name, name_en) VALUES ('COMAR', 'COMAR');