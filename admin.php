<?php

session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    
    header("Location: 404.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesm.css">
    
    <title>IntelliHost Admin</title>
    <link rel="icon" href="image/logo1.png" type="image/png" />
    <meta property="og:image" content="image/logo1.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <meta property="og:image" content="image/logo1.png">
    <body style="background-color:lightyellow"></body>
</head>

<body>
 <!-- Navbar -->
 <nav class="navbar">
    <div class="logo">
        <a href="admin.php">
            <span style="color: navy;">Intelli</span> 
            <span style="color: burlywood;">Host</span>
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="service.html">Services</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
    </ul>
</nav>

<marquee behavior="scroll" direction="left" scrollamount="8" style=" color:whitesmoke;">
    <font color="#FFD700"><b>⭐ Book Now ⭐</b></font> | 
    <font color="#00008B"><b>Intelli Host offers a safe and comfortable living experience for students and individuals seeking accommodation in Pune.</b></font> | 
    <font color="#00008B"><b>IntelliHost Hospitality privated limited</b></font> | 
    <font color="#FFD700"><b>⭐ Refer Now ⭐</b></font> | 
    <font color="#32CD32"><b>✨ Contact Us ✨</b></font> | 
    <font color="#00008B"><b>Address: Pune, Maharashtra, India, Ground floor, A-04 ,, Anjana apartment Bhekrai Nagar ,Hadpsar-412308</b></font> | 
    <font color="#00008B"><b>📞 Phone: +919067574790</b></font> | 
    <font color="#00008B"><b>✉ Email: intellihost7@gmail.com</b></font>
</marquee>

<!-- New Section for Viewers, Likes, and Subscribes -->
<main>
    <div class="stats-container">
        <div class="stat-item">
            <i class="fas fa-eye"></i>
            <h3>Viewers</h3>
            <p id="viewers-count">Loading...</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-thumbs-up"></i>
            <h3>Likes</h3>
            <p id="likes-count">3,650</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-bell"></i>
            <h3>Subscribers</h3>
            <p id="subscribers-count">1,024</p>
        </div>
    </div>

    <!-- Your existing content -->
    <aside>
        <ul>
            <h1>Dashboard</h1>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="#users">Users</a></li>
            <li><a href="#Setting">Setting</a></li>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="service.html">Service</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </aside>

    <section id="users">
        <h2>All Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>userid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="users-list"></tbody>
        </table>
    </section>
    



    
    <section id="contact-users">
        <h2>Contact Queries</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Query</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="contact-queries-list"></tbody>
        </table>
    </section>

    <section id="crud-operations">
        <button id="add-user-btn">Add New User</button>
    </section>
</main>

<script>
    fetch('getViewerCount.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('viewers-count').innerText = data.count;
        })
        .catch(error => console.error('Error fetching viewer count:', error));
</script>

<script src="script.js"></script>
</body>
</html>
