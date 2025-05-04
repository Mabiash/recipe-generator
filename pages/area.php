<?php
$area_name = isset($_GET['name']) ? $_GET['name'] : '';

if (empty($area_name)) {
    header('Location: index.php');
    exit;
}

$recipes = getRecipesByArea($area_name);
?>

<div class="area-header">
    <div class="container">
        <div class="area-header-content">
            <div class="area-breadcrumbs">
                <a href="index.php">Home</a> &gt; 
                <span><?php echo $area_name; ?> Cuisine</span>
            </div>
            
            <h1 class="area-title"><?php echo $area_name; ?> Cuisine</h1>
            
            <div class="area-description">
                <p>Explore delicious recipes from <?php echo $area_name; ?> cuisine.</p>
            </div>
        </div>
    </div>
</div>

<div class="area-content">
    <div class="container">
        <?php if (!empty($recipes)): ?>
            <div class="recipe-count">
                <p>Found <?php echo count($recipes); ?> recipes in <?php echo $area_name; ?> cuisine</p>
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
                <p>Sorry, no recipes were found for <?php echo $area_name; ?> cuisine.</p>
                <a href="index.php" class="btn btn-primary">Return to Home</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="other-areas">
    <div class="container">
        <h2 class="section-title">Explore Other Cuisines</h2>
        
        <div class="area-nav">
            <?php 
            $areas = getAreas();
            foreach ($areas as $area): 
                if ($area['strArea'] !== $area_name):
            ?>
            <a href="index.php?page=area&name=<?php echo urlencode($area['strArea']); ?>" class="area-nav-item">
                <?php echo $area['strArea']; ?>
            </a>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</div>
