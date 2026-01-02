# 🧪 Lab Management System – Hệ thống quản lý phòng thực hành

> **Một hệ thống quản lý phòng lab hiện đại, hỗ trợ quản lý phòng máy, thiết bị, lịch mượn phòng và thống kê cho Khoa Công nghệ Thông tin – Trường Đại học Nha Trang.**

---

## 📌 Giới thiệu chung

Khoa Công nghệ Thông tin – Trường Đại học Nha Trang được thành lập ngày 17/01/2003. Hiện khoa sở hữu **9 phòng máy tính**, gần **200 thiết bị**, cùng **2 phòng lab chuyên dụng** thuộc dự án KOICA IBS.

Nhà trường hiện có hệ thống đặt phòng cơ bản, tuy nhiên chưa đáp ứng đầy đủ nhu cầu theo dõi, quản lý hoạt động, thiết bị và mượn phòng của sinh viên – giảng viên.  

💡 Vì vậy, hệ thống **Lab Management System (LMS)** được xây dựng nhằm **tự động hóa – tối ưu hóa – hiện đại hóa** toàn bộ quy trình quản lý phòng thực hành.

---

## 🎯 Mục tiêu

### ✔ Mục tiêu tổng quát
Xây dựng một hệ thống quản lý phòng lab hoàn chỉnh, giảm thao tác thủ công, gia tăng hiệu quả vận hành và hỗ trợ giám sát tình trạng phòng – thiết bị.

### ✔ Mục tiêu chi tiết
Hệ thống tập trung vào các nhóm chức năng chính:

- Quản lý người dùng & phân quyền  
- Quản lý phòng thực hành  
- Quản lý thiết bị và bảo trì  
- Quản lý yêu cầu mượn phòng  
- Thống kê – báo cáo tổng hợp  

---

## 👥 Đối tượng sử dụng hệ thống

### Người dùng hệ thống
- **Quản lý phòng máy**
- **Giảng viên**
- **Sinh viên**

### Đối tượng được quản lý
- Phòng máy thực hành  
- Thiết bị (máy tính, máy chiếu, camera…)  
- Phiếu đăng ký mượn phòng  
- Quy trình sử dụng phòng  

---

## 📦 Các chức năng chính

### 🔐 1. Quản lý người dùng
- Đăng ký, đăng nhập  
- Phân quyền quản trị – giảng viên – sinh viên  
- Quản lý thông tin cá nhân  

### 🏫 2. Quản lý phòng lab
- Thông tin phòng  
- Số lượng máy  
- Tình trạng hoạt động  
- Lịch sử sử dụng  

### 💻 3. Quản lý thiết bị
- Theo dõi tình trạng  
- Ghi nhận sự cố  
- Lịch sử bảo trì – sửa chữa  
- Cảnh báo thiết bị hỏng  

### 📝 4. Mượn phòng
- Giảng viên đăng ký lịch giảng dạy  
- Sinh viên mượn phòng tự học / thực hành  
- Quy trình duyệt, từ chối, phản hồi  
- Nhật ký sử dụng phòng  

### 📊 5. Thống kê – Báo cáo
- Tần suất sử dụng phòng  
- Tình trạng thiết bị  
- Báo cáo sự cố  
- Hiệu suất phòng theo tuần/tháng  

---

## 🛠 Công nghệ sử dụng

| Thành phần | Công nghệ |
|-----------|-----------|
| Ngôn ngữ | **PHP 8.2.12** |
| Cơ sở dữ liệu | **MySQL** |
| Môi trường chạy | **XAMPP 3.3.0** |
| Công cụ thiết kế CSDL | drawDB |
| Môi trường triển khai | Mạng nội bộ trường |

---

## 🗄️ Cơ sở dữ liệu

### 📌 Sơ đồ cơ sở dữ liệu (Database Schema)
> Trực quan hoá bằng drawDB:  
https://www.drawdb.app/

![LMS_DB](https://github.com/user-attachments/assets/69898740-81e1-4b0e-adf1-3c03dff9e6a9)

--

## 🗃️ Cấu trúc Source Code

```
LabManagementSystem-main
├─ composer.lock
├─ Database
│  ├─ config.php
│  └─ quanlylab.sql
├─ GhiChu.txt
├─ README.md
├─ Src
│  ├─ Controller
│  │  ├─ controller.php
│  │  ├─ deviceController.php
│  │  ├─ historyController.php
│  │  ├─ labBookingController.php
│  │  ├─ labController.php
│  │  ├─ labschedController.php
│  │  ├─ loginController.php
│  │  ├─ paginationController.php
│  │  ├─ profileController.php
│  │  ├─ signupController.php
│  │  ├─ statisticController.php
│  │  └─ userController.php
│  ├─ device.php
│  ├─ device_add.php
│  ├─ device_delete.php
│  ├─ device_detail.php
│  ├─ device_edit.php
│  ├─ edit_profile.php
│  ├─ footer.php
│  ├─ header.php
│  ├─ history.php
│  ├─ history_admin.php
│  ├─ history_delete.php
│  ├─ history_detail.php
│  ├─ history_edit.php
│  ├─ Image
│  ├─ index.php
│  ├─ lab.php
│  ├─ lab_add.php
│  ├─ lab_booking.php
│  ├─ lab_delete.php
│  ├─ lab_detail.php
│  ├─ lab_edit.php
│  ├─ lab_sched.php
│  ├─ lab_week_sched.php
│  ├─ login.php
│  ├─ logout.php
│  ├─ profile.php
│  ├─ signup.php
│  ├─ statictic_print.php
│  ├─ statistic.php
│  ├─ user.php
│  ├─ user_add.php
│  ├─ user_delete.php
│  ├─ user_detail.php
│  └─ user_edit.php
└─ vendor
   ├─ autoload.php
   ├─ composer
   └─ phpmailer
    
```

---

## 🖼️ Demo Giao diện

<img width="1919" height="1052" alt="image" src="https://github.com/user-attachments/assets/1d00bbee-6052-4c56-a1a1-f58395d7f810" />
