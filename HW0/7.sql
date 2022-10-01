select a2.preferred_foot, ROUND(avg(a2.long_shots), 2) avg_long_shots
from
(select home_player_1
, home_player_2
, home_player_3
, home_player_4
, home_player_5
, home_player_6
, home_player_7
, home_player_8
, home_player_9
, home_player_10
, home_player_11
, away_player_1
, away_player_2
, away_player_3
, away_player_4
, away_player_5
, away_player_6
, away_player_7
, away_player_8
, away_player_9
, away_player_10
, away_player_11
from match_info where season = '2015/2016' AND league_id = (select id from league where name = 'Italy Serie A')) a1,
(select player_api_id, preferred_foot, long_shots , max(date) from player_attributes group by player_api_id) a2
where a1.home_player_1 = a2.player_api_id
or a1.home_player_2 = a2.player_api_id
or a1.home_player_3 = a2.player_api_id
or a1.home_player_4 = a2.player_api_id
or a1.home_player_5 = a2.player_api_id
or a1.home_player_6 = a2.player_api_id
or a1.home_player_7 = a2.player_api_id
or a1.home_player_8 = a2.player_api_id
or a1.home_player_9 = a2.player_api_id
or a1.home_player_10 = a2.player_api_id
or a1.home_player_11 = a2.player_api_id
or a1.away_player_1 = a2.player_api_id
or a1.away_player_2 = a2.player_api_id
or a1.away_player_3 = a2.player_api_id
or a1.away_player_4 = a2.player_api_id
or a1.away_player_5 = a2.player_api_id
or a1.away_player_6 = a2.player_api_id
or a1.away_player_7 = a2.player_api_id
or a1.away_player_8 = a2.player_api_id
or a1.away_player_9 = a2.player_api_id
or a1.away_player_10 = a2.player_api_id
or a1.away_player_11 = a2.player_api_id
group by a2.preferred_foot;
