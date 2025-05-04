<?php

?>

<div class="favorites-header">
    <div class="container">
        <div class="favorites-header-content">
            <div class="favorites-breadcrumbs">
                <a href="index.php">Home</a> &gt; 
                <span>My Favorites</span>
            </div>
            
            <h1 class="favorites-title">My Favorite Recipes</h1>
            
            <div class="favorites-meta">
                <p class="favorites-count">You have <span id="favorites-count">0</span> favorite recipes.</p>
            </div>
        </div>
    </div>
</div>

<div class="favorites-content">
    <div class="container">
        <div id="favorites-container" class="recipe-grid">
        </div>
        
        <div id="no-favorites" class="no-results">
            <h2>No Favorite Recipes Yet</h2>
            <p>You haven't saved any recipes to your favorites yet.</p>
            <p>Click the heart icon on any recipe to add it to your favorites!</p>
            <a href="index.php" class="btn btn-primary">Browse Recipes</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const favorites = JSON.parse(localStorage.getItem('recipeGeneratorFavorites')) || {};
        const favoritesContainer = document.getElementById('favorites-container');
        const noFavorites = document.getElementById('no-favorites');
        const favoritesCount = document.getElementById('favorites-count');
        
        const favoritesList = Object.values(favorites);
        favoritesCount.textContent = favoritesList.length;
        
        if (favoritesList.length === 0) {
            favoritesContainer.style.display = 'none';
            noFavorites.style.display = 'block';
        } else {
            favoritesContainer.style.display = 'grid';
            noFavorites.style.display = 'none';
            
            favoritesList.forEach(recipe => {
                const recipeCard = document.createElement('div');
                recipeCard.className = 'recipe-card';
                recipeCard.innerHTML = `
                    <a href="index.php?page=recipe&id=${recipe.id}" class="recipe-card-link">
                        <div class="recipe-card-image">
                            <img src="${recipe.img}" alt="${recipe.name}" loading="lazy">
                        </div>
                        <div class="recipe-card-content">
                            <h3 class="recipe-card-title">${recipe.name}</h3>
                        </div>
                    </a>
                    <button class="favorite-button favorited" 
                            data-id="${recipe.id}" 
                            data-name="${recipe.name}" 
                            data-img="${recipe.img}"
                            title="Remove from favorites">
                        <span class="favorite-icon">❤</span>
                    </button>
                `;
                
                favoritesContainer.appendChild(recipeCard);
            });
            
            const favButtons = document.querySelectorAll('.favorite-button');
            
            favButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const recipeId = this.dataset.id;
                    const recipeName = this.dataset.name;
                    const recipeImg = this.dataset.img;
                    
                    let updatedFavorites = JSON.parse(localStorage.getItem('recipeGeneratorFavorites')) || {};
                    
                    if (updatedFavorites[recipeId]) {
                        delete updatedFavorites[recipeId];
                        
                        this.closest('.recipe-card').remove();
                        
                        const updatedCount = Object.keys(updatedFavorites).length;
                        favoritesCount.textContent = updatedCount;
                        
                        if (updatedCount === 0) {
                            favoritesContainer.style.display = 'none';
                            noFavorites.style.display = 'block';
                        }
                    }
                    
                    localStorage.setItem('recipeGeneratorFavorites', JSON.stringify(updatedFavorites));
                });
            });
        }
    });
</script>