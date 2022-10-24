drop table if exists cases_people;
create table cases_people(
    id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    case_id int(10) not null,
    firstname varchar(100),
    lastname varchar(100),
    injury_remarks text,
    is_dead boolean DEFAULT false,
    phone varchar(50),
    gender enum('MALE','FEMALE'),
    age smallint,
    people_type enum('VICTIM','SUSPECT')
);

