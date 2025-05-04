<?php
// Get a random recipe
$random_recipes = getRandomRecipes(1);

if (empty($random_recipes)) {
    echo '<div class="container">';
    echo '<div class="error-message">';
    echo '<h2>Error Generating Random Recipe</h2>';
    echo '<p>Sorry, we couldn\'t generate a random recipe at this time. Please try again later.</p>';
    echo '<a href="index.php" class="btn btn-primary">Return to Home</a>';
    echo '</div>';
    echo '</div>';
    exit;
}

// Get the recipe
$recipe = $random_recipes[0];

// Redirect to the recipe page
header('Location: index.php?page=recipe&id=' . $recipe['idMeal']);
exit;
?>