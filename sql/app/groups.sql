-- GROUPs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.groups CASCADE;

CREATE TABLE app.groups (
    id serial NOT NULL,
    name character varying(100) NOT NULL,
    enable character(1) DEFAULT 'Y'::bpchar,
	created timestamp without time zone,
    modified timestamp without time zone,
    _create_uid bigint,
    _update_uid bigint,
    _version bigint NOT NULL DEFAULT 0,

    CONSTRAINT groups_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_groups_name
    ON app.groups USING btree (name);

CREATE INDEX idx_groups_enable
    ON app.groups USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_groups__version
    ON app.groups USING btree (_version DESC NULLS LAST);