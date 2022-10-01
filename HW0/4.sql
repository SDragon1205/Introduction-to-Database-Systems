SELECT A1.province province, COUNT(*) cnt
FROM region A1, weather A2
WHERE A1.province = A1.city AND A1.code = A2.code AND A2.avg_relative_humidity > 70 AND A2.date >= '2016-05-01' AND A2.date<='2016-05-31'
GROUP BY A1.province
ORDER BY COUNT(*) DESC
Limit 3;
