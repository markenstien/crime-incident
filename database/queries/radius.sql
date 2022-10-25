SELECT id, reference,lat, lng, round(((lat + lng + (100/3.14)) * 3.14) , 3) FROM 
cases where id in(3,4, 5,7)


SELECT id, reference,lat, lng, round(((lat + lng + (200/3.14)) * 3.14) , 3) FROM 
cases


/*
*5 And 7 should be on the same radius
*3,4 must have different radius
*/