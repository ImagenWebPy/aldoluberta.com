<!DOCTYPE html>
<html lang="es">
    <head>

        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?= $this->site_title; ?></title>

        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="Hazel - Simple Blog Template">
        <meta name="author" content="www.imagenwebhq.com">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= IMAGES; ?>favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="<?= IMAGES; ?>apple-touch-icon.png">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, minimum-scale=1.0">

        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Arimo:300,400,600,700,800%7CMontserrat:300,400,600,700,800%7C" rel="stylesheet" type="text/css">

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="<?= VENDORS; ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>animate/animate.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>simple-line-icons/css/simple-line-icons.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>owl.carousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>owl.carousel/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>magnific-popup/magnific-popup.min.css">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?= CSS; ?>style.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= CSS; ?>custom.css">

        <!-- Current Page CSS -->
        <link rel="stylesheet" href="<?= VENDORS; ?>rs-plugin/css/settings.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>rs-plugin/css/layers.css">
        <link rel="stylesheet" href="<?= VENDORS; ?>rs-plugin/css/navigation.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= CSS; ?>custom.css">

        <!-- Head Libs -->
        <script src="<?= VENDORS; ?>modernizr/modernizr.min.js"></script>

    </head>
    <body>
        <div class="page-wrapper boxed">
            <div class="header-wrapper">
                <header id="header" class="header">
                    <div class="header-main">
                        <div class="header-container container">
                            <div class="header-row">
                                <div class="header-column">
                                    <div class="header-logo">
                                        <a href="index-2.html">
                                            <img alt="Hazel" width="181" height="60" src="<?= IMAGES; ?>logo/logo.png" />
                                        </a>
                                    </div>
                                </div>
                                <div class="header-column header-valign-top">
                                    <div class="header-row">
                                        <div class="header-social-links">
                                            <ul class="mega-menu">
                                                <li class="menu-item"><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a><span class="gap">|</span></li>
                                                <li class="menu-item"><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a><span class="gap">|</span></li>
                                                <li class="menu-item"><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a><span class="gap">|</span></li>
                                                <li class="menu-item"><a href="#" title="Pinterest"><i class="fa fa-pinterest-p"></i></a></li>
                                                <li class="menu-item has-sub narrow">
                                                    <span><i class="fa fa-share-alt"></i></span>
                                                    <div class="popup">
                                                        <div class="inner">
                                                            <ul class="sub-menu">
                                                                <li class="menu-item"><a href="#" title="Behance"><i class="fa fa-behance"></i></a></li>
                                                                <li class="menu-item"><a href="#" title="Dribble"><i class="fa fa-dribbble"></i></a></li>
                                                                <li class="menu-item"><a href="#" title="Flickr"><i class="fa fa-flickr"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="header-row">
                                        <div class="header-nav">
                                            <div class="header-search">
                                                <a href="#" class="search-toggle"><i class="fa fa-search"></i></a>
                                                <form class="search-form" action="http://hazel-html.sungeetheme.com/search-results.html" method="get">
                                                    <div class="header-search-wrapper">
                                                        <input type="text" class="form-control" name="s" id="s" placeholder="Enter your Keyword" required>
                                                        <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="header-menu-toggle" data-toggle="collapse" data-target=".header-menu">
                                                <i class="fa fa-bars"></i>
                                            </div>
                                            <div class="header-menu collapse">
                                                <ul class="mega-menu menu-with-symbol">
                                                    <li class="menu-item active"><a href="<?= URL; ?>" title="Inicio">Inicio</a></li>
                                                    <li class="menu-item"><a href="<?= URL; ?>acerca/" title="Un poco de mi">Un poco de mí</a></li>
                                                    <li class="menu-item"><a href="<?= URL; ?>post/" title="Publicaciones">Publicaciones</a></li>
                                                    <li class="menu-item"><a href="<?= URL; ?>galeria/" title="Galería">Galería</a></li>
                                                    <li class="menu-item"><a href="<?= URL; ?>contacto/" title="Contacto">Contacto</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>