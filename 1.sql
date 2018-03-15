create table test(
	id int not null auto_increment primary key,
	uid varchar(30) not null,
	usergroup varchar(100) not null	
)engine=MyISAM charset=utf8;

insert into test(uid,username) values('$i','$username');
select username from test limit $i,1;