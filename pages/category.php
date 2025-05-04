<?php
$category_name = isset($_GET['name']) ? $_GET['name'] : '';

if (empty($category_name)) {
    header('Location: index.php');
    exit;
}

$recipes = getRecipesByCategory($category_name);

$categories = getCategories();
$category_details = null;

foreach ($categories as $category) {
    if ($category['strCategory'] === $category_name) {
        $category_details = $category;
        break;
    }
}
?>

<div class="category-header">
    <div class="container">
        <div class="category-header-content">
            <div class="category-breadcrumbs">
                <a href="index.php">Home</a> &gt; 
                <span><?php echo $category_name; ?> Recipes</span>
            </div>
            
            <h1 class="category-title"><?php echo $category_name; ?> Recipes</h1>
            
            <?php if ($category_details && !empty($category_details['strCategoryDescription'])): ?>
            <div class="category-description">
                <p><?php echo $category_details['strCategoryDescription']; ?></p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if ($category_details && !empty($category_details['strCategoryThumb'])): ?>
        <div class="category-image">
            <img src="<?php echo $category_details['strCategoryThumb']; ?>" alt="<?php echo $category_name; ?>">
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="category-content">
    <div class="container">
        <?php if (!empty($recipes)): ?>
            <div class="recipe-count">
                <p>Found <?php echo count($recipes); ?> recipes in this category</p>
            </div>
            
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <a href="index.php?page=recipe&id=<?php echo $recipe['idMeal']; ?>" class="recipe-card-link">
                        <div class="recipe-card-image">
                            <img src="<?php echo $recipe['strMealThumb']; ?>" alt="<?php echo $recipe['strMeal']; ?>" loading="lazy">
                        </div>
                        <div class="recipe-card-content">
                            <h3 class="recipe-card-title"><?php echo $recipe['strMeal']; ?></h3>
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
                <h2>No Recipes Found</h2>
                <p>Sorry, no recipes were found in the <?php echo $category_name; ?> category.</p>
                <a href="index.php" class="btn btn-primary">Return to Home</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="other-categories">
    <div class="container">
        <h2 class="section-title">Explore Other Categories</h2>
        
        <div class="category-nav">
            <?php 
            foreach ($categories as $category): 
                if ($category['strCategory'] !== $category_name):
            ?>
            <a href="index.php?page=category&name=<?php echo urlencode($category['strCategory']); ?>" class="category-nav-item">
                <?php echo $category['strCategory']; ?>
            </a>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</div>