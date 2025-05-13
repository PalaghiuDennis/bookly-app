# 📚 Bookly – Online Bookstore Web Application

**Author:** Palaghiu Dennis-Nicolae  
**University:** Politehnica University of Bucharest – Pitești University Centre  
**Master’s Thesis – 2025**

---

## 📋 Overview

**Bookly** is a web-based application designed for purchasing books online. Developed as a master’s thesis project, the platform provides a seamless experience for both customers and administrators. Users can register, log in, browse books, add them to the cart, and complete orders, while the backend handles session management, secure data processing, and order tracking.

---

## 🧰 Technologies Used

### Front-End
- HTML5
- CSS3
- JavaScript
- jQuery
- Bootstrap

### Back-End
- PHP
- MySQL (via phpMyAdmin)
- PHPMailer
- XAMPP
- Visual Studio Code

---

## ⚙️ Features

### For Users:
- Secure registration and login
- Browse books with filters (author, category, price)
- Shopping cart with quantity updates
- Checkout form with email confirmation
- View and manage previous orders
- Profile update functionality

### For Future Admins:
- Inventory management (books, categories)
- Order management
- User and data analytics (optional extension)

---

## 🗃️ Database Overview

The `BookStore` database includes:
- `Users`
- `Books`
- `Authors`
- `Categories`
- `Orders`
- `Order_Items`

It supports secure user data, product listings, and order tracking.

---

## 💻 Installation Instructions

1. Install [XAMPP](https://www.apachefriends.org/index.html)
2. Clone this repository into the `htdocs` folder:
   ```bash
   git clone https://github.com/your-username/bookly.git
   ```
3. Import `BookStore.sql` using phpMyAdmin.
4. Update `conn.php` for database credentials if needed.
5. Access the app in browser at:
   ```
   http://localhost/bookly
   ```

---

## 🚀 Future Improvements

- 🔍 Book recommendations based on user history
- 💳 Online payment integration (PayPal, Stripe)
- 📊 Admin dashboard with stats
- 🌍 Multilingual support
- 🛡️ Enhanced security with CAPTCHA & HTTPS

---

## 📄 License

This project was created for educational and academic purposes. You may reuse and adapt it with proper attribution.

---

## 📬 Contact

📧 dennispalaghiu@gmail.com  
📍 Pitești, Romania
