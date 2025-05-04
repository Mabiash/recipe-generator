<?php
function formatIngredients($recipe) {
    $ingredients = [];
    
    for ($i = 1; $i <= 20; $i++) {
        $ingredient = $recipe["strIngredient{$i}"];
        $measure = $recipe["strMeasure{$i}"];
        
        if (!empty($ingredient) && $ingredient !== null && trim($ingredient) !== '') {
            $ingredients[] = [
                'name' => $ingredient,
                'measure' => $measure
            ];
        }
    }
    
    return $ingredients;
}
function getYoutubeEmbedUrl($youtube_url) {
    if (empty($youtube_url)) return '';
    
    $video_id = '';
    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    
    if (preg_match($pattern, $youtube_url, $matches)) {
        $video_id = $matches[1];
    }
    
    return "https://www.youtube.com/embed/{$video_id}";
}

function formatInstructions($instructions) {
    if (empty($instructions)) return [];
    
    // Split by line breaks or periods followed by a space
    $steps = preg_split('/\r\n|\n|\r|(?<=\.)\s+/', $instructions, -1, PREG_SPLIT_NO_EMPTY);
    
    // Clean up the steps
    $steps = array_map('trim', $steps);
    $steps = array_filter($steps, function($step) {
        return !empty($step) && $step !== '.';
    });
    
    return array_values($steps);
}

function generatePastelColor() {
    $colors = [
        '#FFD6A5', // Peach
        '#CAFFBF', // Light green
        '#9BF6FF', // Light blue
        '#BDB2FF', // Lavender
        '#FFC6FF', // Pink
        '#FDFFB6', // Light yellow
        '#A0C4FF', // Sky blue
        '#FFB5A7'  // Salmon
    ];
    
    return $colors[array_rand($colors)];
}

function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

function getPageTitle($page, $extra_info = '') {
    $base_title = 'Recipe Generator';
    
    switch ($page) {
        case 'recipe':
            return $extra_info . ' - ' . $base_title;
        case 'category':
            return $extra_info . ' Recipes - ' . $base_title;
        case 'area':
            return $extra_info . ' Cuisine - ' . $base_title;
        case 'search':
            return 'Search Results - ' . $base_title;
        case 'random':
            return 'Random Recipe - ' . $base_title;
        case 'favorites':
            return 'My Favorite Recipes - ' . $base_title;
        default:
            return $base_title . ' - Find Delicious Recipes';
    }
}