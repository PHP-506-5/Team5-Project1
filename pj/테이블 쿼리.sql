CREATE TABLE trip_info(
	trip_no INT(11) PRIMARY KEY AUTO_INCREMENT
	,trip_title VARCHAR(100) NOT NULL
	,trip_contents VARCHAR(1000) NOT NULL
	,trip_city VARCHAR(11) NOT NULL
	,trip_price INT(11)
	,trip_date DATETIME NOT NULL
	,trip_com CHAR(1) DEFAULT('0')
);