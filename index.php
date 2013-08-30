<?php


    if ($_ENV["RADIO_SERVER_CONFIG"])
        require("config/" . $_ENV["RADIO_SERVER_CONFIG"] . ".php");
    else
        require("config/development.php") or die("config can't be found! (or read)");


    require("functions/db.php");
    require("functions/core.php");

    require("functions/news.php");
    require("functions/stats.php");
    require("functions/graph.php");
    require("functions/user.php");
    require("functions/routes.php");



    $query_string = $_SERVER["QUERY_STRING"];


    $route = find_route($query_string);


    if ( ! $route ) {
        redirect("404");
    } else {
        ob_start();

        echo "<!DOCTYPE html>";

        echo "<html>";

            require_once("templates/head.php");

            echo "<body>";

                require_once("templates/navbar.php")

                require_once($route);

                if ($route != $home)
                    require_once("templates/footer.php")

                require_once("templates/postscript.php");

            echo "</body>";

        echo "</html>";

        ob_flush();
    }