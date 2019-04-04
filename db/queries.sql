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
all_notifications JOIN "user" on all_notifications.user_id = "user".id
WHERE "user".id = 1;

