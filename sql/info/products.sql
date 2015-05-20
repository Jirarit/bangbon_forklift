-- PRODUCTs

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.products CASCADE;

CREATE TABLE info.products (
        id serial NOT NULL,
        name character varying(100) NOT NULL,
        name_en character varying(100) NOT NULL,
        description text,

        brand_id smallint,
        model character varying(100),
        category_id smallint,
        cost numeric(16,2) NOT NULL DEFAULT 0,
        price numeric(16,2) NOT NULL DEFAULT 0,

        attach_pic bigint[],
        attach_doc bigint[],

        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone NOT NULL DEFAULT now()::timestamp(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamp(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT products_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_products_name_name_en
	ON info.products USING btree (name, name_en);

CREATE INDEX idx_products_brand_id
	ON info.products USING btree (brand_id);

CREATE INDEX idx_products_model
	ON info.products USING btree (model);

CREATE INDEX idx_products_category_id
	ON info.products USING btree (category_id);

CREATE INDEX idx_products_enable
	ON info.products USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_products__version
	ON info.products USING btree (_version DESC NULLS LAST);
