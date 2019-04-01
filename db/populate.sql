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

-- Minors
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (4,'eget.venenatis@Donec.co.uk','YMK10JLF1IU','Graiden Walton','2011-09-18',1,'false','false',
    'In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla','false');

INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (5,'diam@temporestac.ca','SFG57CJP9OQ','Ciaran Larson','2006-06-02',1,'false','false',
    'Pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae,','false');

INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (6,'eu@consequatdolorvitae.org','OSY03UEA1WD','Quinn Bell','2013-07-30',2,'false','false',
    'erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla','false');
    
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (7,'mi@aliquamiaculis.ca','JQS83CNI5RE','Len Berry','2010-04-23',1,'false','false',
    'enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim','false');
INSERT INTO "user" (id,email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated) 
	VALUES (8,'tempus@ornare.co.uk','ZQZ35VBO6BN','Yuli Huber','2008-05-03',3,'false','false',
    'ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero','false');


-- Regular
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (9,'elit.pretium.et@semvitaealiquam.ca','DHB08BBU2YQ','Oleg Conley','1999-11-22','true','false',
    'risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (10,'in.tempus.eu@tellus.net','SLW86DWJ0ON','Blake Faulkner','2002-06-23','true','false','
    Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (11,'lectus.justo.eu@magnisdisparturient.org','NRN79MAL6UR','Derek Stein','2002-04-03','true','false',
    'Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (12,'Curae.Donec@leo.net','GOY21DJP6GY','Kennedy Hodges','1999-09-10','true','false',
    'ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus.','false');
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
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (17,'felis.Nulla.tempor@auctorquistristique.edu','EOJ91TSC0FI','William Raymond','2003-06-09','true','false',
    'enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (18,'Nullam.ut@lectusNullam.ca','ZGV73RXV6ZO','Raja Becker','2001-07-25','true','false',
    'Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus,','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (19,'mollis.Phasellus.libero@Etiam.net','NSV94PFK9NZ','Brennan Pena','2000-10-08','true','false',
    'eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (20,'vel.mauris.Integer@Crasloremlorem.co.uk','EWP25ONC1OB','Aaron Moreno','1999-12-03','true','false',
    'imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (21,'Quisque@tristiqueneque.co.uk','RSU43PCX5GV','Palmer Gregory','2002-08-12','true','false',
    'sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida','false');

-- Chiefs
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (22,'vitae@acurna.co.uk','OUN72HCE3TK','Xanthus Peck','1990-02-19','true','false',
    'dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (23,'erat.Etiam@lobortisnisinibh.co.uk','NTE93CSR8GQ','Hall Mayo','1994-08-11','true','false',
    'et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (24,'neque.In.ornare@Duiscursus.com','NQH91ENB3BA','Dexter Golden','1989-02-16','true','false',
    'Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante.','false');
INSERT INTO "user" (id,email,password,name,birthdate,is_responsible,is_guardian,description,deactivated) 
    VALUES (25,'odio@atliberoMorbi.ca','TYV87KKG4HX','Vernon Deleon','1994-04-29','true','false',
    'ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend.','false');