SELECT b4.team_long_name, max(ROUND((((a1.cnt+a2.cnt)*2)+(c2.cnt+c1.cnt))/(d1.cnt+d2.cnt), 2)) avg_win_score
from

(select home_team_id team_id, count(*) cnt
from match_info
where
home_team_score > away_team_score AND season = '2015/2016'
group by home_team_id)a1,

(select away_team_id team_id, count(*) cnt
from match_info
where
home_team_score < away_team_score AND season = '2015/2016'
group by away_team_id)a2,


(select away_team_id team_id, count(*) cnt
from match_info
where
home_team_score = away_team_score AND season = '2015/2016'
group by away_team_id)c2,

(select home_team_id team_id, count(*) cnt
from match_info
where
home_team_score = away_team_score AND season = '2015/2016'
group by home_team_id)c1,


(select away_team_id team_id, count(*) cnt
from match_info
where season = '2015/2016'
group by away_team_id)d2,

(select home_team_id team_id, count(*) cnt
from match_info
where season = '2015/2016'
group by home_team_id)d1,

team b4
where a1.team_id = a2.team_id AND
c1.team_id = c2.team_id AND
d1.team_id = d2.team_id AND

a1.team_id = c1.team_id AND
a1.team_id = d1.team_id AND
a1.team_id = b4.id
group by b4.id
order by avg_win_score DESC
Limit 5;
