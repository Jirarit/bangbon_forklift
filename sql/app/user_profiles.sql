-- USER PROFILEs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.user_profiles CASCADE;

CREATE TABLE app.user_profiles (
	id bigint NOT NULL,
	title_name character varying(20) NOT NULL DEFAULT '',
	first_name character varying(100) NOT NULL DEFAULT '',
	last_name character varying(100) NOT NULL DEFAULT '',
	full_name character varying(220) NOT NULL DEFAULT '',
	title_name_en character varying(20) NOT NULL DEFAULT '',
	first_name_en character varying(100) NOT NULL DEFAULT '',
	last_name_en character varying(100) NOT NULL DEFAULT '',
	full_name_en character varying(220) NOT NULL DEFAULT '',
	emp_code character varying(100),
	id_card_type character(1) NOT NULL DEFAULT 'C'::character varying, --C=CitizenID, P=Passport
	id_card_no character varying(50),
	created timestamp without time zone,
        modified timestamp without time zone,
	_create_uid bigint,
	_update_uid bigint,
	_version bigint NOT NULL DEFAULT 0,

	CONSTRAINT user_profiles_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_user_profiles__version
	ON app.user_profiles USING btree (_version DESC NULLS LAST);

-- Auto create first Profile for User Root
INSERT INTO app.user_profiles(id,first_name,last_name,first_name_en,last_name_en,_create_uid,_update_uid)
	VALUES(1,'System','Root','System','Root',1,1);

