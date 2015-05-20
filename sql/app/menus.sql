-- MENUs

CREATE SCHEMA IF NOT EXISTS app;
DROP TABLE IF EXISTS app.menus CASCADE;

CREATE TABLE app.menus (
        id serial NOT NULL,
        type character(1) NOT NULL, --L=LeftMenu, T=TopMenu
        name character varying(100),
        name_en character varying(100),
        host character varying(100),
        path character varying(255),
        parent bigint DEFAULT 0,
        level smallint DEFAULT 0,
        sort smallint NOT NULL DEFAULT 0,
        total_child integer NOT NULL DEFAULT 0,
        action character varying(50),
        item character varying(50),
        enable character(1) DEFAULT 'Y'::bpchar,
        created timestamp without time zone DEFAULT now()::timestamp(0),
        modified timestamp without time zone DEFAULT now()::timestamp(0),
        _create_uid bigint,
        _update_uid bigint,
        _version bigint NOT NULL DEFAULT tm18(),
        CONSTRAINT menus_pkey PRIMARY KEY (id)
);

CREATE INDEX idx_menus_parent
    ON app.menus USING btree (parent);

CREATE INDEX idx_menus_type
    ON app.menus USING btree (type);

CREATE INDEX idx_menus_enable
    ON app.menus USING btree (enable DESC NULLS LAST);

CREATE INDEX idx_menus__version
    ON app.menus USING btree (_version DESC NULLS LAST);


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-user fa-fw"></i> Customer', '<i class="fa fa-user fa-fw"></i> Customer', '/Customers/index', 0, 0, 0, 0, 
            'VIEW', 'CUSTOMER', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-dropbox fa-fw"></i> Product', '<i class="fa fa-dropbox fa-fw"></i> Product', '/Products/index', 0, 0, 0, 1, 
            'VIEW', 'PRODUCT', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version, enable)
    VALUES ('L', '<i class="fa fa-caret-right fa-fw"></i> Forklift', '<i class="fa fa-caret-right fa-fw"></i> Forklift', '/Products/index/Forklift', 2, 1, 0, 0, 
            'VIEW', 'PRODUCT', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18(), 'N');


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-book fa-fw"></i> Contract', '<i class="fa fa-book fa-fw"></i> Contract', '/Contracts/index', 0, 0, 0, 0, 
            'VIEW', 'CONTRACT', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-database fa-fw"></i> Master', '<i class="fa fa-database fa-fw"></i> Master', '#', 0, 0, 0, 3, 
            '', '', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-caret-right fa-fw"></i> Product Brand', '<i class="fa fa-caret-right fa-fw"></i> Product Brand', '/ProductBrands/index', 5, 1, 0, 0, 
            'VIEW', 'PBRAND', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-caret-right fa-fw"></i> Product Category', '<i class="fa fa-caret-right fa-fw"></i> Product Category', '/ProductCategories/index', 5, 1, 0, 0, 
            'VIEW', 'PCATEGORY', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());


INSERT INTO app.menus(
            type, name, name_en, path, parent, level, sort, total_child, 
            action, item, created, modified, _create_uid, _update_uid, 
            _version)
    VALUES ('L', '<i class="fa fa-caret-right fa-fw"></i> User', '<i class="fa fa-caret-right fa-fw"></i> User', '/Users/index', 5, 1, 0, 0, 
            'VIEW', 'USER', now()::timestamp(0), now()::timestamp(0), 1, 1, 
            tm18());