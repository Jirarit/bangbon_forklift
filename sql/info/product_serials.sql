-- PRODUCT SERIALs

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.product_serials CASCADE;

CREATE TABLE info.product_serials (
        id bigserial NOT NULL,
        product_id bigint NOT NULL,
        serial_no character varying(100) NOT NULL,

        manufacture_date date,

        attach_pic bigint[],
        attach_doc bigint[],

        status character(1) DEFAULT 'A'::bpchar, -- A=Available, R=Rent, S=Sold out, F=Fix(Repair)
        created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT product_serials_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_product_serials_product_id_serial_no
	ON info.product_serials USING btree (product_id, serial_no);

CREATE INDEX idx_product_serials_product_id
	ON info.product_serials USING btree (product_id);

CREATE INDEX idx_product_serials_serial_no
	ON info.product_serials USING btree (serial_no);

CREATE INDEX idx_product_serials_manufacture_date
	ON info.product_serials USING btree (manufacture_date);

CREATE INDEX idx_product_serials_status
	ON info.product_serials USING btree (status);