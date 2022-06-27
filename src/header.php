<header>
    <ul>
        <li><a href="../view/app.php" class="this">ACTIVE BETS</a></li>
        <li><a href="../view/mybets.php">MY BETS</a></li>
        <li class="right"><a href="../view/myprofile.php"><?php
                echo strtoupper($user->getLogin())."<br>"; ?></a></li>
        <?php if(isset($user->getProfile()['admin']) && $user->getProfile()['admin'] == true)
            echo '<li class="right"><a href="../view/adminpanel.php" class="this">ADMIN PANEL</a></li>';
        ?>
        <li class="right"><a href="../src/logout.php">LOG OUT</a></li>
    </ul>
</header>