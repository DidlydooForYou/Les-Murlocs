<?php
require_once SOURCE . '/initialization.php';
?>
<header>        
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fourth navbar example">
                <div class="container-fluid">
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                <a class="nav-link <? ACTIVE_PAGE === Page::Menu ? 'active' : ''?>" aria-current="page" href="<?= Page::Menu->url()?>"><?= Page::Menu->text()?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <? ACTIVE_PAGE === Page::Vitrine ? 'active' : ''?>" aria-current="page" href="<?= Page::Vitrine->url()?>"><?= Page::Vitrine->text()?></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">Services</a></li>
                                    <li><a class="dropdown-item" href="">Location</a></li>
                                    <li><a class="dropdown-item" href="">Achat</a></li>
                                </ul>
                            </li>
                        </ul>

                        <!--
                        =======================
                        A remettre quand login et logout sont fait
                        =======================
                        -->
                        <!--<ul class="navbar-nav">
                            <li class="nav-items">
                                <?php if(IS_AUTH) : ?>
                                    <a class="nav-link" href="< Page::Logout->url()?>"><Page::Logout->text() ?></a>
                                <?php else : ?>
                                    <a class="nav-link <?= ACTIVE_PAGE === Page::Connexion ? 'active' : ''?>" href="<?= Page::Connexion->url() ?>"><?= Page::Connexion->text() ?></a>
                                <?php endif; ?>
                            </li>--> 
                        
                        <!--
                        =======================
                        A remettre quand l'administration est faite
                        =======================
                        -->
                        <!--
                            <?php if(IS_ADMIN) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Administration</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="< Page::AdminProducts->url() ?>">< Page::AdminProducts->text()?></a>
                                        <a class="dropdown-item" href="< Page::AdminProductAdd->url() ?>">< Page::AdminProductAdd->text()?></a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif;?>
                        </ul>
                        -->
                        
                        <form class="ms-2" role="search" action="<?= Page::Vitrine->url()?>">
                            <input name="research" class="form-control" type="search" placeholder="Research" aria-label="Search">
                        </form>

                    </div>
                </div>
            </nav>

</header>