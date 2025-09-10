- **Users** (เก็บข้อมูลผู้ใช้)
    
    - `user_id` (PK) – รหัสผู้ใช้
    - `username` – ชื่อผู้ใช้
    - `password` – รหัสผ่าน
    - `email` – อีเมล
    - `role` – บทบาท (ผู้สร้าง/ผู้เข้าร่วม หรือทั้งสองอย่าง)
- **Events** (เก็บข้อมูลกิจกรรม)
    
    - `event_id` (PK) – รหัสกิจกรรม
    - `creator_id` (FK → Users.user_id) – ผู้สร้างกิจกรรม
    - `title` – ชื่อกิจกรรม
    - `description` – รายละเอียดกิจกรรม
    - `date` – วันที่จัดกิจกรรม
    - `location` – สถานที่จัดกิจกรรม
    - `images` – URL หรือ path ของรูปภาพ
- **Event_Participants** (เก็บข้อมูลการเข้าร่วม)
    
    - `participant_id` (PK) – รหัสการเข้าร่วม
    - `event_id` (FK → Events.event_id) – กิจกรรมที่เข้าร่วม
    - `user_id` (FK → Users.user_id) – ผู้เข้าร่วม
    - `status` – สถานะการเข้าร่วม (`pending`, `approved`, `rejected`)
    - `otp_code` – รหัส OTP สำหรับยืนยันตัวตน
    - `checked_in` – สถานะเช็คชื่อ (True/False)


`CREATE DATABASE EventManagement;`
`USE EventManagement;`

`-- Table for users`
`CREATE TABLE Users (`
    `user_id INT AUTO_INCREMENT PRIMARY KEY,`
    `username VARCHAR(50) NOT NULL UNIQUE,`
    `password VARCHAR(255) NOT NULL,`
    `email VARCHAR(100) NOT NULL UNIQUE,`
    `role ENUM('creator', 'participant', 'both') NOT NULL`
`);`

`-- Table for events`
`CREATE TABLE Events (`
    `event_id INT AUTO_INCREMENT PRIMARY KEY,`
    `creator_id INT NOT NULL,`
    `title VARCHAR(100) NOT NULL,`
    `description TEXT NOT NULL,`
    `date DATE NOT NULL,`
    `location VARCHAR(255) NOT NULL,`
    `images TEXT,`
    `FOREIGN KEY (creator_id) REFERENCES Users(user_id) ON DELETE CASCADE`
`);`

`-- Table for event participants`
`CREATE TABLE Event_Participants (`
    `participant_id INT AUTO_INCREMENT PRIMARY KEY,`
    `event_id INT NOT NULL,`
    `user_id INT NOT NULL,`
    `status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',`
    `otp_code VARCHAR(10),`
    `checked_in BOOLEAN DEFAULT FALSE,`
    `FOREIGN KEY (event_id) REFERENCES Events(event_id) ON DELETE CASCADE,`
    `FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE`
`);`
