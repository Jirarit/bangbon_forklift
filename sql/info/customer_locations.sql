-- CUSTOMER LOCATIONs

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.customer_locations CASCADE;

CREATE TABLE info.customer_locations (
        id serial NOT NULL,

        customer_id integer NOT NULL,
        branch_name character varying(100) NOT NULL,
        zone_name character varying(100) NOT NULL,

        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        _create_uid bigint NOT NULL DEFAULT 0,
        _update_uid bigint NOT NULL DEFAULT 0,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT customer_locations_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_customer_locations_customer_id
	ON info.customer_locations USING btree (customer_id);

CREATE INDEX idx_customer_locations_branch_name
	ON info.customer_locations USING btree (branch_name);

CREATE INDEX idx_customer_locations_zone_name
	ON info.customer_locations USING btree (zone_name);

CREATE INDEX idx_customer_locations_enable
	ON info.customer_locations USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_customer_locations__version
	ON info.customer_locations USING btree (_version DESC NULLS LAST);
