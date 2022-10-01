SELECT a2.province, a2.date
FROM (select *
FROM region
WHERE province = city) a1,
(select * from time_province t where t.confirmed = (
select max(confirmed) from time_province where t.province = province
) order by province) a2
WHERE a1.province = a2.province AND a1.elderly_population_ratio > (select avg(elderly_population_ratio) FROM region WHERE province = city)
ORDER BY a2.date;
