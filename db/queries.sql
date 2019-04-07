--PESQUISAS MAIS FREQUENTES

-- Query das notificações

DROP VIEW IF EXISTS all_notifications;

CREATE VIEW all_notifications AS
SELECT 
    notification.id AS notification_id, 
    notification.code, 
    notification.date,
    notification."user" AS user_id,
    notification_event.event, 
    notification_guardian.guardian, 
    notification_group."group" 
FROM
notification
    LEFT JOIN notification_event    ON notification_event.notification = notification.id
    LEFT JOIN notification_group    ON notification_group.notification = notification.id
    LEFT JOIN notification_guardian ON notification_guardian.notification = notification.id;



SELECT all_notifications.*, "user".name FROM 
all_notifications JOIN "user" ON all_notifications.user_id = "user".id
WHERE "user".id = 1;


-- Overview dos eventos nos quais estão convidado/inserido

    -- Informação genérica do event
SELECT event.id, event.title, event.start_date, event.price, location.name
FROM event, event_participant, location
WHERE event_participant.event = event.id
    AND event_participant.participant = 10
    AND event.location = location.id;

    -- Numero de confirmações
SELECT COUNT(*)
FROM event_participant
WHERE event_participant.event = 2
    AND event_participant.state ='Going';

    -- Nome dos participantes
SELECT "user".id, "user".name 
FROM event_participant, "user"
WHERE event_participant.event = 2
    AND event_participant.participant = "user".id
    LIMIT 5;

    -- "Tags"
SELECT "group".id, "group".name
FROM event_group, "group"
WHERE  event_group.event = 2
    AND "group".id = event_group."group"
    LIMIT 5;


-- Comments de um evento

SELECT comment.* 
FROM comment
WHERE comment.event = 2;

-- Votos na sondagem de um evento

SELECT  option.id as option_id, option.date, COUNT(option_id)
FROM poll, option JOIN vote ON option.id = vote.option
WHERE poll.event = 2
    AND option.poll = poll.id
    GROUP BY option.id;

    


-- Query overview dos grupos

    -- Nome do grupo
SELECT "group".id, "group".name
FROM "group", group_member
WHERE group_member.member = 10
    AND group_member."group" = "group".id;

    -- Participantes do Grupo
SELECT "user".id, "user".name 
FROM group_member, "user"
WHERE group_member."group" = 2
    AND group_member.member = "user".id
    LIMIT 5;

    --"Tags" do grupo
SELECT event.id, event.title
FROM event_group, event
WHERE event_group."group" = 2
    AND event.id = event_group.event
    LIMIT 5;


--ALTERAÇÕES MAIS FREQUENTES

--convite para um evento 
INSERT INTO event_participant (participant, event)
    VALUES($participant, $event);

    --também pode ser feito através da seguinte query recorrendo ao trigger
    INSERT INTO event_group(event, "group")
        VALUES($event, $group);

--criação de evento
INSERT INTO event (title, description, price, start_date, location)
    VALUES($title, $description, $price, $start_date, $location);

--criação de grupo 
INSERT INTO "group"(name)
    VALUES($name);

--voto numa sondagem 
INSERT INTO vote(voter, option)
    VALUES($voter, $option)

--definição da data final de um evento
UPDATE event
    SET final_date = $final_date
    WHERE event.id = $id;

--criação de um comentário
INSERT INTO comment(participant, event, "text")
    VALUES($user_id, $event, $text);

--criação de uma nova notificação
INSERT INTO notification(code, "user")
    VALUES($code, $user);
    --especial enfâse nas de evento
    INSERT INTO notification_event(notification, event)
        VALUES($notification, $event);

--inserção de um novo user após confirmação do registo
    --aceitação do pedido
UPDATE registration_request
SET state = 'Accepted'
WHERE registration_request.id = $id; 

    --registo que foi aceite
INSERT INTO registration_handling(request, admin)
    VALUES($request_id, $admin_id);

    --inserção no sistema
INSERT INTO "user"(email, password, name, birthdate, is_responsible, is_guardian, description)
    VALUES($email, $password, $name, $birthdate, $is_responsible, $is_guardian, $description);


