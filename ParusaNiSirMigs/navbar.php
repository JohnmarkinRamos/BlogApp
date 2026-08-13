<?php
$__initial = isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 1)) : '?';
?>
<nav class="navbar">

    <div class="nav-left">

        <a href="community.php" class="logo">blog</a>

        <div class="nav-search">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Search Blog App" disabled>
        </div>

    </div>

    <div class="nav-center">

        <a href="community.php" class="nav-icon-link" title="Community Feed">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11l9-8 9 8"></path>
                <path d="M5 10v10h14V10"></path>
            </svg>
            <span>Feed</span>
        </a>

        <a href="my_post.php" class="nav-icon-link" title="My Posts">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                <line x1="8" y1="9" x2="16" y2="9"></line>
                <line x1="8" y1="13" x2="16" y2="13"></line>
                <line x1="8" y1="17" x2="12" y2="17"></line>
            </svg>
            <span>My Posts</span>
        </a>

        <a href="add_post.php" class="nav-icon-link" title="New Post">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>New Post</span>
        </a>

    </div>

    <div class="nav-right">

        <div class="nav-profile">

            <div class="avatar avatar-sm"><?= htmlspecialchars($__initial); ?></div>

            <span><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></span>

        </div>

        <a href="logout.php" class="logout">Logout</a>

    </div>

</nav>