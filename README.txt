to enter website use this link 

http://localhost/D.H-Azada%20-customer/php/customer_login.php

to do:
UI design ( login, sign up, appointment, product, service, history, profile, policies)
appointment (map progress)
product ( more filter, pictures of product)
scroll function ( experemental)
fix drop down button in profile if your in policies and profile
add green little circle in notification indicated new notification



Changes:
Forgot password flow
Added Forgot password? in login.
Added forgot password request page (email reset link).
Added reset password page (new password + confirm + DB update).
Added reset token + expiry logic.

One-time flash messages (refresh-safe)
Implemented session flash messaging so success/error messages disappear after refresh.

Appointment flow overhaul
Implemented flow behavior:
Service/Product → Date/Time → Confirmation → Reservation Payment

Added payment requirements in modal:
Reference number textbox
Upload payment proof image

Backend now saves:
duration, end time
reservation reference
reservation fee
payment proof path

Slot logic and scheduling
Added duration rules:
Battery 10 min
Tire 15 min per tire
Rim 15 min per rim
Underchassis 60 min
Vulcanize 30 min

Added DB-based availability checks.

Added slot capacity logic:
Underchassis pool: 2 concurrent slots
Other services pool: 3 concurrent slots

Time buttons now show slot counters and grey out when full/unavailable.

Dates grey out only when no valid times remain for selected services.

Upcoming appointment details
Updated upcoming view to show:
time range
estimated duration
reservation fee
reference number
payment proof link

Terms & policies
Added Terms & Conditions and privacy agreement in signup.
Added popup modal(s) for Terms and Privacy.
Separated Terms and Privacy into separate popups.
Added new Policies item in profile dropdown.


25/04/2026
Redo UI in homepage
added location in homepage
added notification function



new SQL codes:

ALTER TABLE appointments_tbl
ADD COLUMN IF NOT EXISTS appt_end_time TIME DEFAULT NULL,
ADD COLUMN IF NOT EXISTS estimated_duration_minutes INT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS reservation_reference VARCHAR(120) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS reservation_fee DECIMAL(10,2) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS payment_proof_path VARCHAR(500) DEFAULT NULL;

ALTER TABLE customer_tbl
ADD COLUMN IF NOT EXISTS email_verification_token VARCHAR(64) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS email_verified_at DATETIME DEFAULT NULL,
ADD COLUMN IF NOT EXISTS password_reset_token VARCHAR(64) DEFAULT NULL,
ADD COLUMN IF NOT EXISTS password_reset_expires_at DATETIME DEFAULT NULL;

new SQL codes: 25/04/2026
ALTER TABLE appointments_tbl
ADD COLUMN decline_reason VARCHAR(255) NULL AFTER appt_status;

