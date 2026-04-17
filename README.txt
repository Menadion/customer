to enter website use this link 

http://localhost/D.H-Azada%20-customer/php/customer_login.php

to do:
appointment side ( reference number textbox + screenshot drop box, redesign service since may function na mag dagdag ng bagong service,rescheule function, terms and condition, multiple slots per day depending on service type ( 2 slots for under chasis and 3 slots for wheel, battery adn rim change))
UI design


changes:
account authentication implemented
birthday ( only 17 years old above can only create account)
password ( implemented strong combination, 8 characetrs, at least 1 capital, special character and number.


new SQL codes:

ALTER TABLE customer_tbl
ADD COLUMN IF NOT EXISTS email_verification_token VARCHAR(64) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS email_verified_at DATETIME DEFAULT NULL;
