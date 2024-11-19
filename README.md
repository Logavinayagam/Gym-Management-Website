
# Gym Management System - README

## Overview
This is a **Gym Management System** built using **PHP**, **MySQL**, and **HTML**. It allows the owner to manage gym members, trainers, and various operations. This system ensures unique **Member ID (member_id)** generation within the application logic, removing dependency on database triggers.

---

## Features
### Owner Module:
- Add, update, and delete members and trainers.
- Manage gym announcements and payment details.
- View member and trainer profiles.

### Trainer Module:
- Manage trainees.
- Send personalized workout and diet plans.
- Schedule sessions for trainees.

### Member Module:
- View personal details, trainers, and assigned workout and diet plans.
- Online fee payment.

---

## Installation Guide
### Prerequisites:
1. **XAMPP**: For Apache and MySQL.
2. **VS Code** or any text editor for editing files.
3. Web browser to access the application.

### Steps:
1. Clone or download the project folder into your local XAMPP `htdocs` directory.
2. Import the database:
   - Open **phpMyAdmin**.
   - Create a database named `gym_management`.
   - Import the provided `gym_management.sql` file to set up tables and relationships.
3. Configure database connection:
   - Modify `/config/database.php` with your database credentials.
4. Start XAMPP:
   - Launch Apache and MySQL services.
5. Access the application:
   - Open a web browser and go to `http://localhost/gym-management`.

---

## Member ID Generation
The application generates unique **Member IDs** (`member_id`) directly in PHP. The format is `JRM###`, where:
- **JRM** is the prefix.
- `###` is a zero-padded number based on the current count of members.

### Code Example
The logic resides in the **`add_member.php`** file. When adding a new member:
1. The system counts existing members in the database.
2. Generates a new ID:  
   Example:
   - If 2 members exist, the next `member_id` will be `JRM003`.
3. Inserts the new member along with the `member_id` into the database.

---

## File Structure
- `/config/`: Contains the database connection configuration.
- `/owner/`: Handles owner-related functionalities like adding members.
- `/trainer/`: Manages trainer operations like assigning plans.
- `/member/`: Handles member-specific views and actions.
- `/assets/`: Holds static files like CSS, images, etc.
- `/dashboard.php`: Centralized dashboard for navigation.

---

## How to Add a New Member
1. Log in as the owner.
2. Navigate to the **Add Member** page.
3. Fill out the form with:
   - Name, Height, Weight, Phone Number, Date of Birth, and Location.
4. Submit the form.
5. The system:
   - Verifies the phone number's uniqueness.
   - Generates a unique `member_id`.
   - Inserts the new member into the database.
6. Confirmation with the `member_id` will be displayed.

---

## Troubleshooting
### Common Errors
1. **"Phone number already exists!"**
   - Ensure the entered phone number is unique.

2. **Database connection errors**
   - Verify `/config/database.php` credentials match your local database setup.

3. **Member ID not generated correctly**
   - Ensure the `member_id` column is `VARCHAR` and has no auto-increment.

---

## Future Enhancements
1. Implement more role-based access control.
2. Add an analytics dashboard for gym performance insights.
3. Integrate a mobile app for better accessibility.

---

## License
This project is for educational purposes only and is free to use. Contributions are welcome! 😊

---

### Contact
For queries or suggestions, feel free to reach out!
