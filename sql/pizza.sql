/*==============================================================*/
/* Table: ANGEBOT                                               */
/*==============================================================*/
create table ANGEBOT
(
   PIZZANAME            varchar(20) not null  comment '',
   PREIS                float not null  comment '',
   BILDDATEI            varchar(200) comment '',
   primary key (PIZZANAME)
);

/*==============================================================*/
/* Table: BESTELLTEPIZZA                                        */
/*==============================================================*/
create table BESTELLTEPIZZA
(
   BESTELUNGID          int not null  comment '',
   PIZZANAME            varchar(20) not null  comment '',
   PIZZAID              int not null  comment '',
   SATUS                char(1)  comment '',
   primary key (BESTELUNGID, PIZZANAME, PIZZAID)
);

/*==============================================================*/
/* Table: BESTELLUNG                                            */
/*==============================================================*/
create table BESTELLUNG
(
   BESTELUNGID          int PRIMARY KEY AUTO INCREMENT not null comment '',
   ADRESSE              varchar(60) not null  comment '',
   BESTELLZEITPUNKT     datetime not null  comment '',
);

alter table BESTELLTEPIZZA add constraint FK_BESTELLT_WIRD_ANGEBOT foreign key (PIZZANAME)
      references ANGEBOT (PIZZANAME) on delete restrict on update restrict;

alter table BESTELLTEPIZZA add constraint FK_BESTELLT_WIRD_ZUGE_BESTELLU foreign key (BESTELUNGID)
      references BESTELLUNG (BESTELUNGID) on delete restrict on update restrict;
