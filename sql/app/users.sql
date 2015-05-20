-- USERs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.users CASCADE;

CREATE TABLE app.users (
	id bigserial NOT NULL,
	login character varying(64) NOT NULL,
	pass character(32),
	name character varying(100) NOT NULL,
	authen_server_id integer, --NULL = local
	enable character(1) DEFAULT 'Y'::bpchar,
	created timestamp without time zone,
        modified timestamp without time zone,
	_create_uid bigint,
	_update_uid bigint,
	_version bigint NOT NULL DEFAULT tm18(),
	CONSTRAINT users_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_users_login 
	ON app.users USING btree (login);

CREATE INDEX idx_users_enable
	ON app.users USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_users__version
	ON app.users USING btree (_version DESC NULLS LAST);

-- Create Default User for New System, and automatic got ID number 1
INSERT INTO app.users(login,pass,name,enable, created, modified,_create_uid,_update_uid)
	values('root',md5(md5('password')),'System Root','Y',now()::timestamp(0),now()::timestamp(0),1,1);

