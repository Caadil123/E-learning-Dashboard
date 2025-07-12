<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">OE Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <?php
        foreach ($menus as $menu) {
            if (in_array($menu['ID'], $userMenus)) {
                ?>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $menu['name'] ?>"
                    aria-expanded="true" aria-controls="collapseTwo">

                    <i class="<?= $menu['icon'] ?>"></i>
                    <span><?= $menu['name'] ?></span>
                </a>
                <div id="collapse<?= $menu['name'] ?>" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom <?= $menu['name'] ?></h6>
                        <?php
                        foreach ($subMenus as $sub) {
                            if (in_array($sub['ID'], $userPermissions)) {
                                if ($sub['menu_id'] == $menu['ID']) {
                                    ?>
                                    <a class="collapse-item" href="<?= $sub['href'] ?>"><?= $sub['label'] ?></a>
                                    <!-- <a class="collapse-item" href="cards.html">Cards</a> -->
                                <?php }
                            }
                        } ?>
                    </div>

                </div>
            <?php }
        } ?>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div> -->

</ul>
<!-- End of Sidebar -->