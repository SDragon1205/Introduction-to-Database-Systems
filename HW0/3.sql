SELECT DISTINCT province, city, elementary_school_count cnt
FROM region
WHERE province != city
ORDER BY elementary_school_count DESC
Limit 3;
