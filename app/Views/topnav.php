<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="/img/logo.ico" width="30" height="30" alt="" class="d-inline-block align-top">
        Home
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <?php echo $UILocale['Server Tools']?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/servertools/roadshop"><?php echo $UILocale['Roadshop Editor']?></a>
                    <a class="dropdown-item" href="/servertools/distributions"><?php echo $UILocale['Distribution Editor']?></a>
                    <a class="dropdown-item" href="/servertools/gacha"><?php echo $UILocale['Gacha Editor']?></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <?php echo $UILocale['Language']?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/language/en_GB">English</a>
                    <a class="dropdown-item" href="/language/ja_JP">日本語</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
