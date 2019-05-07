-- Drop

DROP TABLE IF EXISTS guardian_added_minors CASCADE;
DROP TABLE IF EXISTS guardian_exchange_validation CASCADE;
DROP TABLE IF EXISTS guardian_exchange CASCADE;

DROP TABLE IF EXISTS comment_elimation CASCADE;
DROP TABLE IF EXISTS comment CASCADE;

DROP TABLE IF EXISTS file CASCADE;
DROP TABLE IF EXISTS vote CASCADE;
DROP TABLE IF EXISTS option CASCADE;
DROP TABLE IF EXISTS poll CASCADE;

DROP TABLE IF EXISTS notification_group CASCADE;
DROP TABLE IF EXISTS notification_guardian CASCADE;
DROP TABLE IF EXISTS notification_event CASCADE;
DROP TABLE IF EXISTS notification CASCADE;

DROP TABLE IF EXISTS event_group CASCADE;

DROP TABLE IF EXISTS event_organizer CASCADE;
DROP TABLE IF EXISTS event_participant CASCADE;
DROP TABLE IF EXISTS event CASCADE;

DROP TABLE IF EXISTS group_member CASCADE;
DROP TABLE IF EXISTS group_moderator CASCADE;

DROP TABLE IF EXISTS items CASCADE;
DROP TABLE IF EXISTS cards CASCADE;

DROP TABLE IF EXISTS "user" CASCADE;

DROP TABLE IF EXISTS registration_handling CASCADE;
DROP TABLE IF EXISTS registration_request_guardian CASCADE;
DROP TABLE IF EXISTS registration_request CASCADE;

DROP TABLE IF EXISTS group_elimination CASCADE;
DROP TABLE IF EXISTS user_elimination CASCADE;
DROP TABLE IF EXISTS admin CASCADE;

DROP TABLE IF EXISTS location CASCADE;
DROP TABLE IF EXISTS "group" CASCADE;
DROP TABLE IF EXISTS code CASCADE;

DROP TYPE IF EXISTS NotificationState CASCADE;
DROP TYPE IF EXISTS ParticipationStatus CASCADE;
DROP TYPE IF EXISTS RegisterStatus CASCADE;
DROP TYPE IF EXISTS ReserverGroupNames CASCADE;

DROP TRIGGER IF EXISTS event_check_organizer ON event_organizer;
DROP FUNCTION IF EXISTS event_check_organizer();

DROP TRIGGER IF EXISTS event_group_add ON event_group;
DROP FUNCTION IF EXISTS event_group_add();

DROP TRIGGER IF EXISTS verify_participation ON vote;
DROP FUNCTION IF EXISTS verify_part_procedure();

DROP TRIGGER IF EXISTS notification_event_trigger ON notification_event;
DROP FUNCTION IF EXISTS notification_event_procedure();

DROP TRIGGER IF EXISTS notification_guardian_trigger ON notification_guardian;
DROP FUNCTION IF EXISTS notification_guardian_procedure();

DROP TRIGGER IF EXISTS notification_group_trigger ON notification_group;
DROP FUNCTION IF EXISTS notification_group_procedure();

DROP TRIGGER IF EXISTS group_name ON "group";
DROP FUNCTION IF EXISTS check_group_name();

DROP TRIGGER IF EXISTS check_is_section ON "group";
DROP FUNCTION IF EXISTS check_is_section();

DROP TRIGGER IF EXISTS group_deletion ON "group";
DROP FUNCTION IF EXISTS check_group_events();

DROP TRIGGER IF EXISTS group_check_moderator ON group_moderator;
DROP FUNCTION IF EXISTS group_check_moderator();

DROP TRIGGER IF EXISTS eliminate_user ON "user";
DROP FUNCTION IF EXISTS eliminate_user();


DROP TRIGGER IF EXISTS event_insert_vectors ON event;
DROP TRIGGER IF EXISTS event_update_vectors ON event;
DROP FUNCTION IF EXISTS manage_event_tsvectors();

DROP TRIGGER IF EXISTS group_insert_vectors ON event;
DROP TRIGGER IF EXISTS group_update_vectors ON event;
DROP FUNCTION IF EXISTS manage_group_tsvector();

DROP TRIGGER IF EXISTS user_insert_vectors ON event;
DROP TRIGGER IF EXISTS user_update_vectors ON event;
DROP FUNCTION IF EXISTS manage_user_tsvector();



-- Types

CREATE TYPE NotificationState AS ENUM ('Seen', 'Not Seen');

CREATE TYPE ParticipationStatus AS ENUM ('Going', 'Not Going', 'Pending');

CREATE TYPE RegisterStatus AS ENUM ('Accepted', 'Rejected', 'Pending');

CREATE TYPE ReserverGroupNames AS ENUM ('lobitos', 'pioneiros', 'exploradores', 'caminheiros');



-- Tables

CREATE TABLE "user" (
                        id SERIAL PRIMARY KEY,
                        email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
                        password text NOT NULL,
                        name text NOT NULL,
                        birthdate DATE NOT NULL,
                        guardian INTEGER REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE,
                        is_responsible BOOLEAN NOT NULL,
                        is_guardian BOOLEAN NOT NULL,
                        description text NOT NULL,
                        deactivated BOOLEAN NOT NULL DEFAULT 'false',
                        vector tsvector,
                        remember_token VARCHAR
);



CREATE TABLE registration_request(
                                     id SERIAL PRIMARY KEY,
                                     name TEXT NOT NULL,
                                     email TEXT NOT NULL UNIQUE,
                                     password TEXT NOT NULL,
                                     birthdate DATE NOT NULL,
                                     state RegisterStatus DEFAULT 'Pending' NOT NULL,
                                     description TEXT NOT NULL
);

CREATE TABLE location(
                         id SERIAL PRIMARY KEY,
                         name text NOT NULL,
                         coordinates POINT NOT NULL,
                         postal_code varchar(9),
                         CONSTRAINT proper_postal_code CHECK (postal_code ~* '^[0-9]{4}-[0-9]{3}$')
);

CREATE TABLE event(
                      id SERIAL PRIMARY KEY,
                      title text NOT NULL,
                      description text,
                      price REAL NOT NULL DEFAULT 0,
                      start_date TIMESTAMP,
                      final_date TIMESTAMP,
                      location INTEGER REFERENCES location (id) ON UPDATE CASCADE,
                      vector tsvector,
                      CONSTRAINT start_date_limit CHECK (start_date < CURRENT_DATE + interval '1 year')
);

CREATE TABLE guardian_exchange(
                                  id SERIAL PRIMARY KEY,
                                  minor INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
                                  new_guardian INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
                                  state RegisterStatus NOT NULL DEFAULT 'Pending'
);

CREATE TABLE guardian_added_minors(
                                      request INTEGER PRIMARY KEY REFERENCES registration_request (id) ON UPDATE CASCADE,
                                      guardian INTEGER NOT NULL REFERENCES "user"(id) ON UPDATE CASCADE
);

CREATE TABLE event_participant(
                                  participant INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                                  event INTEGER REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
                                  state ParticipationStatus NOT NULL DEFAULT 'Pending',
                                  PRIMARY KEY (participant, event)
);

CREATE TABLE event_organizer(
                                organizer INTEGER REFERENCES "user" (id) ON UPDATE CASCADE,
                                event INTEGER REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
                                PRIMARY KEY (organizer, event)
);

CREATE TABLE comment(
                        id SERIAL PRIMARY KEY,
                        participant INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
                        event INTEGER NOT NULL REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
                        date TIMESTAMP NOT NULL DEFAULT NOW(),
                        "text" text NOT NULL
);

CREATE TABLE file(
                     id SERIAL PRIMARY KEY,
                     title text NOT NULL,
                     contents bytea NOT NULL,
                     event INTEGER NOT NULL REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
                     UNIQUE(title, event)
);

CREATE TABLE poll(
                     id SERIAL PRIMARY KEY,
                     event INTEGER REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
                     begin_date DATE NOT NULL DEFAULT CURRENT_DATE,
                     end_date DATE NOT NULL,
                     CONSTRAINT poll_date_ck CHECK (end_date > begin_date)
);

CREATE TABLE option(
                       id SERIAL PRIMARY KEY,
                       date TIMESTAMP NOT NULL,
                       poll INTEGER NOT NULL REFERENCES poll (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE vote(
                     voter INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                     option INTEGER NOT NULL REFERENCES option (id) ON UPDATE CASCADE ON DELETE CASCADE,
                     PRIMARY KEY (voter, option)
);

CREATE TABLE comment_elimation(
                                  comment INTEGER PRIMARY KEY REFERENCES comment (id) ON DELETE CASCADE,
                                  "user" INTEGER NOT NULL REFERENCES "user" (id) ON DELETE SET NULL,
                                  "date" DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE "group"(
                        id SERIAL PRIMARY KEY,
                        name text NOT NULL,
                        is_section BOOLEAN NOT NULL DEFAULT FALSE,
                        vector tsvector
);

CREATE TABLE group_member(
                             member INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                             "group" INTEGER REFERENCES "group" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                             PRIMARY KEY(member, "group")
);

CREATE TABLE group_moderator(
                                moderator INTEGER REFERENCES "user" (id) ON UPDATE CASCADE,
                                "group" INTEGER REFERENCES "group" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                                PRIMARY KEY(moderator, "group")
);

CREATE TABLE event_group(
                            event INTEGER REFERENCES event (id) ON UPDATE CASCADE,
                            "group" INTEGER REFERENCES "group" (id) ON UPDATE CASCADE,
                            PRIMARY KEY(event, "group")
);

CREATE TABLE code(
                     code SERIAL PRIMARY KEY ,
                     description TEXT NOT NULL
);

/*CREATE TABLE notification(
                             id SERIAL PRIMARY KEY,
                             code INTEGER REFERENCES code NOT NULL,
                             "user" INTEGER NOT NULL REFERENCES "user" ON DELETE CASCADE,
                             date DATE NOT NULL DEFAULT CURRENT_DATE,
                             state NotificationState NOT NULL DEFAULT 'Not Seen'
);

CREATE TABLE notification_event(
                                   notification INTEGER PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
                                   event INTEGER NOT NULL REFERENCES event ON DELETE CASCADE
);

CREATE TABLE notification_guardian(
                                      notification INTEGER PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
                                      guardian INTEGER NOT NULL REFERENCES "user" ON DELETE CASCADE
);

CREATE TABLE notification_group(
                                   notification INTEGER PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
                                   "group" INTEGER NOT NULL REFERENCES "group" ON DELETE CASCADE
);
*/

CREATE TABLE admin(
                      id SERIAL PRIMARY KEY ,
                      email TEXT NOT NULL UNIQUE,
                      password TEXT NOT NULL
);

CREATE TABLE group_elimination(
                                  id SERIAL PRIMARY KEY ,
                                  admin INTEGER REFERENCES admin,
                                  group_name TEXT NOT NULL,
                                  "date" DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE user_elimination(
                                 id SERIAL PRIMARY KEY ,
                                 admin INTEGER REFERENCES admin NOT NULL,
                                 user_name TEXT NOT NULL,
                                 "date" DATE  NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE guardian_exchange_validation(
                                             exchange INTEGER PRIMARY KEY REFERENCES guardian_exchange,
                                             admin INTEGER REFERENCES admin NOT NULL,
                                             "date" DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE registration_handling(
                                      request INTEGER PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
                                      admin INTEGER REFERENCES admin NOT NULL,
                                      "date" DATE  NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE registration_request_guardian(
                                              minor INTEGER PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
                                              g_name TEXT NOT NULL,
                                              g_email TEXT NOT NULL UNIQUE,
                                              g_password TEXT NOT NULL UNIQUE,
                                              g_birthdate DATE NOT NULL,
                                              g_description TEXT NOT NULL
);

-- Triggers

CREATE FUNCTION event_check_organizer() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
            SELECT event_organizer.event FROM event_organizer
            WHERE event_organizer.event = OLD.event
            GROUP BY event_organizer.event
            HAVING COUNT(*) = 1)
    THEN
        IF EXISTS
            (SELECT * FROM event
             WHERE OLD.event = event.id
               AND event.final_date IS NOT NULL
               AND event.final_date > CURRENT_DATE
            )
        THEN
            RAISE EXCEPTION 'An event cannot lose all organizers before it ends';
        END IF;
    END IF;
    RETURN OLD;
END
$BODY$
    LANGUAGE plpgsql;


CREATE TRIGGER event_check_organizer
    BEFORE DELETE ON event_organizer
    FOR EACH ROW
EXECUTE PROCEDURE event_check_organizer();


CREATE FUNCTION event_group_add() RETURNS TRIGGER AS
$BODY$
BEGIN
    INSERT INTO event_participant (participant, event, state)
    SELECT group_member.member, NEW.event, 'Pending'
    FROM group_member
    WHERE
            group_member."group" = NEW."group"
      AND group_member.member NOT IN
          (SELECT event_participant.participant
           FROM event_participant
           WHERE event_participant.event = NEW.event);
    RETURN NEW;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER event_group_add
    AFTER INSERT ON event_group
    FOR EACH ROW
EXECUTE PROCEDURE event_group_add();


CREATE FUNCTION verify_part_procedure() RETURNS trigger AS $BODY$
BEGIN

    IF NOT EXISTS (
            SELECT *
            FROM option, poll, event, event_participant
            WHERE NEW.option = option.id AND option.poll = poll.id AND poll.event = event_participant.event AND event_participant.participant = NEW.voter
        ) THEN
        RAISE EXCEPTION 'You are not allowed to vote in this event';
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;


CREATE TRIGGER verify_participation
    BEFORE INSERT ON vote
    FOR EACH ROW
EXECUTE PROCEDURE verify_part_procedure();


/*--Notification triggers

CREATE FUNCTION notification_event_procedure() RETURNS trigger AS $BODY$
BEGIN
    IF EXISTS (
            SELECT NEW.notification
            FROM notification_group
            WHERE NEW.notification = notification_group.notification
            UNION ALL
            SELECT NEW.notification
            FROM notification_guardian
            WHERE NEW.notification = notification_guardian.notification
        ) THEN
        RAISE EXCEPTION 'ERROR: Notification already assign';
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;


CREATE TRIGGER notification_event_trigger
    BEFORE INSERT ON notification_event
    FOR EACH ROW
EXECUTE PROCEDURE notification_event_procedure();



CREATE FUNCTION notification_guardian_procedure() RETURNS trigger AS $BODY$
BEGIN
    IF EXISTS (
            SELECT NEW.notification
            FROM notification_group
            WHERE NEW.notification = notification_group.notification
            UNION ALL
            SELECT NEW.notification
            FROM notification_event
            WHERE NEW.notification = notification_event.notification
        ) THEN
        RAISE EXCEPTION 'ERROR: Notification already assign';
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;


CREATE TRIGGER notification_guardian_trigger
    BEFORE INSERT ON notification_guardian
    FOR EACH ROW
EXECUTE PROCEDURE notification_guardian_procedure();



CREATE FUNCTION notification_group_procedure() RETURNS trigger AS $BODY$
BEGIN
    IF EXISTS (
            SELECT NEW.notification
            FROM notification_guardian
            WHERE NEW.notification = notification_guardian.notification
            UNION ALL
            SELECT NEW.notification
            FROM notification_event
            WHERE NEW.notification = notification_event.notification
        ) THEN
        RAISE EXCEPTION 'ERROR: Notification already assign';
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;

CREATE TRIGGER notification_group_trigger
    BEFORE INSERT ON notification_group
    FOR EACH ROW
EXECUTE PROCEDURE notification_group_procedure();*/

-- Nome dos grupos

CREATE FUNCTION check_group_name() RETURNS trigger AS $BODY$
BEGIN
    IF ( SELECT lower(NEW.name) = any (enum_range(null::ReserverGroupNames)::name[]) ) THEN
        IF EXISTS (SELECT true FROM "group" WHERE lower("group".name) = lower(NEW.name)) THEN
            RAISE EXCEPTION 'ERROR: Cannot create a new group with that name';
        END IF;
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;

CREATE TRIGGER group_name
    BEFORE INSERT ON "group"
    FOR EACH ROW
EXECUTE PROCEDURE check_group_name();


-- Impedir que se apaguem as secções
CREATE FUNCTION check_is_section() RETURNS trigger AS $BODY$
BEGIN
    IF ( SELECT lower(OLD.name) = any (enum_range(null::ReserverGroupNames)::name[]) ) THEN
        RAISE EXCEPTION 'ERROR: Cannot delete a scouting section';
    END IF;
    RETURN NEW;
END;
$BODY$ LANGUAGE plpgsql;

CREATE TRIGGER section_deletion
    BEFORE DELETE ON "group"
    FOR EACH ROW
EXECUTE PROCEDURE check_is_section();


-- Impedir remover grupos se houver eventos a decorrer
CREATE FUNCTION check_group_events() RETURNS trigger AS $BODY$
BEGIN
    IF EXISTS
        ( SELECT * FROM event_group, event
          WHERE event_group."group" = OLD.id
            AND event.id = event_group.event
            AND event.start_date IS NOT NULL
            AND (
                  (event.start_date > CURRENT_DATE)
                  OR
                  (event.final_date IS NOT NULL AND event.final_date > CURRENT_DATE)
              ))

    THEN
        RAISE EXCEPTION 'ERROR: Cannot delete a group if there are events yet to be held';
    END IF;
    RETURN OLD;
END;
$BODY$ LANGUAGE plpgsql;

CREATE TRIGGER group_deletion
    BEFORE DELETE ON "group"
    FOR EACH ROW
EXECUTE PROCEDURE check_group_events();


-- Impedir que um grupo fique sem moderadores
CREATE FUNCTION group_check_moderator() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(
            SELECT group_moderator."group" FROM group_moderator
            WHERE group_moderator."group" = OLD."group"
            GROUP BY group_moderator."group"
            HAVING COUNT(*) = 1)
    THEN
        RAISE EXCEPTION 'ERROR: A group cannot lose all moderators.';
    END IF;
    RETURN OLD;
END
$BODY$
    LANGUAGE plpgsql;


CREATE TRIGGER group_check_moderator
    BEFORE DELETE ON group_moderator
    FOR EACH ROW
EXECUTE PROCEDURE group_check_moderator();


-- Verificar que pode eliminar conta

CREATE FUNCTION eliminate_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM event_organizer WHERE event_organizer.organizer = OLD.id;
    DELETE FROM group_moderator WHERE group_moderator.moderator = OLD.id;
    RETURN OLD;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER eliminate_user
    BEFORE DELETE ON "user"
    FOR EACH ROW
EXECUTE PROCEDURE eliminate_user();


-- TS vectors
CREATE FUNCTION manage_event_tsvectors() RETURNS trigger AS $BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        new.vector =
                (
                        setweight(to_tsvector('Portuguese',new.title), 'A')                     ||
                        setweight(to_tsvector('Portuguese',coalesce(new.description,'')),'C')      ||
                        setweight(to_tsvector('Portuguese',coalesce((select name from location where new.location=location.id),'')),'A')
                    );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (new.title <> old.title || new.description <> old.description || new.location <> old.location)  THEN
            new.vector =
                    (
                            setweight(to_tsvector('Portuguese',new.title), 'A')                     ||
                            setweight(to_tsvector('Portuguese',coalesce(new.description,'')),'C')      ||
                            setweight(to_tsvector('Portuguese',coalesce((select name from location where new.location=location.id),'')),'A')
                        );
        END IF;
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE TRIGGER event_insert_vectors
    BEFORE INSERT ON event
    FOR EACH ROW
EXECUTE PROCEDURE manage_event_tsvectors();

CREATE TRIGGER event_update_vectors
    BEFORE UPDATE ON event
    FOR EACH ROW
EXECUTE PROCEDURE manage_event_tsvectors();


CREATE FUNCTION manage_group_tsvector() RETURNS trigger AS $BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        new.vector = to_tsvector('Portuguese', new.name);
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (new.name <> old.name)  THEN
            new.vector = to_tsvector('Portuguese', new.name);
        END IF;
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE TRIGGER group_insert_vectors
    BEFORE INSERT ON "group"
    FOR EACH ROW
EXECUTE PROCEDURE manage_group_tsvector();

CREATE TRIGGER group_update_vectors
    BEFORE UPDATE ON "group"
    FOR EACH ROW
EXECUTE PROCEDURE manage_group_tsvector();


CREATE FUNCTION manage_user_tsvector() RETURNS trigger AS $BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        new.vector = to_tsvector('Portuguese', new.name);
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (new.name <> old.name)  THEN
            new.vector = to_tsvector('Portuguese', new.name);
        END IF;
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE TRIGGER user_insert_vectors
    BEFORE INSERT ON "user"
    FOR EACH ROW
EXECUTE PROCEDURE manage_user_tsvector();

CREATE TRIGGER user_update_vectors
    BEFORE UPDATE ON "user"
    FOR EACH ROW
EXECUTE PROCEDURE manage_user_tsvector();


-- Indexes
/*
CREATE INDEX user_notifications ON notification USING hash("user"); -- (?) WHERE state = 'Not Seen'*/

--pesquisa de eventos por data inicial
CREATE INDEX search_event_date_begin ON event USING btree (start_date);

--pesquisa de eventos por data final
CREATE INDEX search_event_date_final ON event USING btree (final_date);

--pesquisa de comentários de um evento
CREATE INDEX event_comments ON comment USING hash(event);

--pesquisa de minors
create INDEX guardians ON "user" USING hash(guardian) WHERE guardian IS NOT NULL;

--pesquisa fts events
CREATE INDEX search_event ON event USING GIN (vector);

--pesquisa fts grupos
CREATE INDEX search_group ON "group" USING GIN (vector);

--pesquisa fts users
CREATE INDEX search_user ON "user" USING GIN (vector);



--  USER

-- 2009 - 2019 -> Lobitos
-- 2005 - 2008 -> Pioneiros
-- 2001 - 2004 -> Exploradores
-- 1997 - 2000 -> Caminheiros

-- Guardians
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('john@example.com','$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W','Berk Ellison','1986-02-16','true','true',
        'semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('tincidunt.neque@nequevenenatis.net','BHW02JZG5KM','Patrick Rollins','1989-11-16','true','true',
        'mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('sed.libero.Proin@aliquetvel.co.uk','KSK38RGF8HH','Amery Contreras','1972-05-20','true','true',
        'mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc.','false');

-- Users that have a guardian: 4 - 5 - 6 - 7 - 8

-- Regular/Lobitos
INSERT INTO "user" (email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated)
VALUES ('eget.venenatis@Donec.co.uk','YMK10JLF1IU','Graiden Walton','2010-09-18',1,'false','false',
        'In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla','false');

INSERT INTO "user" (email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated)
VALUES ('diam@temporestac.ca','SFG57CJP9OQ','Ciaran Larson','2013-06-02',1,'false','false',
        'Pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae,','false');

INSERT INTO "user" (email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated)
VALUES ('eu@consequatdolorvitae.org','OSY03UEA1WD','Quinn Bell','2012-07-30',2,'false','false',
        'erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla','false');

INSERT INTO "user" (email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated)
VALUES ('mi@aliquamiaculis.ca','JQS83CNI5RE','Len Berry','2011-04-23',1,'false','false',
        'enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim','false');
INSERT INTO "user" (email,password,name,birthdate,guardian,is_responsible,is_guardian,description,deactivated)
VALUES ('tempus@ornare.co.uk','ZQZ35VBO6BN','Yuli Huber','2009-05-03',3,'false','false',
        'ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero','false');


-- Regular/Pioneiros
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('elit.pretium.et@semvitaealiquam.ca','DHB08BBU2YQ','Oleg Conley','2008-11-22','true','false',
        'risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque.','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('in.tempus.eu@tellus.net','SLW86DWJ0ON','Blake Faulkner','2007-06-23','true','false','
    Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('lectus.justo.eu@magnisdisparturient.org','NRN79MAL6UR','Derek Stein','2005-04-03','true','false',
        'Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('Curae.Donec@leo.net','GOY21DJP6GY','Kennedy Hodges','2006-09-10','true','false',
        'ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus.','false');

--Regular/Exploradores
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('sem.consequat.nec@turpisegestas.co.uk','LBJ29RFE1EC','Howard Zimmerman','2002-12-17','true','false',
        'Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('lectus.Cum.sociis@ullamcorperDuis.com','DTR23ONX4ZB','Dolan Harper','2001-06-05','true','false',
        'Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('eget@placeratvelit.ca','NCH23QHS8TU','Dale Poole','1999-09-19','true','false',
        'quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('eu.eros.Nam@sodalespurusin.net','FDS69ABK8IP','Justin Perez','2003-10-12','true','false',
        'a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam','false');

--Regular/Caminheiros
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('felis.Nulla.tempor@auctorquistristique.edu','EOJ91TSC0FI','William Raymond','1998-06-09','true','false',
        'enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('Nullam.ut@lectusNullam.ca','ZGV73RXV6ZO','Raja Becker','1999-07-25','true','false',
        'Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus,','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('mollis.Phasellus.libero@Etiam.net','NSV94PFK9NZ','Brennan Pena','2000-10-08','true','false',
        'eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('vel.mauris.Integer@Crasloremlorem.co.uk','EWP25ONC1OB','Aaron Moreno','1997-12-03','true','false',
        'imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate','false');
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('Quisque@tristiqueneque.co.uk','RSU43PCX5GV','Palmer Gregory','2000-08-12','true','false',
        'sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida','false');

-- Chiefs

--Lobitos
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('vitae@acurna.co.uk','OUN72HCE3TK','Xanthus Peck','1990-02-19','true','false',
        'dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl.','false');

--Pioneiros
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('erat.Etiam@lobortisnisinibh.co.uk','NTE93CSR8GQ','Hall Mayo','1993-08-11','true','false',
        'et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis','false');

--Exploradores
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('neque.In.ornare@Duiscursus.com','NQH91ENB3BA','Dexter Golden','1989-02-16','true','false',
        'Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante.','false');

--Caminheiros
INSERT INTO "user" (email,password,name,birthdate,is_responsible,is_guardian,description,deactivated)
VALUES ('odio@atliberoMorbi.ca','TYV87KKG4HX','Vernon Deleon','1994-04-29','true','false',
        'ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend.','false');


-- LOCATIONS
INSERT INTO location (name, coordinates, postal_code) VALUES ('Viseu', point(40.6566,7.9125), '3600-246');
INSERT INTO location (name, coordinates, postal_code) VALUES ('Vila Real', point(41.3010,7.7422), '5000-750');
INSERT INTO location (name, coordinates, postal_code) VALUES ('Porto', point(41.1579,8.6291), '4465-500');
INSERT INTO location (name, coordinates, postal_code) VALUES ('Canas de Senhorim', point(41.1579,8.6291), '4465-500');


-- EVENTS
-- EVENT 1 -> FOR PIONEIROS
-- EVENT 2 -> FOR PIONEIROS -> NEEDS POOL
-- EVENT 3 -> FOR EXPLORADORES -> NEEDS POOL
-- EVENT 4 -> FOR CAMINHEIROS
-- EVENT 5 -> MIXED
-- EVENT 6 -> USER CREATED EVENT

INSERT INTO event (title,description,price,start_date,final_date)
VALUES ('Acampamento Regional dos Pioneiros','tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor',
        10,'2019-10-21 17:00','2019-10-23 19:00');
INSERT INTO event (title,description,price,location)
VALUES ('Atividade de secção','pulvinar',9,1);
INSERT INTO event (title,description,price)
VALUES ('Kimeras','non, cursus non, egestas a',6);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('Acampamento para os noviços','ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis',
        5,'2019-07-16 14:04','2020-01-16 22:51',3);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('ACAVER','Acampamento de verao',2,'2019-09-12 04:40','2019-09-21 07:21',1);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('Quo Vadis','É um acampamento para caminheiros na região de viseu',
        11,null,null,4);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('Pedra Angular','Acampamento para integração dos noviços na secção dos Caminheros',
        11,'2019-05-20 10:40','2019-05-21 06:23',2);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('ACAREG','Acampamento regional',
        11,'2019-05-20 10:40','2019-05-21 06:23',2);
INSERT INTO event (title,description,price,start_date,final_date,location)
VALUES ('Lavagem de carros','Atividade de angariação de fundos dos caminheiros para o ACAVER ',
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
INSERT INTO event_organizer (organizer, event)
VALUES(1, 5);
--User created
INSERT INTO event_organizer (organizer, event)
VALUES(15, 6);





-- EVENT PARTICIPANTS
--Lobitos 4-5-6-7-8
-- can be achived by adding an entry to event_group, due to the trigger

--Pioneiros 9-10-11-12
-- can be achived by adding an entry to event_group, due to the trigger

--Exploradores 13-14-15-16
-- can be achived by adding an entry to event_group, due to the trigger

--Caminheiros 17-18-19-20
-- can be achived by adding an entry to event_group, due to the trigger

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

INSERT INTO event_participant(participant, event, state)
VALUES(1, 6, 'Going');
INSERT INTO event_participant(participant, event, state)
VALUES(1, 7, 'Pending');
INSERT INTO event_participant(participant, event, state)
VALUES(1, 9, 'Pending');

INSERT INTO event_participant(participant, event, state)
VALUES(9, 6, 'Going');


--User Created


-- COMMENTS
INSERT INTO comment (participant, event, "text")
VALUES(13, 3, 'Este evento vai ser mesmo fixe!');

INSERT INTO comment (participant, event, "text")
VALUES(20, 4, 'Vamos!');

INSERT INTO comment (participant, event, "text")
VALUES(12, 2, 'Gosto de ser Escuteiro!');

INSERT INTO comment (participant, event, "text")
VALUES(13, 6, 'Este evento vai ser mesmo fixe!');

INSERT INTO comment (participant, event, "text")
VALUES(20, 6, 'Vamos!');

INSERT INTO comment (participant, event, "text")
VALUES(12, 6, 'Gosto de ser Escuteiro!');

INSERT INTO comment (participant, event, "text")
VALUES(13, 5, 'Este evento vai ser mesmo fixe!');

INSERT INTO comment (participant, event, "text")
VALUES(20, 5, 'Vamos!');

-- FILES

INSERT INTO file(event, title, contents) VALUES(6, 'Atividades.pdf', '');
INSERT INTO file(event, title, contents) VALUES(6, 'Mantimentos.pdf', '');
INSERT INTO file(event, title, contents) VALUES(5, 'Horário.pdf', '');


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

--ViriaTUs
INSERT INTO group_moderator(moderator, "group")
VALUES(25, 5);


-- GROUP MEMBER
--Lobitos
INSERT INTO group_member(member, "group")
VALUES(1, 3);
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
INSERT INTO group_member(member,"group")
Values(1,2);

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

INSERT INTO group_member(member,"group")
Values(1,4);


-- EVENT GROUP

INSERT INTO event_group(event, "group")
VALUES(1, 1);
INSERT INTO event_group(event, "group")
VALUES(2, 2);
INSERT INTO event_group(event, "group")
VALUES(3, 3);
INSERT INTO event_group(event, "group")
VALUES(4, 4);
INSERT INTO event_group(event, "group")
VALUES(5, 3);
INSERT INTO event_group(event, "group")
VALUES(5, 4);
INSERT INTO event_group(event, "group")
VALUES(6, 3);



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

/*-- NOTIFICATIONS

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
VALUES(6, 3);*/


-- POLLS

INSERT INTO poll (id, event, begin_date, end_date)
VALUES(1, 1, '2019-05-13', '2019-06-20');
INSERT INTO poll (id, event, begin_date, end_date)
VALUES(2, 2, '2019-05-20', '2019-07-20');
INSERT INTO poll (id, event, begin_date, end_date)
VALUES(3, 3, '2019-05-20', '2019-07-20');
INSERT INTO poll (id, event, begin_date, end_date)
VALUES(4, 4, '2019-05-20', '2019-07-20');
INSERT INTO poll (id, event, begin_date, end_date)
VALUES(5, 6, '2019-05-20', '2019-07-20');

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

INSERT INTO option(id, date, poll)
VALUES(9, '2019-05-30 11:40', 5);
INSERT INTO option(id, date, poll)
VALUES(10, '2019-05-30 11:40', 5);
INSERT INTO option(id, date, poll)
VALUES(11, '2019-05-30 11:40', 5);


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

INSERT INTO vote(voter, option)
VALUES (9, 10);
INSERT INTO vote(voter, option)
VALUES (9, 11);
INSERT INTO vote(voter, option)
VALUES (9, 9);
INSERT INTO vote(voter, option)
VALUES (13, 10);




-- ADMIN
INSERT INTO admin(id, email, password)
VALUES (1, 'agrupa-admin@agrupa.com','$2y$12$S7AhzhobTdNsi1bLGKd1A.1Bu7yVlrib9P1hfiY65K7K7hKgyq4Cq');


-- REGISTRATION

INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Lee George','magna.nec.quam@euodio.ca','AON60VAC6DU','2001-10-16','Pending',
        'Cras sed leo. Cras');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Leo Rogers','Sed.eu.nibh@neceuismod.ca','ALA87SFW4HP','2008-07-15','Pending',
        'In tincidunt congue turpis. In condimentum.');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Thor Lee','arcu@urnaNunc.ca','CNO80QJB5CX','2004-03-15','Pending',
        'consectetuer adipiscing elit. Etiam laoreet,');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Thor Castaneda','erat@commodoatlibero.org','HMM34FTE4VQ','2013-04-10','Pending',
        'diam. Sed diam lorem,');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Cedric Dickson','fermentum.vel.mauris@mattisvelitjusto.co.uk','HZJ37OJC4XV','1996-04-13','Pending',
        'feugiat placerat velit. Quisque');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Kasimir Hancock','malesuada.malesuada@turpis.co.uk','WWI42NGW2NV','1997-09-28','Pending',
        'nibh. Aliquam ornare, libero at');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Herman Tyson','mus.Donec.dignissim@ipsumcursusvestibulum.net','ZTJ80LED4CI','1996-04-06','Pending',
        'mauris erat eget ipsum. Suspendisse sagittis.');
INSERT INTO registration_request (name,email,password,birthdate,state,description)
VALUES ('Victor Booth','at.fringilla@auctorvitae.org','HFG73YTJ5OX','2005-10-21','Pending',
        'imperdiet ornare. In faucibus.');

-- REGISTRATION WITH GUARDIAN
INSERT INTO registration_request_guardian (minor,g_name,g_email,g_password,g_birthdate,g_description)
VALUES (1,'Linus Ashley','suscipit@urnaconvallis.edu','FVF13TKW5LF','1953-10-03','velit. Pellentesque ultricies dignissim lacus. Aliquam');
INSERT INTO registration_request_guardian (minor,g_name,g_email,g_password,g_birthdate,g_description)
VALUES (2,'Shad York','elementum.lorem@Aeneaneget.edu','KPK78MWN1GD','1954-08-02','auctor non, feugiat nec,');
INSERT INTO registration_request_guardian (minor,g_name,g_email,g_password,g_birthdate,g_description)
VALUES (3,'Jasper Britt','Vivamus.non.lorem@semegestasblandit.ca','ZNS55MQS4MK','1965-05-31','Aliquam erat volutpat. Nulla');
INSERT INTO registration_request_guardian (minor,g_name,g_email,g_password,g_birthdate,g_description)
VALUES (4,'Felix Gallegos','libero.Proin@Nulla.co.uk','AXC64KUA5PW','1952-10-29','congue a, aliquet vel, vulputate eu,');

-- ADDED MINORS
INSERT INTO guardian_added_minors(request, guardian)
VALUES (8, 3);

-- GUARDIAN EXCHANGE
--Request to make User 2 the new guardian of the User 1 (previous guardian -> 1)
INSERT INTO guardian_exchange(id, minor, new_guardian)
VALUES(1, 4, 2);


