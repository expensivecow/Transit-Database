-- CS304 TABLES FOR TRANSPORTATION SYSTEM DATABASE
drop table operatedby;
drop table rides;
drop table follows;
drop table reads;
drop table make;
drop table customers;
drop table vehicles;
drop table schedule;
drop table manager;
drop table employee;

-- Employee Table

create table employee(
	sin number,
	name varchar2(30),
	phone number,
	address varchar2(50),
	username varchar2(20),
	password varchar2(20),
	wage number,
	jobt varchar2(15),
	works varchar2(10),
	primary key(sin, username)
);
-- Manager table

grant select on employee to public;

create table manager(
	SIN number,
	username varchar2(20),
	primary key(SIN, username),
	foreign key(SIN, username)
	references employee(SIN, username)
);

grant select on manager to public;
-- Schedule Table

create table schedule(
	transitID varchar2(40),
	arrivals timestamp,
	departures timestamp,
	destination varchar2(40),
	travelTime number,
	primary key(TransitID)
);

grant select on schedule to public;
-- vhicles table

create table vehicles(
	vid number,
	capacity number,
	vmode varchar2(7),
	cost number,
	model varchar2(30),
	age number,
	primary key(vid)
);

grant select on vehicles to public;
-- Customers table

create table customers(
	pnumber number,
	address varchar2(50),
	username varchar2(30),
	password varchar2(30),
	credit number,
	primary key(username)
);

grant select on customers to public;
--make

create table make(
	sin number,
	username varchar2(20),
	transitID varchar(40),
	foreign key(sin, username) references employee on delete cascade,
	foreign key(transitID) references schedule on delete cascade
);

grant select on make to public;
-- Reads

create table reads(
	username varchar2(30),
	transitID varchar(40),
	foreign key(username) references customers(username) on delete cascade,
	foreign key(transitID) references schedule(transitID) on delete cascade
);

grant select on reads to public;
-- Follows

create table follows(
	vid number,
	transitID varchar2(40),
	foreign key(vid) references vehicles(vid) on delete cascade,
	foreign key(transitID) references schedule(transitID) on delete cascade
);
grant select on follows to public;
-- Rides

create table rides(
	username varchar2(30),
	vid number,
	foreign key(username) references customers(username) on delete cascade,
	foreign key(vid) references vehicles(vid) on delete cascade
);

grant select on rides to public;
-- OperatedBy Table

create table operatedby(
	sin number not null unique,
	username varchar2(20) not null unique,
	vid number not null unique,
	foreign key(sin, username) references employee(sin, username) on delete cascade,
	foreign key(vid) references vehicles(vid) on delete cascade
);

grant select on operatedby to public;

insert into employee  values(747565334, 'Jannina Valencia', 7785433343, '678 Rose St Vancouver', 'jval25', 'dalevr', 7000, 'bus driver', 'mwf');
insert into employee  values(765654234, 'April Green', 6046768890, '6718 Carnation St Burnaby', 'aprgr', '78htvh', 7400, 'taxi driver', 'mtwthf');
insert into employee  values(732098789, 'Morgan Free', 7785463343, '3468 Clark St Vancouver', 'freeee', '78bsgdk', 5000, 'operator', 'mtwfsat');
insert into employee  values(745909897, 'Leslie Wong', 7784230186, '1223 Sasamat St Richmond', 'lwongg', 'afgfeirg', 4500, 'maintenance', 'mtwthfsun');

insert into manager values(747565334, 'jval25');

insert into schedule values('t1292', to_timestamp('2015/03/29 08:20', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 08:30', 'YYYY/MM/DD HH24 MI'), 'Commercial Bdway', 50);
insert into schedule values('t6143', to_timestamp('2015/03/29 05:30', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 05:38', 'YYYY/MM/DD HH24 MI'), 'UBC', 45);
insert into schedule values('t8767', to_timestamp('2015/03/29 21:30', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 21:39', 'YYYY/MM/DD HH24 MI'), 'Coq Stn', 33);
insert into schedule values('t6715', to_timestamp('2015/03/29 22:05', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 22:35', 'YYYY/MM/DD HH24 MI'), 'Granville', 42);
insert into schedule values('t4322', to_timestamp('2015/03/29 10:15', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 10:20', 'YYYY/MM/DD HH24 MI'), 'Lonsdale Quay', 20);

insert into vehicles values(1, 50, 'bus', 2.75, 'mod788', 10);
insert into vehicles values(2, 5, 'taxi', 5.00, 'mod134', 3);
insert into vehicles values(3, 100, 'train', 4.75, 'mod334', 12);
insert into vehicles values(4, 40, 'seabus', 3.50, 'mod1221', 15);
insert into vehicles values(5, 50, 'bus', 2.75, 'mod788', 10);
insert into vehicles values(6, 100,'train', 4.75, 'mod3321', 7);

insert into customers values(7786546588, '340 Agnes St New Westminster', 'bright', '8h6hdh', 30);
insert into customers values(6046557816, '4567 Drake St Vancouver', 'narms', '7nshka', 0);
insert into customers values(6045551086, '32112 Cornwood St Coquitlam', 'lsmith', '7jhah', 21);
insert into customers values(6045017683, '1222 Knight St Vancouver', 'flints', '6ndghps', 100);
insert into customers values(6049807692, '1212 Cordova St North Vancouver', 'anne', 'kadhdo', 65);
insert into customers values(7786446588, '343 Agnes St New Westminster', 'leftb', 'asdd4', 40);

insert into make values(747565334, 'jval25','t1292');

insert into reads values('bright', 't1292');

insert into follows values(1, 't1292');

insert into rides values('bright', 1);

insert into operatedby values(747565334, 'jval25', 1);






	
	
