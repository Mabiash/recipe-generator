<?php
// Get current page for active menu highlighting
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page_title = '';

// Set page title based on current page
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'recipe':
            $recipe_id = isset($_GET['id']) ? $_GET['id'] : '';
            if (!empty($recipe_id)) {
                $recipe = getRecipeById($recipe_id);
                $page_title = $recipe ? getPageTitle('recipe', $recipe['strMeal']) : getPageTitle('recipe');
            } else {
                $page_title = getPageTitle('recipe');
            }
            break;
        case 'category':
            $category = isset($_GET['name']) ? $_GET['name'] : '';
            $page_title = getPageTitle('category', $category);
            break;
        case 'area':
            $area = isset($_GET['name']) ? $_GET['name'] : '';
            $page_title = getPageTitle('area', $area);
            break;
        case 'search':
            $page_title = getPageTitle('search');
            break;
        case 'random':
            $page_title = getPageTitle('random');
            break;
        case 'favorites':
            $page_title = getPageTitle('favorites');
            break;
        default:
            $page_title = getPageTitle('home');
    }
} else {
    $page_title = getPageTitle('home');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <span class="logo-icon">🍽️</span>
                    <span class="logo-text">Recipe<span class="text-primary">Generator</span></span>
                </a>
                
                <div class="search-container">
                    <form action="index.php" method="GET" class="search-form">
                        <input type="hidden" name="page" value="search">
                        <input type="text" name="q" placeholder="Search recipes..." class="search-input" required>
                        <button type="submit" class="search-button">Search</button>
                    </form>
                </div>
                
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li class="nav-item <?php echo $current_page === 'home' ? 'active' : ''; ?>">
                            <a href="index.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item <?php echo $current_page === 'random' ? 'active' : ''; ?>">
                            <a href="index.php?page=random" class="nav-link">Random Recipe</a>
                        </li>
                        <li class="nav-item <?php echo $current_page === 'favorites' ? 'active' : ''; ?>">
                            <a href="index.php?page=favorites" class="nav-link">Favorites</a>
                        </li>
                    </ul>
                </nav>
                
                <button class="mobile-menu-toggle" aria-label="Toggle menu">
                    <span class="menu-bar"></span>
                    <span class="menu-bar"></span>
                    <span class="menu-bar"></span>
                </button>
            </div>
        </div>
    </header>
    
    <div class="mobile-menu">
        <div class="mobile-search">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="page" value="search">
                <input type="text" name="q" placeholder="Search recipes..." class="search-input" required>
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item <?php echo $current_page === 'home' ? 'active' : ''; ?>">
                    <a href="index.php" class="mobile-nav-link">Home</a>
                </li>
                <li class="mobile-nav-item <?php echo $current_page === 'random' ? 'active' : ''; ?>">
                    <a href="index.php?page=random" class="mobile-nav-link">Random Recipe</a>
                </li>
                <li class="mobile-nav-item <?php echo $current_page === 'favorites' ? 'active' : ''; ?>">
                    <a href="index.php?page=favorites" class="mobile-nav-link">Favorites</a>
                </li>
            </ul>
        </nav>
    </div>
    
    <main class="main-content">