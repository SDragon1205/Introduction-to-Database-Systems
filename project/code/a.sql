SELECT* 
FROM (
    SELECT * 
    FROM one_year 
	WHERE date >= '" . $d1 . "' 
		AND date <= '" . $d2 . "' 
		AND temp >= '" . $_POST['tem1'] . "' 
		AND temp <= '" . $_POST['tem2'] . "' 
		AND humidity >= '" . $_POST['hum1'] . "' 
		AND humidity <= '" . $_POST['hum2'] . "' 
		AND wind_speed LIKE BINARY '%" . $_POST['spe'] . "%' 
		AND precipitation LIKE BINARY '%" . $_POST['pre'] . "%' 
		AND sunshine LIKE BINARY '%" . $_POST['sun'] . "%'
	group by station_id) AS A, 
	(SELECT s.name, s.toldescribe,s.description, s.tel,s.add,s.opentime,s.travellinginfo,
		s.ticketinfo,s.remarks,s.picdescribe1,s.picdescribe2,s.picdescribe3, N.station_id 
	FROM (
        SELECT N.name, MIN(N.distance) AS m, N.toldescribe,N.description,N.tel,N.add,
            N.opentime,N.travellinginfo,N.ticketinfo,N.remarks,N.picdescribe1,N.picdescribe2,N.picdescribe3 
		FROM (
            SELECT SQRT((attraction.Px-station.px)*(attraction.Px-station.px)+(attraction.Py-station.py)*(attraction.Py-station.py)) AS distance,
                attraction.name , station.station_name ,station.station_id, attraction.id,attraction.toldescribe,attraction.description, 
                attraction.tel,attraction.add,attraction.opentime,attraction.travellinginfo,attraction.ticketinfo,attraction.remarks,
                attraction.picdescribe1,attraction.picdescribe2,attraction.picdescribe3 
			FROM attraction, station) AS N 
        GROUP BY N.name) AS s, 
		(SELECT SQRT((attraction.Px-station.px)*(attraction.Px-station.px)+(attraction.Py-station.py)*(attraction.Py-station.py)) AS distance,
            attraction.name , station.station_name, station.station_id, attraction.id 
		FROM attraction, station) AS N 
	WHERE N.distance = s.m AND N.name = s.name) AS B 
WHERE A.station_id =B.station_id
LIMIT 10