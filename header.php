<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Url Tester</title>
    <link rel="stylesheet" href="header.css">
</head>

<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

/* Main Title */
h1 {
  background-color: #333;
  color: white;
  padding: 1rem 2rem;
  text-align: center;
  font-size: 2rem;
}

/* Navigation in Aside */
aside {
  background-color: #444;
  padding: 1rem 2rem;
}

aside nav ul {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 2rem;
}

aside nav ul li a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  transition: background 0.3s;
}

aside nav ul li a:hover {
  background-color: #f39c12;
  color: #fff;
}

/* Responsive tweaks */
@media (max-width: 600px) {
  aside nav ul {
    flex-direction: column;
    align-items: center;
  }

  h1 {
    font-size: 1.5rem;
  }
}

</style>




<body>
    <h1>Url Tester</h1>
    <aside>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
        
    </aside>
</body>




</html>