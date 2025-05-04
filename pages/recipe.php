<?php
$recipe_id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($recipe_id)) {
    header('Location: index.php');
    exit;
}

$recipe = getRecipeById($recipe_id);

if (!$recipe) {
    echo '<div class="container">';
    echo '<div class="error-message">';
    echo '<h2>Recipe Not Found</h2>';
    echo '<p>Sorry, the recipe you are looking for could not be found.</p>';
    echo '<a href="index.php" class="btn btn-primary">Return to Home</a>';
    echo '</div>';
    echo '</div>';
    exit;
}

$ingredients = formatIngredients($recipe);
$instructions = formatInstructions($recipe['strInstructions']);
$youtube_embed = getYoutubeEmbedUrl($recipe['strYoutube']);
?>

<div class="recipe-header">
    <div class="container">
        <div class="recipe-header-content">
            <div class="recipe-details">
                <div class="recipe-breadcrumbs">
                    <a href="index.php">Home</a> &gt; 
                    <?php if (!empty($recipe['strCategory'])): ?>
                    <a href="index.php?page=category&name=<?php echo urlencode($recipe['strCategory']); ?>"><?php echo $recipe['strCategory']; ?></a> &gt; 
                    <?php endif; ?>
                    <span><?php echo $recipe['strMeal']; ?></span>
                </div>
                
                <h1 class="recipe-title"><?php echo $recipe['strMeal']; ?></h1>
                
                <div class="recipe-meta">
                    <?php if (!empty($recipe['strCategory'])): ?>
                    <div class="recipe-meta-item">
                        <span class="meta-label">Category:</span>
                        <a href="index.php?page=category&name=<?php echo urlencode($recipe['strCategory']); ?>" class="meta-value"><?php echo $recipe['strCategory']; ?></a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($recipe['strArea'])): ?>
                    <div class="recipe-meta-item">
                        <span class="meta-label">Cuisine:</span>
                        <a href="index.php?page=area&name=<?php echo urlencode($recipe['strArea']); ?>" class="meta-value"><?php echo $recipe['strArea']; ?></a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($recipe['strTags'])): ?>
                    <div class="recipe-meta-item recipe-tags">
                        <span class="meta-label">Tags:</span>
                        <div class="tags-container">
                            <?php 
                            $tags = explode(',', $recipe['strTags']);
                            foreach ($tags as $tag): 
                                $tag = trim($tag);
                                if (!empty($tag)):
                            ?>
                            <span class="tag"><?php echo $tag; ?></span>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="recipe-actions">
                    <button class="btn btn-outline favorite-button" 
                            data-id="<?php echo $recipe['idMeal']; ?>" 
                            data-name="<?php echo htmlspecialchars($recipe['strMeal']); ?>" 
                            data-img="<?php echo $recipe['strMealThumb']; ?>"
                            title="Add to favorites">
                        <span class="favorite-icon">❤</span>
                        <span class="button-text">Add to Favorites</span>
                    </button>
                    
                    <button class="btn btn-secondary" onclick="window.print();">
                        <span class="print-icon">🖨️</span>
                        <span class="button-text">Print Recipe</span>
                    </button>
                </div>
            </div>
            
            <div class="recipe-image">
                <img src="<?php echo $recipe['strMealThumb']; ?>" alt="<?php echo $recipe['strMeal']; ?>">
            </div>
        </div>
    </div>
</div>

<div class="recipe-content">
    <div class="container">
        <div class="recipe-grid">
            <div class="recipe-ingredients">
                <h2 class="content-title">Ingredients</h2>
                
                <?php if (!empty($ingredients)): ?>
                <ul class="ingredients-list">
                    <?php foreach ($ingredients as $ingredient): ?>
                    <li class="ingredient-item">
                        <span class="ingredient-measure"><?php echo $ingredient['measure']; ?></span>
                        <span class="ingredient-name"><?php echo $ingredient['name']; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>No ingredients listed for this recipe.</p>
                <?php endif; ?>
            </div>
            
            <div class="recipe-instructions">
                <h2 class="content-title">Instructions</h2>
                
                <?php if (!empty($instructions)): ?>
                <ol class="instructions-list">
                    <?php foreach ($instructions as $index => $step): ?>
                    <li class="instruction-step">
                        <span class="step-number"><?php echo $index + 1; ?></span>
                        <p class="step-text"><?php echo $step; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ol>
                <?php else: ?>
                <p>No instructions provided for this recipe.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($youtube_embed)): ?>
        <div class="recipe-video">
            <h2 class="content-title">Video Tutorial</h2>
            <div class="video-wrapper">
                <iframe 
                    width="560" 
                    height="315" 
                    src="<?php echo $youtube_embed; ?>" 
                    title="<?php echo $recipe['strMeal']; ?> Video Tutorial" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="related-recipes">
    <div class="container">
        <h2 class="section-title">You Might Also Like</h2>
        
        <?php 
        // Get related recipes from same category
        $related_recipes = [];
        if (!empty($recipe['strCategory'])) {
            $category_recipes = getRecipesByCategory($recipe['strCategory']);
            
            // Get up to 4 random recipes from the same category (excluding current recipe)
            $filtered_recipes = array_filter($category_recipes, function($r) use ($recipe_id) {
                return $r['idMeal'] !== $recipe_id;
            });
            
            // If we have more than 4 recipes, get 4 random ones
            if (count($filtered_recipes) > 4) {
                $keys = array_rand($filtered_recipes, 4);
                if (!is_array($keys)) {
                    $keys = [$keys];
                }
                foreach ($keys as $key) {
                    $related_recipes[] = $filtered_recipes[$key];
                }
            } else {
                $related_recipes = $filtered_recipes;
            }
        }
        
        // If we don't have enough related recipes, add some random ones
        if (count($related_recipes) < 4) {
            $random_recipes = getRandomRecipes(4 - count($related_recipes));
            $related_recipes = array_merge($related_recipes, $random_recipes);
        }
        ?>
        
        <?php if (!empty($related_recipes)): ?>
        <div class="recipe-grid related-grid">
            <?php foreach ($related_recipes as $related): ?>
            <div class="recipe-card">
                <a href="index.php?page=recipe&id=<?php echo $related['idMeal']; ?>" class="recipe-card-link">
                    <div class="recipe-card-image">
                        <img src="<?php echo $related['strMealThumb']; ?>" alt="<?php echo $related['strMeal']; ?>" loading="lazy">
                    </div>
                    <div class="recipe-card-content">
                        <h3 class="recipe-card-title"><?php echo $related['strMeal']; ?></h3>
                    </div>
                </a>
                <button class="favorite-button" 
                        data-id="<?php echo $related['idMeal']; ?>" 
                        data-name="<?php echo htmlspecialchars($related['strMeal']); ?>" 
                        data-img="<?php echo $related['strMealThumb']; ?>"
                        title="Add to favorites">
                    <span class="favorite-icon">❤</span>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>No related recipes found.</p>
        <?php endif; ?>
    </div>
</div>