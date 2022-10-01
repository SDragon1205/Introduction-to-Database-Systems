SELECT a4.name name, a3.cnt/(a1.cnt+a2.cnt) prob
from
(select league_id, count(*) cnt
from match_info
where
( home_player_1
+ home_player_2
+ home_player_3
+ home_player_4
+ home_player_5
+ home_player_6
+ home_player_7
+ home_player_8
+ home_player_9
+ home_player_10
+ home_player_11)/11 > 180
OR
( away_player_1
+ away_player_2
+ away_player_3
+ away_player_4
+ away_player_5
+ away_player_6
+ away_player_7
+ away_player_8
+ away_player_9
+ away_player_10
+ away_player_11)/11 >180
group by league_id) a1,

(select league_id, count(*) cnt
from match_info
where
( home_player_1
+ home_player_2
+ home_player_3
+ home_player_4
+ home_player_5
+ home_player_6
+ home_player_7
+ home_player_8
+ home_player_9
+ home_player_10
+ home_player_11)/11 > 180
AND
( away_player_1
+ away_player_2
+ away_player_3
+ away_player_4
+ away_player_5
+ away_player_6
+ away_player_7
+ away_player_8
+ away_player_9
+ away_player_10
+ away_player_11)/11 >180
group by league_id) a2,
( select league_id, count(*) cnt
from match_info
where
( home_player_1
+ home_player_2
+ home_player_3
+ home_player_4
+ home_player_5
+ home_player_6
+ home_player_7
+ home_player_8
+ home_player_9
+ home_player_10
+ home_player_11)/11 > 180 AND home_team_score > away_team_score
OR
( away_player_1
+ away_player_2
+ away_player_3
+ away_player_4
+ away_player_5
+ away_player_6
+ away_player_7
+ away_player_8
+ away_player_9
+ away_player_10
+ away_player_11)/11 >180 AND home_team_score < away_team_score
group by league_id) a3,
(select id, name from league) a4
where
a1.league_id = a2.league_id AND
a2.league_id = a3.league_id AND
a3.league_id = a4.id;
