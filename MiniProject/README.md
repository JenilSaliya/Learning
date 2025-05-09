
# 📘 MiniProject - PHP Expense Tracker

This is a PHP-based web application for tracking expenses. Follow these steps to run the project locally using **XAMPP**.

---

## 🚀 Requirements

- [XAMPP](https://www.apachefriends.org/index.html) installed on your computer
- A browser (e.g., Chrome, Firefox)
- Basic understanding of file management

---

## 📂 Project Structure

Key folders and files include:

- `/PHP/` – contains all PHP logic and interfaces
- `/Assets/` – holds images and UI assets
- `expense.sql` – the MySQL database to import
- `index.php` (likely located inside `/PHP/`)

---

## 🛠️ How to Run This Project Using XAMPP

### 1. ✅ Install XAMPP
- Download and install [XAMPP](https://www.apachefriends.org/index.html) for your OS.
- Launch **XAMPP Control Panel**
- Start **Apache** and **MySQL**

---

### 2. 📁 Move the Project to XAMPP `htdocs`
1. Unzip this project (`MiniProject.zip`) if not already done.
2. Go to the extracted folder and copy the inner folder named `MiniProject`.
3. Paste it inside the `htdocs` folder. Usually located at:
   ```
   C:\xampp\htdocs\
   ```
   So the path becomes:
   ```
   C:\xampp\htdocs\MiniProject
   ```

---

### 3. 🗃️ Import the Database
1. Open your browser and go to:  
   ```
   http://localhost/phpmyadmin
   ```
2. Click **"New"** to create a new database, name it:
   ```
   expense
   ```
3. Click the new `expense` database, then go to the **Import** tab.
4. Click **"Choose File"** and select:
   ```
   MiniProject/expense.sql
   ```
5. Click **Go** to import.

---

### 4. 🌐 Run the Project
Open your browser and go to:

```
http://localhost/MiniProject/PHP/index.php
```

Or if there's no `index.php`, use a specific file like:

```
http://localhost/MiniProject/PHP/login.php
```

---

## 🧑‍💻 Notes
- Make sure your database credentials in `connection.php` match:
  ```php
  $conn = new mysqli("localhost", "root", "", "expense");
  ```
- Default MySQL user is `root`, with no password in XAMPP.

---

## ❓Troubleshooting

- **Blank page?** Check if the PHP file you’re accessing is correct.
- **Database error?** Make sure `expense.sql` is imported and the connection settings are correct.
- **Port conflicts?** Ensure Apache and MySQL are not blocked by another app (like Skype).
