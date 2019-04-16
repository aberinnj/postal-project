DROP TABLE IF EXISTS `notifications`
CREATE TABLE IF NOT EXISTS `notification` (
	`msg_id` int(25) NOT NULL AUTO_INCREMENT,
	`update_msg` varchar(40) NOT NULL,
	`update_date` timestamp NOT NULL,
	`email` varchar(55), NOT NULL,
	`tracking_index` int(18) NOT NULL,
	`package_id` int(10) NOT NULL,
		
	PRIMARY KEY(`email`),
)

CREATE TRIGGER `create_notification`
INSERT INTO AFTER UPDATE ON `tracking`
BEGIN

INSERT INTO notifications(msg_id, update_msg, update_date, email, tracking_index, package_id)
VALUES(DEFAULT, NEW.TrackingNote, NEW.Update_Date, NEW.email, NEW.tracking_index, NEW.package_id)

END
