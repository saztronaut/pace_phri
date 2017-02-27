
SELECT MIN(date_read) as EarliestDate, username, steps, `method` FROM `readings`

SELECT @rownum:=@rownum+1 as row_number, `username` as u ,`date_read` as d
FROM readings, (SELECT @rownum := 0) r
ORDER by username, date_read






/// This detects epochs of 3 days worth of records within 7 days
/// It also does not allow values newer than 7 days old from the sysdate
SELECT g.u as usern, f.d_plus as epochStart, g.d as epochEnd,   f.row_number, g.in_three, g.row_number
FROM
(SELECT u, t.row_number, d, t.row_number-2 as in_three
FROM
	(SELECT @rownum:=@rownum+1 as row_number, `username` as u ,`date_read` as d
	FROM readings, (SELECT @rownum := 0) r
	ORDER by username, date_read) as t ) as g,
(SELECT u, p.row_number, d as d_plus 
	FROM
	(SELECT @rownum2:=@rownum2+1 as row_number, `username` as u ,`date_read` as d
	FROM readings, (SELECT @rownum2 := 0) s
 	ORDER by username, date_read) as p) as f
 WHERE f.row_number=g.in_three AND g.u=f.u AND DATEDIFF( f.d_plus,g.d)<7 AND DATEDIFF(CURDATE(), f.d_plus)>=6;
 
 ....or this is much simpler
 SELECT getDays.base_steps, getDays.n, getDays.start, getDays.username
 FROM
 (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
 FROM (SELECT r.date_read, m.steps, r.username
 FROM readings as r,
 readings as m
 WHERE r.date_read<= m.date_read AND DATEDIFF(r.date_read, m.date_read)<7 AND r.username= m.username) as getValues
 GROUP BY getValues.date_read, getValues.username) as getDays
 WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6;
 
 SELECT getDays.base_steps, getDays.n, getDays.start, getDays.username
 FROM
 (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
 FROM (SELECT r.date_read, m.steps, r.username
 FROM readings as r,
 readings as m
 WHERE r.date_read<= m.date_read AND DATEDIFF(r.date_read, m.date_read)<7 AND r.username= m.username) as getValues
 GROUP BY getValues.date_read, getValues.username) as getDays
 WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6;
 
 
 ///Create baseline date for participants with no baseline 
 INSERT INTO targets (username, date_set, steps, days) 
 SELECT getDays.username, getDays.start, getDays.base_steps, 0 
 FROM
 (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
 FROM (SELECT r.date_read, m.steps, r.username
 FROM readings as r,
 readings as m
 WHERE r.date_read<= m.date_read AND DATEDIFF(r.date_read, m.date_read)<7 AND r.username= m.username) as getValues
 GROUP BY getValues.date_read, getValues.username) as getDays
 WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6 AND getDays.username NOT IN 
 (SELECT username FROM targets WHERE date_set=getDays.start);


SELECT MIN(epochStart) as base_date, usern
FROM
(SELECT g.u as usern, f.d_plus as epochStart, g.d as epochEnd, f.row_number2, g.in_three, g.row_number
FROM
(SELECT u, t.row_number, d, t.row_number-2 as in_three
FROM
	(SELECT @rownum:=@rownum+1 as row_number, `username` as u ,`date_read` as d
	FROM readings, (SELECT @rownum := 0) r
	ORDER by username, date_read) as t ) as g,
(SELECT u, p.row_number2, d as d_plus 
	FROM
	(SELECT @rownum2:=@rownum2+1 as row_number2, `username` as u ,`date_read` as d
	FROM readings, (SELECT @rownum2 := 0) s
 	ORDER by username, date_read) as p) as f
 WHERE f.row_number2=g.in_three AND g.u=f.u AND DATEDIFF( f.d_plus,g.d)<7 AND DATEDIFF(CURDATE(), f.d_plus)>=6) as getEpoch;
 
 //Now you want to get the average number of steps between this point and this point +1
 
 
 SELECT COUNT(steps) as n, getValues.date_read as start, username
 FROM (SELECT r.date_read, r.steps, r.username
 FROM readings as r,
 readings as m
 WHERE r.date_read< m.date_read AND DATEDIFF(r.date_read, m.date_read)<6) as getValues
 GROUP BY getValues.date_read
 
 
SELECT COUNT(*) as n_t, MAX(date_set) as latest_t, steps, days FROM targets WHERE username='bruce' ORDER BY date_set DESC

SELECT n_t, latest_t, steps, days FROM targets as t,
(SELECT COUNT(*) as n_t, MAX(date_set) as latest_t FROM targets HAVING username='bruce' ORDER BY date_set) as a 
WHERE a.latest_t=t.date_set AND a.username='bruce'


SELECT r.username,date_read, date_entered, steps
FROM readings as r, 
(SELECT username, steps as target, date_set  FROM targets WHERE username='bruce' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='bruce' ORDER BY date_set DESC)) as t
WHERE r.username=t.username AND r.date_read between (t.date_set+7) AND (t.date_set+14) AND r.steps>=t.target
    
    
SELECT COUNT(*), days 
FROM readings as r, 
(SELECT username, steps as target, date_set, days  FROM targets WHERE username='bruce' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='bruce' ORDER BY date_set DESC)) as t
WHERE r.username=t.username AND r.date_read between (t.date_set+7) AND (t.date_set+14) AND r.steps>=t.target

SELECT username, date14, goal
FROM targets, 
(SELECT username, COUNT(*) as achieved, days as goal, DATE_ADD(date_set, INTERVAL 14 DAY) as date14
FROM readings as r,
(SELECT username, steps as target, date_set, days  FROM targets WHERE username='". $username ."' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set DESC)) as t
WHERE r.username=t.username AND r.date_read between (t.date_set+7) AND (t.date_set+14) AND r.steps>=t.target) as checkTarget
WHERE checkTarget.achieved>=checkTarget.goal AND checkTarget.username=targets.username;					
					

SELECT targets.username, date14, goal
FROM targets, 
(SELECT r.username, COUNT(*) as achieved, days as goal, DATE_ADD(date_set, INTERVAL 14 DAY) as date14
FROM readings as r,
(SELECT username, steps as target, date_set, days  FROM targets WHERE username='bruce' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='bruce' ORDER BY date_set DESC)) as t
WHERE r.username=t.username AND r.date_read between (t.date_set+7) AND (t.date_set+14) AND r.steps>=t.target) as checkTarget
WHERE checkTarget.achieved>=checkTarget.goal AND checkTarget.username=targets.username;					
					
week=week4&weekno=4&steps=7800&latest_t=2017-02-12&days=5&base=7800&finish=null
week=week3&weekno=3&steps=7800&latest_t=2017-02-05&days=5&base=7800&finish=2017-02-11
week=week2&weekno=2&steps=7800&latest_t=2017-01-29&days=3&base=7800&finish=2017-02-05
					
DELETE FROM reset WHERE (TIME_TO_SEC(TIMEDIFF(NOW(),time_issue))/60)>30;

SELECT date_read, add_walk, steps, method, MAX(date_set) as date_set FROM
(SELECT  date_read, date_entered, add_walk, r.steps, method, date_set, t.steps as target FROM readings as r, targets as t WHERE r.username= t.username AND r.username='". $username."' AND date_read>=date_set) AS getTargets
GROUP BY date_read;

SELECT date_read, add_walk, steps, method, MAX(date_set) as date_set FROM
(SELECT  `date_read`, `date_entered`, `add_walk`, r.`steps`, `method`, date_set, t.steps as target FROM `readings` as r, targets as t WHERE r.username= t.username AND r.username='seamus' AND date_read>=date_set) AS getTargets
GROUP BY date_read
UNION
SELECT date_read, 0, steps, method, ""
FROM `readings` WHERE  username='seamus' AND date_read < (SELECT MIN(date_set) FROM targets WHERE username ='seamus')


					