<ul class="sidebar-menu">
    <li class="header">MENU</li>
    <!-- Optionally, you can add icons to the links -->
    <?php if ($authentication->is_group('admin')) { ?>
        <li <?php if ($current_page == "gestione_cv.php") echo "class='active'"; ?>><a href="gestione_cv.php"><i class="fa fa-dashboard"></i> <span>Gestione Cv</span></a></li>
        <li <?php if ($current_page == "risorse_attive.php") echo "class='active'"; ?>><a href="risorse_attive.php"><i class="fa fa-dashboard"></i> <span>Risorse attive</span></a></li>
    <?php } ?>
    <?php if ($authentication->is_group('default')) { ?>
        <li <?php if ($current_page == "myCv.php") echo "class='active'"; ?>><a href="myCv.php"><i class="fa fa-dashboard"></i> <span>Il mio cv</span></a></li>
    <?php } ?>
    <li><a href="index.php?logout"><i class="fa fa-sign-out"></i> <span>Esci</span></a></li>

</ul>