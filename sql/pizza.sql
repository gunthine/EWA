/*==============================================================*/
/* Table: ANGEBOT                                               */
/*==============================================================*/
create table ANGEBOT
(
   PIZZANAME            varchar(20) NOT NULL PRIMARY KEY,
   PREIS                float not null,
   BILDDATEI            varchar(100)
);

/*==============================================================*/
/* Table: BESTELLTEPIZZA                                        */
/*==============================================================*/
create table BESTELLTEPIZZA
(
   PIZZAID              int NOT NULL AUTO_INCREMENT PRIMARY KEY,
   BESTELLUNGID         int not null,
   PIZZANAME            varchar(20) not null,
   STATUS               char(1)
);

/*==============================================================*/
/* Table: BESTELLUNG                                            */
/*==============================================================*/
create table BESTELLUNG
(
   BESTELUNGID          int NOT NULL AUTO_INCREMENT PRIMARY KEY,
   VORNAME				varchar(20) not null,
   NACHNAME				varchar(20) not null,
   ADRESSE              varchar(60) not null,
   BESTELLZEITPUNKT     datetime not null
);

alter table BESTELLTEPIZZA add constraint bestelltepizza_angebot foreign key (PIZZANAME)
      references ANGEBOT (PIZZANAME) on delete restrict on update restrict;

alter table BESTELLTEPIZZA add constraint bestelltepizza_bestellung foreign key (BESTELUNGID)
      references BESTELLUNG (BESTELUNGID) on delete restrict on update restrict;
