--C:\xampp\mysql\bin\mysql -uroot --default_character_set=utf8 < C:\Users\Dino\Desktop\ZavrsniRad\www\rad.hr\SQL\tvrtka.sql 


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
        mjesto varchar(50),
        email varchar(50)
    );

create table proizvod(
        sifra int not null primary key auto_increment,
        naziv_proizvoda varchar(50) not null,
        rok_trajanja datetime,
        cijena_proizvoda dec,
        proizvodac varchar(50) not null,
        poslovnica int not null
    );

create table distribucija(
        sifra int not null primary key auto_increment,
        mjesto varchar(50),
        vrijeme varchar (50),
        kolicina dec,
        osoba int not null
    );

create table osoba(
        sifra int not null primary key auto_increment,
        ime varchar(50) not null,
        prezime varchar(50) not null,
        mjesto_stanovanja varchar(50),
        oib char (11),
        datum_rodenja datetime,
        naziv_terena varchar(50),
        smjena varchar(50),
        email varchar(50) not null
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
values  ('dino@localhost.hr','dino','Edunova','Administrator','admin');
        
insert into
    osoba (sifra,ime,prezime,mjesto_stanovanja,oib, datum_rodenja,naziv_terena,smjena)
values  (1,'Marko','Perić','Osijek',283927475829,'1988-02-01','Osijek','Poslijepodne'),
        (2,'Ivana','Mandić','Osijek',81234029387,'1993-04-06','Osijek','Poslijepodne'), 
        (3,'Dea','Horvat','Tenja',98210092234,'1969-07-05','Našice','Prijepodne'),
        (4,'Ivan','Hodak','Vukovar',99210036472,'1999-04-04','Vukovar','Prijepodne'),
        (5,'Matej','Kolić','Brijest',83920109384,'1995-06-06','Slatina','Poslijepodne'),
        (6,'Sonja','Galić','Višnjevac',00938741934,'1978-03-05','Osijek','Prijepodne'),
        (7,'Dino','Majer','Bilje',0394718273921,'1994-01-01','Baranja','Poslijepodne'),
        (8,'Ema','Krešo','Antunovac',938572819384,'1988-02-01','Osijek','Prijepodne'),
        (9,'Kristijan','Karlak','Osijek',53928333847,'1971-09-04','Osijek','Prijepodne'),
        (10,'Marko','Tomić','Đakovo',19382634442,'1991-12-03','Đakovo','Poslijepodne'),
        (11,'Siniša','Modrić','Bizovac',39843029385,'1994-02-03','Osijek','Prijepodne');


insert into poslovnica (sifra, naziv, mjesto, email)
values (1,'Ledo','Osijek','Ledo@gmail.hr');

insert into proizvod (sifra,naziv_proizvoda,rok_trajanja,cijena_proizvoda,proizvodac,poslovnica)
values  (1,'Grašak','2024-11-05',16,'Ledo',1),
        (2,'Kapri','2023-5-05',8.99,'Ledo',1),
        (3,'Oslić','2023-2-05',21,'Fresco',1),
        (4,'Njoke','2024-5-05',22,'Ledo',1),
        (5,'Savijača','2024-9-05',13,'Fresco',1),
        (6,'Špinat','2023-03-05',7.50,'Ledo',1),
        (7,'Snjeguljica','2024-03-05',6,'Ledo',1),
        (8,'Burger ','2023-03-05',25.99,'Pik',1),
        (9,'Burger ','2023-03-05',32.50,'Pik',1);

insert into distribucija (sifra,mjesto,vrijeme,kolicina,osoba)
values (1,'Osijek','Poslijepodne',20,1),
(2,'Osijek','Poslijepodne',13,2),
(3,'Osijek','Prijepodne',133,3),
(4, 'Osijek', 'Prijepodne', 42, 4),
(5,'Osijek','Poslijepodne',25,5),
(6,'Osijek','Prijepodne',200,6),
(7,'Osijek','Poslijepodne',11,7),
(8, 'Osijek', 'Prijepodne', 5, 8);

insert into proizvod_distribucija (sifra, proizvod, distribucija)
values  (1, 1, 1),
        (2, 4, 2),
        (3, 3, 3),
        (4, 2, 6),
        (5, 8, 4),
        (6, 6, 8),
        (7, 5, 7),
        (8, 7, 5);