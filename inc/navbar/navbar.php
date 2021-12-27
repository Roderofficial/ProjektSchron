<!-- NAVBAR -->
<?php
@session_start();

?>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><i class="fas fa-paw logo"></i> Adopt</a>
        <div class="vl"></div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"><i class="fas fa-home"></i> Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ogloszenia"><i class="fas fa-list"></i> Przeglądaj</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-search"></i> Wyszukiwarka</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-newspaper"></i> Blog</a>
                </li>
            </ul>
            <div class="d-field">
                <?php 
                @session_start();
                if(isset($_SESSION['login']) && $_SESSION['login'] == True){
                    require_once('member_options.php');
                }else{
                    require_once('guest_options.php');
                }
                
                ?>

            </div>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->