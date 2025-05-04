<?php
include_once 'includes/functions.php';
include_once 'includes/api.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

include_once 'templates/header.php';

switch ($page) {
    case 'recipe':
        include_once 'pages/recipe.php';
        break;
    case 'category':
        include_once 'pages/category.php';
        break;
    case 'area':
        include_once 'pages/area.php';
        break;
    case 'search':
        include_once 'pages/search.php';
        break;
    case 'random':
        include_once 'pages/random.php';
        break;
    case 'favorites':
        include_once 'pages/favorites.php';
        break;
    default:
        include_once 'pages/home.php';
        break;
}


include_once 'templates/footer.php';
?>