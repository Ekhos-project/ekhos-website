<?php
get_header();

if (is_front_page()) {
    include_once "pages/home.php";
} else {
    echo "building...";
}

get_footer();
