<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sistem PKL</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                        accent: '#10b981',
                        dark: '#1f2937',
                        light: '#f9fafb',
                        'card-bg': '#ffffff'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'slide-in-left': 'slideInLeft 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.15);
        }

        .active-menu {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
            font-weight: 600;
        }

        .greeting-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                height: 100vh;
                z-index: 50;
                width: 280px;
                overflow-y: auto;
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            }

            .sidebar.active {
                left: 0;
                animation: slideInLeft 0.3s ease-out;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            .overlay.active {
                display: block;
                animation: fadeIn 0.3s ease-out;
            }
            .mobile-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 60px;
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                color: white;
                z-index: 45;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 16px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .hamburger-menu {
                transition: transform 0.3s ease;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 8px;
                padding: 8px;
            }

            .hamburger-menu.active {
                transform: rotate(90deg);
            }
            .mobile-content-padding {
                padding-top: 60px;
            }
            nav a {
                color: #4b5563;
            }
            nav a:hover, nav a.active-menu {
                color: #1e40af;
                background-color: #eff6ff;
            }
        }

        @media (min-width: 769px) {
            .sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                overflow-y: auto;
            }

            .overlay {
                display: none !important;
            }
            .mobile-header {
                display: none;
            }

            .desktop-content-margin {
                margin-left: 0;
            }
            .mobile-content-padding {
                padding-top: 0;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        body.no-scroll {
            overflow: hidden;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content-area {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-50">
    @auth
        <header class="mobile-header">
            <button id="mobile-menu-toggle" class="hamburger-menu">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </header>

        <div class="overlay" id="overlay"></div>
    @endauth

    <div class="app-container">
        @auth
            <aside class="sidebar w-64 bg-white shadow-xl flex flex-col shrink-0">
                @include('partials.sidebar')
            </aside>
        @endauth

        <div class="main-content-area flex-1 @auth mobile-content-padding @endauth">
            <main class="p-4 md:p-6 min-h-full">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('overlay');
            const hamburgerMenu = document.querySelector('.hamburger-menu');
            const body = document.body;

            function toggleSidebar() {
                const isOpening = !sidebar.classList.contains('active');
                sidebar.classList.toggle('active');
                if (overlay) overlay.classList.toggle('active');
                if (hamburgerMenu) {
                    hamburgerMenu.classList.toggle('active');
                }

                if (window.innerWidth <= 768) {
                    if (isOpening) {
                        body.classList.add('no-scroll');
                    } else {
                        body.classList.remove('no-scroll');
                    }
                }
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }

            function setupProfileToggle() {
                const profileToggle = document.getElementById('profile-toggle');
                if (profileToggle) {
                    profileToggle.replaceWith(profileToggle.cloneNode(true));

                    const newProfileToggle = document.getElementById('profile-toggle');
                    newProfileToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const menu = document.getElementById('profile-menu');
                        const icon = document.getElementById('profile-chevron');

                        if (menu && icon) {
                            menu.classList.toggle('hidden');
                            icon.style.transform = menu.classList.contains('hidden')
                                ? 'rotate(0deg)'
                                : 'rotate(180deg)';
                        }
                    });
                }
            }

            setupProfileToggle();

            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('active')) {
                    if (e.target.closest('.sidebar a') && !e.target.closest('#profile-toggle')) {
                        toggleSidebar();
                    }
                }

                const profileMenu = document.getElementById('profile-menu');
                const profileToggle = document.getElementById('profile-toggle');

                if (profileMenu && !profileMenu.contains(e.target) &&
                    profileToggle && !profileToggle.contains(e.target)) {
                    if (!profileMenu.classList.contains('hidden')) {
                        profileMenu.classList.add('hidden');
                        const icon = document.getElementById('profile-chevron');
                        if (icon) {
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            });

            function handleResize() {
                if (window.innerWidth > 768) {
                    if (sidebar && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                    if (overlay) overlay.classList.remove('active');
                    if (hamburgerMenu) hamburgerMenu.classList.remove('active');
                    body.classList.remove('no-scroll');
                }

                setupProfileToggle();
            }

            window.addEventListener('resize', handleResize);

            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar a[href]').forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath === currentPath ||
                    (linkPath !== '#' && currentPath.startsWith(linkPath) && linkPath !== '/')) {
                    link.classList.add('active-menu');
                }
            });

            const sidebarCloseBtn = document.getElementById('sidebar-close');
            if (sidebarCloseBtn) {
                sidebarCloseBtn.addEventListener('click', toggleSidebar);
            }

            document.querySelectorAll('.sidebar nav a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        document.querySelectorAll('.sidebar nav a').forEach(item => {
                            item.classList.remove('active-menu');
                        });
                        this.classList.add('active-menu');
                    }
                });
            });
        });

        function setActiveMenuFromUrl() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar a.nav-menu-item');

            menuItems.forEach(item => {
                item.classList.remove('active-menu');

                const href = item.getAttribute('href');
                if (href && currentPath === href) {
                    item.classList.add('active-menu');
                } else if (href && href !== '#' && href !== '/' && currentPath.startsWith(href)) {
                    item.classList.add('active-menu');
                }
            });
        }

        setActiveMenuFromUrl();

        document.addEventListener('click', function(e) {
            if (e.target.closest('.sidebar a.nav-menu-item')) {
                const clickedItem = e.target.closest('.sidebar a.nav-menu-item');

                document.querySelectorAll('.sidebar a.nav-menu-item').forEach(item => {
                    item.classList.remove('active-menu');
                });

                clickedItem.classList.add('active-menu');

                const menuName = clickedItem.getAttribute('data-menu');
                if (menuName) {
                    localStorage.setItem('activeMenu', menuName);
                }
            }
        });

        const savedMenu = localStorage.getItem('activeMenu');
        if (savedMenu) {
            const savedMenuItem = document.querySelector(`.sidebar a.nav-menu-item[data-menu="${savedMenu}"]`);
            if (savedMenuItem && !savedMenuItem.classList.contains('active-menu')) {
                document.querySelectorAll('.sidebar a.nav-menu-item').forEach(item => {
                    item.classList.remove('active-menu');
                });
                savedMenuItem.classList.add('active-menu');
            }
        }

    </script>

    @yield('scripts')
</body>
</html>
