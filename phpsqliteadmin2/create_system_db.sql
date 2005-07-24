/*

To create the system-database, run 'sqlite phpsla.sqlite' and then:
sqlite> .read create_system_db.sql
sqlite> .quit

When designing the users table, I was inspired by this article: http://martin.f2o.org/php/login

*/

drop table databases;
drop table configuration;
drop table users;


create table databases (
	user integer not null,
	alias varchar not null,
	path varchar not null,
	description varchar
);
/*
create unique index db_cons on databases (user,alias);
*/


create table configuration (
	key varchar not null primary key,
	value varchar,
	description varchar
);


create table users (
	id integer not null primary key,
	login varchar unique,
	password varchar not null,
	realname varchar not null,
	email varchar not null,
	session varchar,
	ip varchar
);


insert into configuration values ('phpsla_version','0.3a',NULL);

insert into users values ('1','you','some md5 hash','name 1','bla1@nil.com',NULL,NULL);
insert into users values ('2','me','some md5 hash','name 2','bla2@nil.com',NULL,NULL);

insert into databases values (1,'i-man-0.8_Lin','/home/yves/projects/php/i-man-0.8/exampledb/i-man.sqlite','');
insert into databases values (1,'i-man-0.9_Lin','/home/yves/projects/php/i-man-0.9/exampledb/i-man.sqlite','');
insert into databases values (1,'i-man-0.8_Win','c:\htdocs\i-man-0.8\exampledb\i-man.sqlite','');
insert into databases values (1,'phpsla.sqlite','db/phpsla.sqlite','phpsla system database');
