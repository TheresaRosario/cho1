<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>City Health Office Inventory Supply</title>
  <style>
    /* Your existing CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('d.png'); /* Palitan 'd.png' ng tamang lokasyon o URL ng iyong larawan */
      background-size: cover; /* Palitan mula 'contain' papunta sa 'cover' */
      background-repeat: no-repeat;
      background-position: center;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.10); /* Baguhin ang opacity base sa kagustuhan mo; ang apat na parameter ay Red, Green, Blue, at Alpha (opacity) */
    }
    
    header {
      background-color: #1F9314;
      color: #fff;
      text-align: center;
      padding: 1rem 0;
    }
    main {
      padding: 2rem;
    }
    h1, h2 {
      margin-top: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table th, table td {
      padding: 0.5rem;
      border-bottom: 1px solid #ddd;
    }
    #contact {
      text-align: center;
      margin-bottom: 2rem;
    }
    #contact ul {
      list-style: none;
      padding: 0;
    }
    footer {
      background-color: #0C6E03;
      color: #fff;
      text-align: center;
      padding: 1rem 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    #logo {
      bottom: 10px;
      left: 45%;
      width: 500px;
      height: auto;
      margin-left: 30%;
    }

    /* CSS for the button */
    .redirect-button {
      background-color: #063B01; /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-left: 48%;
      cursor: pointer;
      border-radius: 10px; /* Rounded corners */
    }
  </style>
</head>
<body>
  <header>
    <h1><marquee behavior="" direction="left">Welcome to City Health Office Inventory System</marquee></h1>
  </header>
   <div id="logo">
  <img id="logo" src="logo.png" alt="City Health Office Logo">
</div>
  <a href="/system1/Dashboard.php"><button class="redirect-button">LOG IN</button></a>
  
  <footer>
    <section id="footer-contact">
      <!-- <p>If you have any inquiries or need assistance regarding our inventory supply, please feel free to contact us at:</p>
      <ul> -->
        <li>Address: City Health Office, San Carlos City Pangasinan, Philippines</li>
      </ul>
    </section>
    <p>&copy; 2024 City Health Office. All rights reserved.</p>
  </footer>
</body>
</html>
