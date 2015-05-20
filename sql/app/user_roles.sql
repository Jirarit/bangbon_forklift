-- USER ROLEs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.user_roles CASCADE;

CREATE TABLE app.user_roles (
	id serial NOT NULL,
	user_id bigint NOT NULL,
	department_id integer NOT NULL,
	position_id integer NOT NULL DEFAULT 0,
	_create_uid bigint,
   	_version bigint NOT NULL DEFAULT 0,

	CONSTRAINT user_groups_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_user_roles_user_id_department_id_position_id
	ON app.user_roles USING btree (user_id, department_id, position_id);

CREATE INDEX idx_user_roles_user_id
	ON app.user_roles USING btree (user_id);

CREATE INDEX idx_user_roles_department_id
	ON app.user_roles USING btree (department_id);

CREATE INDEX idx_user_roles_position_id
	ON app.user_roles USING btree (position_id);

CREATE INDEX idx_user_roles__version
	ON app.user_roles USING btree (_version DESC NULLS LAST);

