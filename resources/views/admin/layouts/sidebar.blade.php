<div class="navsidevar" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="/admin/welcome" class="nav__link nav__logo">
                <i class='bx bxs-home nav__icon'></i>
                <span class="nav__logo-name">خانه</span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">فهرست</h3>
                        <div class="nav__dropdown">
                            <a href="#" class="nav__link">
                                <i class='bx bxs-dashboard nav__icon'></i>
                                <span class="nav__name">داشبورد</span>
                                <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                            </a>
                            <div class="nav__dropdown-collapse">
                                <div class="nav__dropdown-content">
                                    <a href="/admin/tasks" class="nav__dropdown-item">مدیریت وظایف</a>
                                    <a href="/api/documentation" class="nav__dropdown-item">مستندات api </a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <a href="/logout" class="nav__link nav__logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">خروج</span>
        </a>
        <form id="logout-form" action="/logout" method="POST">
            @csrf
        </form>
    </nav>
</div>
