
--  USER

-- 2006 - 2019 -> Caminheiros
-- 2005 - 2008 -> Caminheiros
-- 2001 - 2004 -> Caminheiros
-- 1997 - 2000 -> Caminheiros

-- Guardians
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
	VALUES (1,'faucibus.orci.luctus@semmollis.edu','ZHR48SKM3ZF','Berk Ellison','1986-02-16','true','true',
    'semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
	VALUES (2,'tincidunt.neque@nequevenenatis.net','BHW02JZG5KM','Patrick Rollins','1989-11-16','true','true',
    'mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
	VALUES (3,'sed.libero.Proin@aliquetvel.co.uk','KSK38RGF8HH','Amery Contreras','1972-05-20','true','true',
    'mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc.','false');

-- Users that have a guardian: 4 - 5 - 6 - 7 - 8

-- Regular/Lobitos
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (4,'eget.venenatis@Donec.co.uk','YMK10JLF1IU','Graiden Walton','2010-09-18',1,'false','false',
    'In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla','false');

INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (5,'diam@temporestac.ca','SFG57CJP9OQ','Ciaran Larson','2013-06-02',1,'false','false',
    'Pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae,','false');

INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (6,'eu@consequatdolorvitae.org','OSY03UEA1WD','Quinn Bell','2012-07-30',2,'false','false',
    'erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla','false');
    
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (7,'mi@aliquamiaculis.ca','JQS83CNI5RE','Len Berry','2011-04-23',1,'false','false',
    'enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim','false');
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (8,'tempus@ornare.co.uk','ZQZ35VBO6BN','Yuli Huber','2009-05-03',3,'false','false',
    'ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero','false');


-- Regular/Pioneiros
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (9,'elit.pretium.et@semvitaealiquam.ca','DHB08BBU2YQ','Oleg Conley','2008-11-22','true','false',
    'risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (10,'in.tempus.eu@tellus.net','SLW86DWJ0ON','Blake Faulkner','2007-06-23','true','false','
    Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (11,'lectus.justo.eu@magnisdisparturient.org','NRN79MAL6UR','Derek Stein','2005-04-03','true','false',
    'Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (12,'Curae.Donec@leo.net','GOY21DJP6GY','Kennedy Hodges','2006-09-10','true','false',
    'ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus.','false');

--Regular/Exploradores
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (13,'sem.consequat.nec@turpisegestas.co.uk','LBJ29RFE1EC','Howard Zimmerman','2002-12-17','true','false',
    'Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (14,'lectus.Cum.sociis@ullamcorperDuis.com','DTR23ONX4ZB','Dolan Harper','2001-06-05','true','false',
    'Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (15,'eget@placeratvelit.ca','NCH23QHS8TU','Dale Poole','1999-09-19','true','false',
    'quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (16,'eu.eros.Nam@sodalespurusin.net','FDS69ABK8IP','Justin Perez','2003-10-12','true','false',
    'a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam','false');

--Regular/Caminheiros
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (17,'felis.Nulla.tempor@auctorquistristique.edu','EOJ91TSC0FI','William Raymond','1998-06-09','true','false',
    'enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (18,'Nullam.ut@lectusNullam.ca','ZGV73RXV6ZO','Raja Becker','1999-07-25','true','false',
    'Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus,','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (19,'mollis.Phasellus.libero@Etiam.net','NSV94PFK9NZ','Brennan Pena','2000-10-08','true','false',
    'eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (20,'vel.mauris.Integer@Crasloremlorem.co.uk','EWP25ONC1OB','Aaron Moreno','1997-12-03','true','false',
    'imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (21,'Quisque@tristiqueneque.co.uk','RSU43PCX5GV','Palmer Gregory','2000-08-12','true','false',
    'sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida','false');

-- Chiefs

    --Lobitos
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (22,'vitae@acurna.co.uk','OUN72HCE3TK','Xanthus Peck','1990-02-19','true','false',
    'dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl.','false');
    
    --Pioneiros
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (23,'erat.Etiam@lobortisnisinibh.co.uk','NTE93CSR8GQ','Hall Mayo','1993-08-11','true','false',
    'et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis','false');

    --Exploradores
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (24,'neque.In.ornare@Duiscursus.com','NQH91ENB3BA','Dexter Golden','1989-02-16','true','false',
    'Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante.','false');

    --Caminheiros
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (25,'odio@atliberoMorbi.ca','TYV87KKG4HX','Vernon Deleon','1994-04-29','true','false',
    'ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend.','false');


-- LOCATIONS
INSERT INTO location (name, coordinates, postal_code) VALUES ('Viseu', point(40.6566,7.9125), '3600-246');
INSERT INTO location (name, coordinates, postal_code) VALUES ('Vila Real', point(41.3010,7.7422), '5000-750');
INSERT INTO location (name, coordinates, postal_code) VALUES ('Porto', point(41.1579,8.6291), '4465-500');



-- EVENTS
    -- EVENT 1 -> FOR PIONEIROS  
    -- EVENT 2 -> FOR PIONEIROS -> NEEDS POOL
    -- EVENT 3 -> FOR EXPLORADORES -> NEEDS POOL
    -- EVENT 4 -> FOR CAMINHEIROS
    -- EVENT 5 -> MIXED
    -- EVENT 6 -> USER CREATED EVENT

INSERT INTO event (id,title,description,price,start_date,final_date) 
    VALUES (1,'Aliquam ultrices','tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor',
    10,'2019-10-21 17:00','2019-10-23 19:00');
INSERT INTO event (id,title,description,price,location) 
    VALUES (2,'eu augue','pulvinar',9,1);
INSERT INTO event (id,title,description,price) 
    VALUES (3,'luctus et','non, cursus non, egestas a',6);
INSERT INTO event (id,title,description,price,start_date,final_date,location) 
    VALUES (4,'ut ipsum','ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis',
    5,'2019-07-16 14:04','2020-01-16 22:51',3);
INSERT INTO event (id,title,description,price,start_date,final_date,location) 
    VALUES (5,'eu','ligula. Aenean gravida',2,'2019-09-12 04:40','2019-09-21 07:21',1);
INSERT INTO event (id,title,description,price,start_date,final_date,location) 
    VALUES (6,'mus. Donec dignissim','justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed',
    11,'2019-05-20 10:40','2019-05-21 06:23',2);

    -- EVENT ORGANIZERS

        --Lobitos
    INSERT INTO event_organizer (organizer, event)
        VALUES(22, 1);
        --Pioneiros
    INSERT INTO event_organizer (organizer, event)
        VALUES(23, 2);
        --Exploradores
    INSERT INTO event_organizer (organizer, event)
        VALUES(24, 3);
        --Caminheiros
    INSERT INTO event_organizer (organizer, event)
        VALUES(25, 4);
        --Mixed
    INSERT INTO event_organizer (organizer, event)
        VALUES(22, 5);
    INSERT INTO event_organizer (organizer, event)
        VALUES(23, 5);
    INSERT INTO event_organizer (organizer, event)
        VALUES(17, 5);
        --User created
    INSERT INTO event_organizer (organizer, event)
        VALUES(15, 6);


    -- EVENT PARTICIPANTS
        --Lobitos
    INSERT INTO event_participant (participant, event)
        VALUES(4, 1);
    INSERT INTO event_participant (participant, event)
        VALUES(5, 1);
    INSERT INTO event_participant (participant, event)
        VALUES(6, 1);
    INSERT INTO event_participant (participant, event)
        VALUES(7, 1);
    INSERT INTO event_participant (participant, event)
        VALUES(8, 1);
        --Pioneiros
    INSERT INTO event_participant (participant, event)
        VALUES(9, 2);
    INSERT INTO event_participant (participant, event)
        VALUES(10, 2);
    INSERT INTO event_participant (participant, event)
        VALUES(11, 2);
    INSERT INTO event_participant (participant, event)
        VALUES(12, 2);
        --Exploradores
    INSERT INTO event_participant (participant, event)
        VALUES(13, 3);
    INSERT INTO event_participant (participant, event)
        VALUES(14, 3);
    INSERT INTO event_participant (participant, event)
        VALUES(15, 3);
    INSERT INTO event_participant (participant, event)
        VALUES(16, 3);
        --Caminheiros
    INSERT INTO event_participant (participant, event)
        VALUES(17, 4);  
    INSERT INTO event_participant (participant, event)
        VALUES(18, 4);
    INSERT INTO event_participant (participant, event)
        VALUES(19, 4);
    INSERT INTO event_participant (participant, event)
        VALUES(20, 4);
    INSERT INTO event_participant (participant, event)
        VALUES(21, 4);
        --Mixed
    INSERT INTO event_participant (participant, event)
        VALUES(11, 5);
    INSERT INTO event_participant (participant, event)
        VALUES(6, 5);
    INSERT INTO event_participant (participant, event)
        VALUES(19, 5);
    INSERT INTO event_participant (participant, event)
        VALUES(24, 5);
    INSERT INTO event_participant (participant, event)
        VALUES(13, 5);
    INSERT INTO event_participant (participant, event)
        VALUES(15, 5); 
        --User Created



-- GROUPS
INSERT INTO "group" (id, name, is_section)
    VALUES(1, 'Lobitos', 'true');
INSERT INTO "group" (id, name, is_section)
    VALUES(2, 'Exploradores', 'true');
INSERT INTO "group" (id, name, is_section)
    VALUES(3, 'Pioneiros', 'true');
INSERT INTO "group" (id, name, is_section)
    VALUES(4, 'Caminheiros', 'true');
INSERT INTO "group" (id, name, is_section)
    VALUES(5, 'ViriaTUs', 'false');


    -- GROUP MODERATORS

        --Lobitos
        INSERT INTO group_moderator(moderator, "group")
            VALUES(22, 1);
        --Pioneiros
        INSERT INTO group_moderator(moderator, "group")
            VALUES(23, 2);

        --Exploradores
        INSERT INTO group_moderator(moderator, "group")
            VALUES(24, 3);

        --Caminheiros
        INSERT INTO group_moderator(moderator, "group")
            VALUES(25, 4);


    -- GROUP MEMBER
        --Lobitos
    INSERT INTO group_member(member, "group")
        VALUES(4, 1);
    INSERT INTO group_member(member, "group")
        VALUES(5, 1);
    INSERT INTO group_member(member, "group")
        VALUES(6, 1);
    INSERT INTO group_member(member, "group")
        VALUES(7, 1);
    INSERT INTO group_member(member, "group")
        VALUES(8, 1);
        
        --Pioneiros
    INSERT INTO group_member(member, "group")
        VALUES(9, 2);
    INSERT INTO group_member(member, "group")
        VALUES(10, 2);
    INSERT INTO group_member(member, "group")
        VALUES(11, 2);
    INSERT INTO group_member(member, "group")
        VALUES(12, 2);

        --Exploradores
    INSERT INTO group_member(member, "group")
        VALUES(13, 3);
    INSERT INTO group_member(member, "group")
        VALUES(14, 3);
    INSERT INTO group_member(member, "group")
        VALUES(15, 3);
    INSERT INTO group_member(member, "group")
        VALUES(16, 3);

        --Caminheiros
    INSERT INTO group_member(member, "group")
        VALUES(17, 4);
    INSERT INTO group_member(member, "group")
        VALUES(18, 4);
    INSERT INTO group_member(member, "group")
        VALUES(19, 4);
    INSERT INTO group_member(member, "group")
        VALUES(20, 4);
    INSERT INTO group_member(member, "group")
        VALUES(21, 4);
         


-- CODE

INSERT INTO code (code, description)
    VALUES (1, 'Convite para o');
INSERT INTO code (code, description)
    VALUES (2, 'Comentou no ');
INSERT INTO code (code, description)
    VALUES (3, 'Foste convidado para o');
INSERT INTO code (code, description)
    VALUES (4, 'Foste promovido para');
INSERT INTO code (code, description)
    VALUES (5, 'recebeu');

-- NOTIFICATIONS

INSERT INTO notification (id, code, "user", date)
    VALUES (1, 1, 10, '2019-04-01');
INSERT INTO notification (id, code, "user", date)
    VALUES (2, 2, 14, '2019-04-012');
INSERT INTO notification (id, code, "user", date)
    VALUES (3, 3, 24, '2019-03-31');
INSERT INTO notification (id, code, "user", date)
    VALUES (4, 5, 1, '2019-03-25');
INSERT INTO notification (id, code, "user", date)
    VALUES (5, 1, 17, '2019-03-25');
INSERT INTO notification (id, code, "user", date)
    VALUES (6, 1, 12, '2019-03-25');
    -- NOTIFICATIONS EVENTS

    INSERT INTO notification_event(notification, event)
        VALUES(1, 1);

    INSERT INTO notification_event(notification, event)
        VALUES(2, 3);

    -- NOTIFICATIONS GUARDIANS

    INSERT INTO notification_guardian(notification, guardian)
        VALUES(4, 4);

    -- NOTIFICATIONS GROUPS

    INSERT INTO notification_group(notification, "group")
        VALUES(5, 1);

    INSERT INTO notification_group(notification, "group")
        VALUES(6, 3);


-- POLLS

INSERT INTO poll (id, event, begin_date, end_date)
    VALUES(1, 1, '2019-05-13', '2019-06-20');
    INSERT INTO poll (id, event, begin_date, end_date)
    VALUES(2, 2, '2019-05-20', '2019-07-20');
INSERT INTO poll (id, event, begin_date, end_date)
    VALUES(3, 3, '2019-05-20', '2019-07-20');
INSERT INTO poll (id, event, begin_date, end_date)
    VALUES(4, 4, '2019-05-20', '2019-07-20');

    -- OPTIONS
    INSERT INTO option(id, date, poll)
        VALUES(1, '2019-05-13 10:30', 2);
    INSERT INTO option(id, date, poll)
        VALUES(2, '2019-05-13 12:30', 2);
    INSERT INTO option(id, date, poll)
        VALUES(3, '2019-05-15 9:30', 2);
    INSERT INTO option(id, date, poll)
        VALUES(4, '2019-05-20 11:40', 2);

    INSERT INTO option(id, date, poll)
        VALUES(5, '2019-05-21 10:30', 3);
    INSERT INTO option(id, date, poll)
        VALUES(6, '2019-05-24 12:30', 3);
    INSERT INTO option(id, date, poll)
        VALUES(7, '2019-05-25 9:30', 3);
    INSERT INTO option(id, date, poll)
        VALUES(8, '2019-05-30 11:40', 3);


    -- VOTES
    INSERT INTO vote(voter, option)
        VALUES (9, 1);
    INSERT INTO vote(voter, option)
        VALUES (10, 2);
    INSERT INTO vote(voter, option)
        VALUES (10, 3);
    INSERT INTO vote(voter, option)
        VALUES (11, 2);
    INSERT INTO vote(voter, option)
        VALUES (12, 4);

    INSERT INTO vote(voter, option)
        VALUES (13, 5);
    INSERT INTO vote(voter, option)
        VALUES (13, 6);
    INSERT INTO vote(voter, option)
        VALUES (13, 7);
    INSERT INTO vote(voter, option)
        VALUES (15, 6);
    INSERT INTO vote(voter, option)
        VALUES (16, 6);