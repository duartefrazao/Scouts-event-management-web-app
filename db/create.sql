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

DROP TABLE IF EXISTS "user" CASCADE;

DROP TABLE IF EXISTS registration_request_handling CASCADE;
DROP TABLE IF EXISTS registration_handling CASCADE;
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


DROP FUNCTION IF EXISTS check_moderator() CASCADE;
DROP FUNCTION IF EXISTS event_group_add() CASCADE;


DROP TRIGGER IF EXISTS check_moderator ON event_organizer CASCADE;
DROP TRIGGER IF EXISTS event_group_add ON event_group CASCADE;


DROP TRIGGER IF EXISTS verify_participation ON vote CASCADE;
DROP FUNCTION IF EXISTS verify_part_procedure() CASCADE;



-- Types

CREATE TYPE NotificationState AS ENUM ('Seen', 'Not Seen');

CREATE TYPE ParticipationStatus AS ENUM ('Going', 'Not Going', 'Pending');

CREATE TYPE RegisterStatus AS ENUM ('Accepted', 'Rejected', 'Pending');



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
   deactivated BOOLEAN NOT NULL
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
   start_date DATE,
   final_date DATE,
   location INTEGER REFERENCES location (id) ON UPDATE CASCADE
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
   date DATE NOT NULL DEFAULT CURRENT_DATE,
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
   date DATE NOT NULL,
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
   is_section BOOLEAN NOT NULL DEFAULT FALSE
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

CREATE TABLE notification(
    id SERIAL PRIMARY KEY,
    code INTEGER REFERENCES code NOT NULL,
    "user" INTEGER NOT NULL REFERENCES "user" ON DELETE CASCADE,
    date DATE NOT NULL,
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
    admin INTEGER REFERENCES admin NOT NULL
);

CREATE TABLE registration_handling(
    request SERIAL PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
    admin INTEGER REFERENCES admin NOT NULL,
    "date" DATE  NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE registration_request_handling(
    minor SERIAL PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
    g_name TEXT NOT NULL,
    g_email TEXT NOT NULL UNIQUE,
    g_password TEXT NOT NULL UNIQUE,
    g_birthdate DATE NOT NULL,
    g_description TEXT NOT NULL
);



CREATE FUNCTION check_moderator() RETURNS TRIGGER AS
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


CREATE TRIGGER check_moderator
    BEFORE DELETE ON event_organizer
    FOR EACH ROW
    EXECUTE PROCEDURE check_moderator();


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