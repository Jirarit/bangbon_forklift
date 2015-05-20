-- CONFIGs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.configs CASCADE;

CREATE TABLE app.configs (
        id character varying(50) NOT NULL,
        value character varying(100),
        description text,
	created timestamp without time zone NOT NULL,
        modified timestamp without time zone NOT NULL,
	_create_uid bigint NOT NULL,
        _update_uid bigint NOT NULL,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT configs_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_configs__version
    ON app.configs USING btree (_version DESC NULLS LAST);

INSERT INTO app.configs (id, value, description, created, modified, _create_uid, _update_uid) 
    VALUES ('AUTHEN_LOGIN', 'Y', 'ON/OFF Authentication app (Login and check session)', now()::timestamptz(0), now()::timestamptz(0), 1, 1);