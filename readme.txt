INSERT INTO statlists(a_id,r_id) SELECT a.id,r.id FROM adplaylists a LEFT JOIN ratings r ON a.`f_id`=r.`f_id` WHERE a.`d_date`=r.`s_date` AND a.`b_time` BETWEEN r.`b_time` AND r.`e_time`

SELECT * FROM `adplaylists` LEFT JOIN `ratings` ON `ratings`.`f_id` = `adplaylists`.`f_id` WHERE `adplaylists`.`d_date` = 'ratings.s_date' AND `adplaylists`.`b_time` BETWEEN 'ratings.b_time' AND 'ratings.e_time'