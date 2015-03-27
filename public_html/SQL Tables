-- CS304 TABLES FOR TRANSPORTATION SYSTEM DATABASE

-- DROP TABLES
drop table employee; --entity
drop table manager; --entity
drop table schedule; --entity
drop table vehicles; --entity
drop table customers; --entity
drop table operatedby; --relation
drop table rides; --relation
drop table follows; --relation
drop table reads; --relation
drop table make; --relation

--make

create table make(
	sin number,
	transitID varchar(40),
	foreign key(sin) references employee(sin) on delete cascade,
	foreign key(transitID) references schedule(transitID) on delete cascade
);


-- Reads

create table reads(
	username varchar2(30),
	phone number,
	transitID varchar(40),
	foreign key(username, phone) references customer(username, phone) on delete cascade,
	foreign key(transitID) references schedule(transitID) on delete cascade
);

-- Follows

create table follows(
	vid number,
	transitID varchar2(40),
	foreign key(vid) references vehicle(vid) on delete cascade,
	foreign key(transitID) references schedule(transitID) on delete cascade
);

-- Rides

create table rides(
	username varchar2(30),
	phone number,
	vid number,
	foreign key(username, phone) references customer(username, phone) on delete cascade,
	foreign key(vid) references vehicles(vid) on delete cascade
);

-- OperatedBy Table

create table operatedby(
	sin number not null unique,
	vid number not null unique,
	foreign key(sin) references employees(sin) on delete cascade,
	foreign key(vid) references vehicles(vid) on delete cascade
);

insert into operatedby values(717561829, 1);
insert into operatedby values(782286272, 2);
insert into operatedby values(710928287, 3);
insert into operatedby values(716898221, 4);
insert into operatedby values(762981822, 5);
insert into operatedby values(722341822, 6);

-- Employee Table

create table employee(
	sin number,
	name varchar2(30),
	phone number,
	address varchar2(30),
	username varchar2(20),
	password varchar2(20),
	wage number,
	jobt varchar2(10),
	works varchar2(10),
	primary key(sin)
);

insert into employee  values(747565334, 'Jannina Valencia', 7785433343, '678 Rose St Vancouver', 'jval25', 'dalevr', 7000, 'bus driver', 'mwf');
insert into employee  values(765654234, 'April Green', 6046768890, '6718 Carnation St Burnaby', 'aprgr', '78htvh', 7400, 'taxi driver', 'mtwthf');
insert into employee  values(732098789, 'Morgan Free', 7785463343, '3468 Clark St Vancouver', 'freeee', '78bsgdk', 5000, 'operator', 'mtwfsat');
insert into employee  values(745909897, 'Leslie Wong', 7784230186, '1223 Sasamat St Richmond', 'lwongg', 'afgfeirg', 4500, 'maintenance', 'mtwthfsun');
insert into employee  values(730988123, 'Felicity Wishes', 604019223, '9888 Smithe St Coquitlam', 'jval25', 'dalevr', 7000, 'bus driver', 'mtthf');

-- Manager table

create table manager(
	SIN number,
	primary key(SIN),
	foreign key(SIN)
	references Employee(SIN)
);

insert into manager values(717561829);
insert into manager values(782286272);
insert into manager values(710928287);
insert into manager values(716898221);
insert into manager values(762981822);
insert into manager values(722341822);


-- Schedule Table

create table schedule(
	transitID varchar2(40),
	arrivals timestamp,
	departures timestamp,
	destination varchar2(40),
	travelTime number,
	primary key(TransitID)
);

insert into schedule values('t1292', to_timestamp('2015/03/29 08:20', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 08:30', 'YYYY/MM/DD HH24 MI'), 'Commercial Bdway', 50);
insert into schedule values('t6143', to_timestamp('2015/03/29 05:30', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 05:38', 'YYYY/MM/DD HH24 MI'), 'UBC', 45);
insert into schedule values('t8767', to_timestamp('2015/03/29 21:30', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 21:39', 'YYYY/MM/DD HH24 MI'), 'Coq Stn', 33);
insert into schedule values('t6715', to_timestamp('2015/03/29 22:05', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 22:35', 'YYYY/MM/DD HH24 MI'), 'Granville', 42);
insert into schedule values('t4322', to_timestamp('2015/03/29 10:15', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 10:20', 'YYYY/MM/DD HH24 MI'), 'Lonsdale Quay', 20);
insert into schedule values('t6715', to_timestamp('2015/03/29 22:05', 'YYYY/MM/DD HH24 MI'), to_timestamp('2015/03/29 22:35', 'YYYY/MM/DD HH24 MI'), 'Granville', 42);


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

insert into vehicles values(1, 50, 'bus', 2.75, 'mod788', 10);
insert into vehicles values(2, 5, 'taxi', 5.00, 'mod134', 3);
insert into vehicles values(3, 100, 'train', 4.75, 'mod334', 12);
insert into vehicles values(4, 40, 'seabus', 3.50, 'mod1221', 15);
insert into vehicles values(5, 50, 'bus', 2.75, 'mod788', 10);
insert into vehicles values(6, 100,'train', 4.75, 'mod3321', 7);


-- Customers table

create table customers(
	pnumber number,
	address varchar2(30),
	username varchar2(30),
	password varchar2(30),
	credit number,
	primary key(username)
);

insert into customers values(7786546588, '340 Agnes St New Westminster', 'bright', '8h6hdh', 30);
insert into customers values(6046557816, '4567 Drake St Vancouver', 'narms', '7nshka', 0);
insert into customers values(6045551086, '32112 Cornwood St Coquitlam', 'lsmith', '7jhah', 21);
insert into customers values(6045017683, '1222 Knight St Vancouver', 'flints', '6ndghps', 100);
insert into customers values(6049807692, '1212 Cordova St North Vancouver', 'anne', 'kadhdo', 65);
insert into customers values(7786446588, '343 Agnes St New Westminster', 'leftb', 'asdd4', 40);

	

	
	
