<?php
$featured_recipes = getFeaturedRecipes(8);
$categories = getCategories();
$areas = getAreas();
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Discover Delicious Recipes</h1>
            <p class="hero-text">Find and cook amazing meals from around the world</p>
            
            <div class="hero-actions">
                <a href="index.php?page=random" class="btn btn-primary btn-lg">Generate Random Recipe</a>
                <a href="#browse-categories" class="btn btn-outline btn-lg">Browse Categories</a>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($featured_recipes)): ?>
<section class="featured-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Recipes</h2>
            <p class="section-subtitle">Discover our hand-picked selection of delicious recipes</p>
        </div>
        
        <div class="recipe-grid">
            <?php foreach ($featured_recipes as $recipe): ?>
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
    </div>
</section>
<?php endif; ?>

<section id="browse-categories" class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Browse Recipe Categories</h2>
            <p class="section-subtitle">Explore recipes by category</p>
        </div>
        
        <div class="category-grid">
            <?php foreach ($categories as $category): ?>
            <a href="index.php?page=category&name=<?php echo urlencode($category['strCategory']); ?>" class="category-card">
                <div class="category-image">
                    <img src="<?php echo $category['strCategoryThumb']; ?>" alt="<?php echo $category['strCategory']; ?>" loading="lazy">
                </div>
                <h3 class="category-title"><?php echo $category['strCategory']; ?></h3>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cuisines-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Explore World Cuisines</h2>
            <p class="section-subtitle">Discover recipes from around the globe</p>
        </div>
        
        <div class="cuisine-grid">
            <?php foreach ($areas as $area): ?>
            <a href="index.php?page=area&name=<?php echo urlencode($area['strArea']); ?>" class="cuisine-card" style="background-color: <?php echo generatePastelColor(); ?>">
                <h3 class="cuisine-title"><?php echo $area['strArea']; ?></h3>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Feeling Adventurous?</h2>
            <p class="cta-text">Try our random recipe generator and discover something new!</p>
            <a href="index.php?page=random" class="btn btn-accent btn-lg">Generate Random Recipe</a>
        </div>
    </div>
</section>