--C:\xampp\mysql\bin\mysql -uroot --default_character_set=utf8 < C:\Users\Dino\Desktop\ZavrsniRad\www\rad.hr\tvrtka.sql 


drop database if exists tvrtka;

create database tvrtka default charset utf8mb4;

use tvrtka;

create table
    operater(
        sifra int not null primary key auto_increment,
        email varchar(50) not null,
        lozinka varchar(100) not null,
        ime varchar(50) not null,
        prezime varchar(50) not null,
        uloga varchar(20) not null
    );
create table poslovnica
    (
        sifra int not null primary key auto_increment,
        naziv varchar(50) not null,
        mjesto varchar(50) not null,
        email varchar(50) not null
    );


create table proizvod(
        sifra int not null primary key auto_increment,
        naziv_proizvoda varchar(50) not null,
        cijena_proizvoda VARCHAR(50) not null,
        proizvodac varchar(50) not null,
        poslovnica int not null
        
    );

create table distribucija(
        sifra int not null primary key auto_increment,
        mjesto varchar(50),
        vrijeme varchar (50),
        kolicina VARCHAR(50),
        osoba int not null
    );

create table osoba(
        sifra int not null primary key auto_increment,
        ime varchar(50) not null,
        prezime varchar(50) not null,
        mjesto_stanovanja varchar(50) not null,
        oib char (11),
        naziv_terena varchar(50) not null,
        smjena varchar(50) not null,
        email varchar(50)  null
    );

create table proizvod_distribucija(
        sifra int not null primary key auto_increment,
        proizvod int not null,
        distribucija int not null
    );


alter table distribucija add foreign key (osoba) references osoba (sifra);

alter table proizvod add foreign key (poslovnica) references poslovnica (sifra);

alter table proizvod_distribucija add foreign key (proizvod) references proizvod (sifra);

alter table proizvod_distribucija add foreign key (distribucija) references distribucija (sifra);

insert into operater(email,lozinka,ime,prezime,uloga)
values  ('dino@localhost.hr','$2a$10$O1q.IXkCIq59VhvRJz0Qb.zq1392Pr7cwwpnAoEHoA8yDOW27jDDS','Dino','Administrator','admin'),
        ('oper@localhost.hr','$2a$10$PWUKkr3J8Jx99Z.6rXGXgOEhexCujpBSt1PSb/9zvbcaAKdigIkJC','oper','oper','operator');
        
insert into
    osoba (sifra,ime,prezime,mjesto_stanovanja,oib,naziv_terena,smjena,email)
values  (1,'Marko','Perić','Osijek',283927475829,'Osijek','Poslijepodne','MarkoLedeni@gmail.hr'),
        (2,'Ivana','Mandić','Osijek',81234029387,'Osijek','Poslijepodne','IvanaLedeni@gmail.hr' ), 
        (3,'Dea','Horvat','Tenja',98210092234,'Našice','Prijepodne','DeaLedeni@gmail.hr' ),
        (4,'Ivan','Hodak','Vukovar',99210036472,'Vukovar','Prijepodne','IvanLedeni@gmail.hr' ),
        (5,'Matej','Kolić','Brijest',83920109384,'Slatina','Poslijepodne','MatejLedeni@gmail.hr' ),
        (6,'Sonja','Galić','Višnjevac',00938741934,'Osijek','Prijepodne','SonjaLedeni@gmail.hr' ),
        (7,'Dino','Majer','Bilje',0394718273921,'Baranja','Poslijepodne','DinoLedeni@gmail.hr' ),
        (8,'Ema','Krešo','Antunovac',938572819384,'Osijek','Prijepodne','EmaLedeni@gmail.hr' ),
        (9,'Kristijan','Karlak','Osijek',53928333847,'Osijek','Prijepodne','KristijanLedeni@gmail.hr' ),
        (10,'Marko','Tomić','Đakovo',19382634442,'Đakovo','Poslijepodne','MarkoLedeni@gmail.hr' ),
        (11,'Siniša','Modrić','Bizovac',39843029385,'Osijek','Prijepodne','SinišaLedeni@gmail.hr' );


insert into poslovnica (sifra, naziv, mjesto, email)
values (1,'Ledeni','Osijek','Ledeni@gmail.hr');

insert into proizvod (sifra,naziv_proizvoda,cijena_proizvoda,proizvodac,poslovnica)
values  (1,'Grašak',16,'Ledeni',1),
        (2,'Kapri',8.99,'Ledeni',1),
        (3,'Oslić',21,'Fresco',1),
        (4,'Njoke',22,'Ledeni',1),
        (5,'Savijača',13,'Fresco',1),
        (6,'Špinat',7.50,'Ledeni',1),
        (7,'Snjeguljica',6,'Ledeni',1),
        (8,'Burger ',25.99,'Pik',1),
        (9,'Piletina ',32.50,'Pik',1);

insert into distribucija (sifra,mjesto,vrijeme,kolicina,osoba)
values (1,'Osijek','Poslijepodne',20,1),
(2,'Osijek','Poslijepodne',13,2),
(3,'Osijek','Prijepodne',133,3),
(4, 'Osijek', 'Prijepodne', 42,4),
(5,'Osijek','Poslijepodne',25,5),
(6,'Osijek','Prijepodne',200,6),
(7,'Osijek','Poslijepodne',11,7),
(8, 'Osijek', 'Prijepodne', 5,8),
(9, 'Osijek', 'Prijepodne', 5,9), 
(10, 'Osijek', 'Prijepodne', 5,9), 
(11, 'Osijek', 'Prijepodne', 5,1); 

insert into proizvod_distribucija (sifra, proizvod, distribucija)
values  (1, 1, 1),
        (2, 4, 2),
        (3, 3, 3),
        (4, 2, 6),
        (5, 8, 4),
        (6, 6, 8),
        (7, 5, 7),
        (8, 7, 5);