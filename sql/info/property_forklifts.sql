-- CATEGORIEs of product

CREATE SCHEMA IF NOT EXISTS info;
DROP TABLE IF EXISTS info.property_forklifts CASCADE;

CREATE TABLE info.property_forklifts (
        id integer NOT NULL,
        
        type character varying(100),
        capacity numeric(6,2),
        mast numeric(6,2),
        fork numeric(6,2),
        gear character(1), --A=Auto, M=Manual
        engine character(1), --B=Battery, D=Diesel, G=Gasoline&LPG
        wheel smallint,
        tire character varying(100),
        attachment character varying(100),
        CONSTRAINT property_forklifts_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_property_forklifts_all
	ON info.property_forklifts USING btree (type, capacity, mast, fork, gear, engine, wheel, tire, attachment);
