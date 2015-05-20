-- DEPARTMENTs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.departments CASCADE;

CREATE TABLE app.departments (
	id serial NOT NULL,
	code character varying(50) NOT NULL DEFAULT ''::character varying,
	name character varying(100) NOT NULL,
	name_en character varying(100) NOT NULL,
	parent integer NOT NULL,
	level integer NOT NULL DEFAULT 0,
	sort smallint NOT NULL DEFAULT 0,
	total_child integer NOT NULL DEFAULT 0,
	enable character(1) NOT NULL DEFAULT 'Y'::bpchar,
	created timestamp without time zone,
    modified timestamp without time zone,
	_create_uid bigint,
    _update_uid bigint,
    _version bigint NOT NULL DEFAULT 0,

	CONSTRAINT departments_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_departments_code 
    ON app.departments USING btree(code);

CREATE INDEX idx_departments_parent
    ON app.departments USING btree(parent);

CREATE INDEX idx_departments_enable
    ON app.departments USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_departments__version
    ON app.departments USING btree (_version DESC NULLS LAST);
