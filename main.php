<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); ?>
    <?php include 'header.php'; ?>
    <?php require_once 'Database.php'; ?>
    <link rel="stylesheet" href="styles/main.css">
    
</head>
<style>
    table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

thead {
  background-color: #f4f4f4;
}

th, td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

tr:hover {
  background-color: #f1f1f1;
}

th {
  font-weight: bold;
  color: #333;
}

td {
  color: #555;
}
</style>
<style>
    form {
  background-color: #ffffff;
  padding: 2rem;
  margin: 2rem auto;
  max-width: 500px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  text-align: center;
}

form label {
  font-size: 1rem;
  font-weight: 600;
  display: block;
  margin-bottom: 0.5rem;
  color: #333;
}

form input[type="text"] {
  width: 90%;
  padding: 0.75rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 1rem;
  transition: border-color 0.3s;


}
</style>


<?php 

  $id = $_SESSION['user_id'];
  $query = "SELECT url_name, certName, certIssuer, certExpirate, responseCode
            FROM url
            WHERE user_id = :id";

  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->execute();
  $urls = $statement->fetchAll();
  $statement->closeCursor();


?>

<body>
    <form action="URL.php" method="post">
        <label for="URL">Enter URL</label> <br>
        <input type="text" name='url'  placeholder="https://www.example.com">
        <input type="submit" value="Enter">
    </form> <br>



    <table>
        <thead>
            <th>URL Name</th>
            <th>SSL Certificate </th>
            <th>Certificate Issuer</th>
            <th>Certificate Expiration</th>
            <th>Response Code</th>
            <th>Response Header</th>
            
        </thead>
        <?php foreach($urls as $url): ?>
          <tr>
            <td>  <?php echo htmlspecialchars($url['url_name']) ?> </td>
            <td>  <?php echo htmlspecialchars($url['certName']) ?> </td>
            <td>  <?php echo htmlspecialchars($url['certIssuer']) ?> </td>
            <td>  <?php echo htmlspecialchars($url['certExpirate']) ?> </td>
            <td>  <?php echo htmlspecialchars($url['responseCode']) ?> </td>
        </tr>
        <?php endforeach; ?>
    </table>


    
</body>
</html>