
1. **Organizer (ผู้จัดงาน)**
    - `organizer_id` (PK)
    - `name`
    - `email`
    - `phone_number`
    - `password`
2. **Event (งานคอนเสิร์ต)**
    - `event_id` (PK)
    - `organizer_id` (FK)
    - `event_name`
    - `description`
    - `event_date`
    - `event_time`
    - `venue`
    - `max_participants` (จำนวนผู้เข้าร่วมสูงสุด)
    - `status` (เปิดรับสมัคร/ปิดรับสมัคร)
3. **Participant (ผู้เข้าร่วมกิจกรรม)**
    - `participant_id` (PK)
    - `name`
    - `email`
    - `phone_number`
    - `gender` (ชาย/หญิง/อื่นๆ)
    - `age`
    - `password`
4. **Registration (การลงทะเบียน)**
    - `registration_id` (PK)
    - `event_id` (FK)
    - `participant_id` (FK)
    - `registration_date`
    - `status` (รออนุมัติ/อนุมัติ/ปฏิเสธ)
5. **Attendance (การเช็คชื่อเข้าร่วมกิจกรรม)**
    - `attendance_id` (PK)
    - `registration_id` (FK)
    - `check_in_time` (เวลาที่เช็คชื่อ)
    - `status` (เข้าร่วม/ไม่เข้าร่วม)
### **Relationships (ความสัมพันธ์)**
1. **Organizer (1) --- (M) Event**: ผู้จัดงานหนึ่งคนสามารถจัดงานได้หลายงาน
2. **Event (1) --- (M) Registration**: งานหนึ่งงานสามารถมีผู้ลงทะเบียนได้หลายคน
3. **Participant (1) --- (M) Registration**: ผู้เข้าร่วมหนึ่งคนสามารถลงทะเบียนได้หลายงาน
4. **Registration (1) --- (1) Attendance**: การลงทะเบียนหนึ่งครั้งจะมีการเช็คชื่อหนึ่งครั้ง
---

### **ER Diagram Structure**

#### 1. **Entities**

- **Organizer**: เก็บข้อมูลผู้จัดงาน
    
- **Event**: เก็บข้อมูลงานคอนเสิร์ต
    
- **Participant**: เก็บข้อมูลผู้เข้าร่วม
    
- **Registration**: เก็บข้อมูลการลงทะเบียน
    
- **Attendance**: เก็บข้อมูลการเช็คชื่อ
    

#### 2. **Relationships**

- **Organizer** เชื่อมกับ **Event** ด้วยความสัมพันธ์ "1:M "
    
- **Event** เชื่อมกับ **Registration** ด้วยความสัมพันธ์ "1:M "
    
- **Participant** เชื่อมกับ **Registration** ด้วยความสัมพันธ์ "1:M "
    
- **Registration** เชื่อมกับ **Attendance** ด้วยความสัมพันธ์ "1:1"


`CREATE TABLE Organizer (`
    `organizer_id INT PRIMARY KEY AUTO_INCREMENT,`
    `name VARCHAR(100),`
    `email VARCHAR(100),`
    `phone_number VARCHAR(15),`
    `password VARCHAR(255)`
`);`

`CREATE TABLE Event (`
    `event_id INT PRIMARY KEY AUTO_INCREMENT,`
    `organizer_id INT,`
    `event_name VARCHAR(100),`
    `description TEXT,`
    `event_date DATE,`
    `event_time TIME,`
    `venue VARCHAR(100),`
    `max_participants INT,`
    `status ENUM('open', 'closed'),`
    `FOREIGN KEY (organizer_id) REFERENCES Organizer(organizer_id)`
`);`

`CREATE TABLE Participant (`
    `participant_id INT PRIMARY KEY AUTO_INCREMENT,`
    `name VARCHAR(100),`
    `email VARCHAR(100),`
    `phone_number VARCHAR(15),`
    `gender ENUM('male', 'female', 'other'),`
    `age INT,`
    `password VARCHAR(255)`
`);`

`CREATE TABLE Registration (`
    `registration_id INT PRIMARY KEY AUTO_INCREMENT,`
    `event_id INT,`
    `participant_id INT,`
    `registration_date DATETIME,`
    `status ENUM('pending', 'approved', 'rejected'),`
    `FOREIGN KEY (event_id) REFERENCES Event(event_id),`
    `FOREIGN KEY (participant_id) REFERENCES Participant(participant_id)`
`);`

`CREATE TABLE Attendance (`
    `attendance_id INT PRIMARY KEY AUTO_INCREMENT,`
    `registration_id INT,`
    `check_in_time DATETIME,`
    `status ENUM('attended', 'not_attended'),`
    `FOREIGN KEY (registration_id) REFERENCES Registration(registration_id)`
`);`