
<h1> Check your shopping Cart</h1></br>
<ul class="user-shopping_cart">
<li>your first name: <?php echo htmlentities($_SESSION['first_name']); ?>!</br>
<li>your last name: <?php echo htmlentities($_SESSION['last_name']); ?>!</li></br>

<li>Your email: <?php echo htmlentities($_SESSION['email']); ?>!</li>
</ul>


