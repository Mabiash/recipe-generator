</main>
    
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-heading">Recipe Generator</h3>
                    <p class="footer-text">Discover delicious recipes from around the world. Find, cook, and enjoy!</p>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?page=random">Random Recipe</a></li>
                        <li><a href="index.php?page=favorites">Favorites</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-heading">Categories</h3>
                    <ul class="footer-links">
                        <?php
                        // Get a few categories to display in footer
                        $categories = getCategories();
                        $categories_to_show = array_slice($categories, 0, 5);
                        
                        foreach ($categories_to_show as $category) {
                            echo '<li><a href="index.php?page=category&name=' . urlencode($category['strCategory']) . '">' . $category['strCategory'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-heading">Cuisines</h3>
                    <ul class="footer-links">
                        <?php
                        // Get a few areas to display in footer
                        $areas = getAreas();
                        $areas_to_show = array_slice($areas, 0, 5);
                        
                        foreach ($areas_to_show as $area) {
                            echo '<li><a href="index.php?page=area&name=' . urlencode($area['strArea']) . '">' . $area['strArea'] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Recipe Generator. Powered by Daryl
            </div>
        </div>
    </footer>
    
    <script>
        // Simple JavaScript for mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                    menuToggle.classList.toggle('active');
                });
            }
            
            // Add functionality for favorite buttons
            const favButtons = document.querySelectorAll('.favorite-button');
            
            favButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const recipeId = this.dataset.id;
                    const recipeName = this.dataset.name;
                    const recipeImg = this.dataset.img;
                    
                    // Get existing favorites from localStorage
                    let favorites = JSON.parse(localStorage.getItem('recipeGeneratorFavorites')) || {};
                    
                    if (favorites[recipeId]) {
                        // Remove from favorites
                        delete favorites[recipeId];
                        this.classList.remove('favorited');
                        this.title = "Add to favorites";
                    } else {
                        // Add to favorites
                        favorites[recipeId] = {
                            id: recipeId,
                            name: recipeName,
                            img: recipeImg
                        };
                        this.classList.add('favorited');
                        this.title = "Remove from favorites";
                    }
                    
                    // Save back to localStorage
                    localStorage.setItem('recipeGeneratorFavorites', JSON.stringify(favorites));
                    
                    // Update button text
                    const textSpan = this.querySelector('.button-text');
                    if (textSpan) {
                        textSpan.textContent = favorites[recipeId] ? 'Favorited' : 'Add to Favorites';
                    }
                });
                
                const recipeId = button.dataset.id;
                if (recipeId) {
                    let favorites = JSON.parse(localStorage.getItem('recipeGeneratorFavorites')) || {};
                    
                    if (favorites[recipeId]) {
                        button.classList.add('favorited');
                        button.title = "Remove from favorites";
                        
                        const textSpan = button.querySelector('.button-text');
                        if (textSpan) {
                            textSpan.textContent = 'Favorited';
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>