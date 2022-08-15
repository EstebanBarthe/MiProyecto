<?php

    //echo("Estoy iniciando mi proyecto");
    //phpinfo();
    
?>

<!DOCTYPE html>
    <html>
        <head>
            <!--Import Google Icon Font-->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <!--Import materialize.css-->
            <link type="text/css" rel="stylesheet" href="web/css/materialize.min.css"  media="screen,projection"/>
            <!--Let browser know website is optimized for mobile-->
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <style>
                body {
                    display: flex;
                    min-height: 100vh;
                    flex-direction: column;
                    }
                main{
                    flex: 1 0 auto;
                    }
                table.striped > tbody > tr:nth-child(odd) {
                    background-color: #a5d6a7;
                    }
                    .pagination li.active {
                        background-color: #a5d6a7;
                    }
            </style>
        </head>
        <body>
            <!--JavaScript at end of body for optimized loading-->
            <script type="text/javascript" src="web/js/materialize.min.js"></script>
            <nav>
                <div class="nav-wrapper green darken-4">
                    <a href="#!" class="brand-logo center"><span class="grey-text text-darken-4">PMH.FC</span></a>
                        <ul class="right hide-on-med-and-down">
                        <li>
                            <a href="index.php?r=Deportistas"><i class="material-icons">sports_soccer</i></a>
                        </li>
                        <li>
                            <a href="index.php?r=Administrador"><i class="material-icons">admin_panel_settings</i></a>
                        </li>
                        <li>
                            <a href="index.php?r=Noticias"><i class="material-icons"><span class="material-icons">notifications</span></i></a>
                        </li>
                        <li>
                            <a href="index.php?r=Menu"><i class="material-icons">menu</i></a>
                        </li>
                        </ul>
                </div>
            </nav>
            <body>
                <main>
                <div class="container">
                <?php include("router.php"); ?>
                </div>
                </main>      
                    <footer class="page-footer green darken-4">
                        <div class="container">
                            <div class="row">
                                <div class="col l6 s12"></div>
                            </div>
                        </div>
                        <div class="footer-copyright">
                            <div class="container">
                                © 2014 Copyright Text
                                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
                            </div>
                        </div>
                    </footer>
                    <script type="text/javascript" src="web/js/materialize.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var elems = document.querySelectorAll('.carousel');
                        var instances = M.Carousel.init(elems, options);
                        });
                        M.AutoInit();
                    </script>
                </body>
        </body>
    </html>