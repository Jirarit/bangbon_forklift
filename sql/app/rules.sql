-- RULEs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.rules CASCADE;

CREATE TABLE app.rules (
	id serial NOT NULL,
	no integer NOT NULL,
	ad character(1) NOT NULL DEFAULT 'A'::bpchar,
	action character varying(15) NOT NULL DEFAULT 'ALL'::character varying,
	item character varying(32) NOT NULL DEFAULT 'ALL'::character varying,
	user_id integer DEFAULT (-1), -- -1=All(Include no user), 0=Any user, ...=Specific user
	position_id integer DEFAULT (-1), -- -1=All(Include no position), 0=Any position, ...=Specific position
	department_id integer DEFAULT (-1), -- -1=All(Include no department), 0=Any department, ...=Specific department
	group_id integer DEFAULT (-1), -- -1=All(Include no group), 0=Any group, ...=Specific group

	enable character(1) NOT NULL DEFAULT 'Y'::bpchar,
	_create_uid bigint,
	_update_uid bigint,
	_version bigint NOT NULL DEFAULT 0,
	CONSTRAINT rules_pkey PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_rules_no
        ON app.rules USING btree (no);

CREATE INDEX idx_rules_item 
	ON app.rules USING btree (item);

CREATE INDEX idx_rules_ref 
	ON app.rules USING btree (user_id, position_id, role_id, department_id, ugroup_id);

CREATE INDEX idx_rules_enable
	ON app.rules USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_rules__version
        ON app.rules USING btree (_version DESC NULLS LAST);

-- Create First rule that allow full power for user=root uid=0
INSERT INTO app.rules (no,ad,action,item,user_id,_create_uid,_update_uid)
	values(1,'A','ALL','ALL',1,1,1);

