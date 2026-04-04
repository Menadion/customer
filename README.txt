to enter website use this link 

http://localhost/D.H-Azada%20-customer/php/customer_login.php

to do:
account authentication


DB related:
1) Added columns to appointments_tbl

ALTER TABLE appointments_tbl
ADD COLUMN purpose TEXT AFTER appt_time,
ADD COLUMN notes TEXT AFTER purpose,
ADD COLUMN tires_product_id INT NULL,
ADD COLUMN tires_qty INT NULL,
ADD COLUMN batteries_product_id INT NULL,
ADD COLUMN magwheels_product_id INT NULL,
ADD COLUMN magwheels_qty INT NULL,
ADD COLUMN total_cost DECIMAL(10,2) NULL;

2)fix for appt_id auto increment

ALTER TABLE appointments_tbl
MODIFY appt_id INT NOT NULL AUTO_INCREMENT;