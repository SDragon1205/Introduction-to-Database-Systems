SELECT DISTINCT infection_case
FROM patient_info
WHERE province = 'Seoul' AND city = 'Gangnam-gu' AND age < 30 AND sex = 'male'
ORDER BY infection_case ASC;
