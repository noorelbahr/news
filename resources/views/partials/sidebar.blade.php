<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">News App</span>
    </a>

    <div class="sidebar">

        <profile></profile>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu-open">
                    <router-link to="news" class="nav-link">
                        <i class="nav-icon fa-solid fa-newspaper"></i>
                        <p>News</p>
                    </router-link>
                </li>
                <li class="nav-item menu-open">
                    <router-link to="logout" class="nav-link">
                        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </router-link>
                </li>
            </ul>
        </nav>

    </div>

</aside>
