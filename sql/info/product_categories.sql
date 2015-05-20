-- CATEGORIEs of product

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.product_categories CASCADE;

CREATE TABLE info.product_categories (
        id smallserial NOT NULL,
        code character varying(100) NOT NULL,

        name character varying(100) NOT NULL,
        name_en character varying(100) NOT NULL,

        parent integer NOT NULL DEFAULT 0,
	level smallint NOT NULL DEFAULT 0,
	sort smallint NOT NULL DEFAULT 0,
	total_child integer NOT NULL DEFAULT 0,

        property_table character varying(25),

        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT product_categories_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_product_categories_name_name_en
	ON info.product_categories USING btree (name, name_en);

CREATE INDEX idx_product_categories_parent
	ON info.product_categories USING btree (parent);

CREATE INDEX idx_product_categories_enable
	ON info.product_categories USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_product_categories__version
	ON info.product_categories USING btree (_version DESC NULLS LAST);

INSERT INTO info.product_categories (code, name, name_en, property_table)
    VALUES ('forklifts', 'Forklift', 'Forklift', 'info.product_categories');