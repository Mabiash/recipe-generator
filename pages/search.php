<?php

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

// If no search query, redirect to home
if (empty($search_query)) {
    header('Location: index.php');
    exit;
}

$recipes = searchRecipes($search_query);
?>

<div class="search-header">
    <div class="container">
        <div class="search-header-content">
            <div class="search-breadcrumbs">
                <a href="index.php">Home</a> &gt; 
                <span>Search Results</span>
            </div>
            
            <h1 class="search-title">Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h1>
            
            <div class="search-meta">
                <p>Found <?php echo count($recipes); ?> recipe(s) matching your search.</p>
            </div>
            
            <div class="search-container search-page-container">
                <form action="index.php" method="GET" class="search-form">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search recipes..." class="search-input" required>
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="search-content">
    <div class="container">
        <?php if (!empty($recipes)): ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <a href="index.php?page=recipe&id=<?php echo $recipe['idMeal']; ?>" class="recipe-card-link">
                        <div class="recipe-card-image">
                            <img src="<?php echo $recipe['strMealThumb']; ?>" alt="<?php echo $recipe['strMeal']; ?>" loading="lazy">
                        </div>
                        <div class="recipe-card-content">
                            <h3 class="recipe-card-title"><?php echo $recipe['strMeal']; ?></h3>
                            <?php if (isset($recipe['strCategory'])): ?>
                            <div class="recipe-card-category">
                                <span class="category-tag"><?php echo $recipe['strCategory']; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <button class="favorite-button" 
                            data-id="<?php echo $recipe['idMeal']; ?>" 
                            data-name="<?php echo htmlspecialchars($recipe['strMeal']); ?>" 
                            data-img="<?php echo $recipe['strMealThumb']; ?>"
                            title="Add to favorites">
                        <span class="favorite-icon">❤</span>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h2>No Results Found</h2>
                <p>Sorry, no recipes were found matching your search term "<?php echo htmlspecialchars($search_query); ?>".</p>
                <p>Try searching for something else or explore our categories below.</p>
                
                <div class="search-suggestions">
                    <h3>Popular Categories</h3>
                    <div class="category-chips">
                        <?php 
                        $categories = getCategories();
                        $categories_to_show = array_slice($categories, 0, 6);
                        
                        foreach ($categories_to_show as $category): 
                        ?>
                        <a href="index.php?page=category&name=<?php echo urlencode($category['strCategory']); ?>" class="category-chip">
                            <?php echo $category['strCategory']; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <a href="index.php" class="btn btn-primary">Return to Home</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($recipes)): ?>
<div class="search-bottom">
    <div class="container">
        <div class="search-related">
            <h2 class="section-title">Explore Categories</h2>
            <div class="category-chips">
                <?php 
                $categories = getCategories();
                $categories_to_show = array_slice($categories, 0, 8);
                
                foreach ($categories_to_show as $category): 
                ?>
                <a href="index.php?page=category&name=<?php echo urlencode($category['strCategory']); ?>" class="category-chip">
                    <?php echo $category['strCategory']; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>