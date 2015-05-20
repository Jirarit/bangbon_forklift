-- CONTRACTs

CREATE SCHEMA IF NOT EXISTS trans;
DROP TABLE IF EXISTS trans.contracts CASCADE;

CREATE TABLE trans.contracts (
	id serial NOT NULL,

        contract_no character varying(30) NOT NULL,
        contract_date date NOT NULL,
        contract_expire date NOT NULL,

        product_id integer NOT NULL,
        product_serial_id bigint NOT NULL,

        customer_id integer,
        customer_location_id integer,

        ref_car_no character varying(10),
        ref_quotation_no character varying(25),
        ref_pr_no character varying(25),
        ref_po_no character varying(25),

        price numeric(16,2) NOT NULL DEFAULT 0,

        status character(1) NOT NULL, --A=Acitive, I=Inactive, D=Deleted

        attach_pic bigint[],
        attach_doc bigint[],

	created timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
        modified timestamp without time zone NOT NULL DEFAULT now()::timestamptz(0),
	_create_uid bigint NOT NULL,
        _update_uid bigint NOT NULL,
        _version bigint NOT NULL DEFAULT tm18(),
	CONSTRAINT contracts_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_contracts_product_id
	ON trans.contracts USING btree (product_id);

CREATE INDEX idx_contracts_product_serial_id
	ON trans.contracts USING btree (product_serial_id);

CREATE INDEX idx_contracts_customer_id
	ON trans.contracts USING btree (customer_id);

CREATE INDEX idx_contracts_customer_location_id
	ON trans.contracts USING btree (customer_location_id);

CREATE INDEX idx_contracts_status
	ON trans.contracts USING btree (status);

CREATE INDEX idx_contracts__version
	ON trans.contracts USING btree (_version DESC NULLS LAST);
