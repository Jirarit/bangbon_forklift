-- USER GROUPs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.user_groups CASCADE;

CREATE TABLE app.user_groups (
	id serial NOT NULL,
	user_id bigint NOT NULL,
	group_id integer NOT NULL,
	_create_uid bigint,
   	_version bigint NOT NULL DEFAULT 0,

	CONSTRAINT user_groups_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_user_group_user_id_group_id
	ON app.user_groups USING btree (user_id, group_id);

CREATE INDEX idx_user_groups__version
	ON app.user_groups USING btree (_version DESC NULLS LAST);

