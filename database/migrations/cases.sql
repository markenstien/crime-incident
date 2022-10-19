drop table if exists cases;
create table cases(
    id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    reference varchar(50) unique,
    title varchar(100),
    description text,
    incident_date date,
    incident_time time,
    crime_type_id int(10),
    num_of_victim_death smallint,
    num_of_victim_injury smallint,
    num_of_supect_death smallint,
    num_of_supect_injury smallint,

    barangay_id int,
    street_id int,
    lat text,
    lng text,

    incident_status varchar(50),
    remarks text,
    created_at timestamp DEFAULT now()
);