
-- Types


DROP TYPE IF EXISTS NotificationState;
CREATE TYPE NotificationState AS ENUM ('Seen', 'Not Seen');

DROP TYPE IF EXISTS ParticipationStatus;
CREATE TYPE ParticipationStatus AS ENUM ('Going', 'Not Going', 'Pending');

DROP TYPE IF EXISTS RegisterStatus;
CREATE TYPE RegisterStatus AS ENUM ('Accepted', 'Rejected', 'Pending');


-- Tables
DROP TABLE IF EXISTS "user";

CREATE TABLE "user" (
   id SERIAL PRIMARY KEY,
   email text NOT NULL CONSTRAINT user_email_uk UNIQUE,
   password text NOT NULL,
   name text NOT NULL,
   birthdate DATE NOT NULL,
   is_responsible BOOLEAN NOT NULL,
   description text NOT NULL,
   deactivated BOOLEAN NOT NULL
);


DROP TABLE IF EXISTS registration_request;
CREATE TABLE registration_request(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    birthdate DATE NOT NULL,
    state RegisterStatus DEFAULT 'Pending' NOT NULL,
    description TEXT NOT NULL
);

DROP TABLE IF EXISTS location;
CREATE TABLE location(
   id SERIAL PRIMARY KEY,
   name text NOT NULL,
   coordinates POINT NOT NULL,
   postal_code varchar(9),
    CONSTRAINT proper_postal_code CHECK (postal_code ~* '^[0-9]{4}-[0-9]{3}$')
);

DROP TABLE IF EXISTS event;
CREATE TABLE event(
   id SERIAL PRIMARY KEY,
   title text NOT NULL,
   description text,
   price REAL NOT NULL DEFAULT 0,
   final_date DATE,
   location INTEGER REFERENCES location (id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS guardian;

CREATE TABLE guardian(
   guardian INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
   minor INTEGER PRIMARY KEY REFERENCES "user" (id) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS guardian_exchange;
CREATE TABLE guardian_exchange(
   id SERIAL PRIMARY KEY,
   minor INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
   new_guardian INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
   state RegisterStatus NOT NULL DEFAULT 'Pending'
);

DROP TABLE IF EXISTS guardian_added_minors;
CREATE TABLE guardian_added_minors(
   request INTEGER PRIMARY KEY REFERENCES registration_request (id) ON UPDATE CASCADE,
   guardian INTEGER NOT NULL REFERENCES "user"(id) ON UPDATE CASCADE
);



DROP TABLE IF EXISTS event_participant;
CREATE TABLE event_participant(
   participant INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
   event INTEGER REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
   state ParticipationStatus NOT NULL DEFAULT 'Pending',
   PRIMARY KEY (participant, event)
);

DROP TABLE IF EXISTS event_organizer;
CREATE TABLE event_organizer(
   organizer INTEGER REFERENCES "user" (id) ON UPDATE CASCADE,
   event INTEGER REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
   PRIMARY KEY (organizer, event)
);

DROP TABLE IF EXISTS comment;
CREATE TABLE comment(
   id SERIAL PRIMARY KEY,
   participant INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
   event INTEGER NOT NULL REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
   date DATE NOT NULL DEFAULT CURRENT_DATE,
   "text" text NOT NULL
);


DROP TABLE IF EXISTS file;
CREATE TABLE file(
   id SERIAL PRIMARY KEY,
   title text NOT NULL,
   contents bytea NOT NULL,
   event INTEGER NOT NULL REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
   UNIQUE(title, event)
);

DROP TABLE IF EXISTS poll;
CREATE TABLE poll(
   id INTEGER PRIMARY KEY REFERENCES event (id) ON UPDATE CASCADE ON DELETE CASCADE,
   begin_date DATE NOT NULL DEFAULT CURRENT_DATE,
   end_date DATE NOT NULL,
   CONSTRAINT poll_date_ck CHECK (end_date > begin_date)
);

DROP TABLE IF EXISTS option;
CREATE TABLE option(
   id SERIAL PRIMARY KEY,
   date DATE NOT NULL,
   poll INTEGER NOT NULL REFERENCES poll (id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS vote;
CREATE TABLE vote(
   voter INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
   option INTEGER NOT NULL REFERENCES option (id) ON UPDATE CASCADE ON DELETE CASCADE,
   PRIMARY KEY (voter, option)
);

DROP TABLE IF EXISTS comment_elimation;
CREATE TABLE comment_elimation(
   comment INTEGER PRIMARY KEY REFERENCES comment (id) ON DELETE CASCADE,
   "user" INTEGER NOT NULL REFERENCES "user" (id) ON DELETE SET NULL,
   "date" DATE NOT NULL DEFAULT CURRENT_DATE
);

DROP TABLE IF EXISTS "group";
CREATE TABLE "group"(
   id SERIAL PRIMARY KEY,
   name text NOT NULL,
   is_section BOOLEAN NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS group_member;
CREATE TABLE group_member(
   member INTEGER REFERENCES "user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
   "group" INTEGER REFERENCES "group" (id) ON UPDATE CASCADE ON DELETE CASCADE,
   PRIMARY KEY(member, "group")
);

DROP TABLE IF EXISTS group_moderator;
CREATE TABLE group_moderator(
   moderator INTEGER REFERENCES "user" (id) ON UPDATE CASCADE,
   "group" INTEGER REFERENCES "group" (id) ON UPDATE CASCADE ON DELETE CASCADE,
   PRIMARY KEY(moderator, "group")
);

DROP TABLE IF EXISTS code;

CREATE TABLE code(
    code SERIAL PRIMARY KEY ,
    description TEXT NOT NULL
);

DROP TABLE IF EXISTS notification;

CREATE TABLE notification(
    id SERIAL PRIMARY KEY,
    code SERIAL REFERENCES code NOT NULL,
    member SERIAL NOT NULL REFERENCES "user" ON DELETE CASCADE,
    date DATE NOT NULL,
    state NotificationState NOT NULL
);


DROP TABLE IF EXISTS notification_event;

CREATE TABLE notification_event(
    notification SERIAL PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
    event SERIAL NOT NULL REFERENCES event ON DELETE CASCADE
);

DROP TABLE IF EXISTS notification_guardian;

CREATE TABLE notification_guardian(
    notification SERIAL PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
    guardian SERIAL NOT NULL REFERENCES "user" ON DELETE CASCADE
);
DROP TABLE IF EXISTS notification_group;

CREATE TABLE notification_group(
    notification SERIAL PRIMARY KEY REFERENCES notification ON DELETE CASCADE,
    "group" SERIAL NOT NULL REFERENCES "group" ON DELETE CASCADE
);


DROP TABLE IF EXISTS admin;

CREATE TABLE admin(
    id SERIAL PRIMARY KEY ,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);



DROP TABLE IF EXISTS group_elimination;

CREATE TABLE group_elimination(
    id SERIAL PRIMARY KEY ,
    admin SERIAL REFERENCES admin,
    group_name TEXT NOT NULL,
    "date" DATE NOT NULL DEFAULT CURRENT_DATE
);


DROP TABLE IF EXISTS user_elimination;

CREATE TABLE user_elimination(
    id SERIAL PRIMARY KEY ,
    admin SERIAL REFERENCES admin NOT NULL,
    user_name TEXT NOT NULL,
    "date" DATE  NOT NULL DEFAULT CURRENT_DATE
);


DROP TABLE IF EXISTS guardian_exchange_validation;

CREATE TABLE guardian_exchange_validation(
    exchange SERIAL PRIMARY KEY REFERENCES guardian_exchange,
    admin SERIAL REFERENCES admin NOT NULL
);


DROP TABLE IF EXISTS registration_handling;

CREATE TABLE registration_handling(
    request SERIAL PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
    admin SERIAL REFERENCES admin NOT NULL,
    "date" DATE  NOT NULL DEFAULT CURRENT_DATE
);


DROP TABLE IF EXISTS registration_request_handling;

CREATE TABLE registration_request_handling(
    minor SERIAL PRIMARY KEY REFERENCES registration_request ON DELETE CASCADE,
    g_name TEXT NOT NULL,
    g_email TEXT NOT NULL UNIQUE,
    g_password TEXT NOT NULL UNIQUE,
    g_birthdate DATE NOT NULL,
    g_description TEXT NOT NULL
);

