SELECT a2.date, ROUND(a1.coronavirus, 2) coronavirus, confirmed confirmed_accumulate, confirmed-LAG(a2.confirmed, 1)OVER(
ORDER BY a2.date
) confirmed_add, deceased dead_accumulate, deceased-LAG(a2.deceased, 1)OVER(
ORDER BY a2.date
) dead_add
FROM (select *
from search_trend t
where t.coronavirus > (select STD(coronavirus) from search_trend WHERE date BETWEEN '2019-12-25' AND '2020-06-29')*2+(select avg(coronavirus) from search_trend WHERE date BETWEEN '2019-12-25' AND '2020-06-29')
order by date) a1,
time a2
WHERE a1.date = a2.date;
