<?php

define('API_BASE_URL', 'https://www.themealdb.com/api/json/v1/1/');

function callMealDbApi($endpoint) {
    $url = API_BASE_URL . $endpoint;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return ['error' => 'API request failed: ' . curl_error($ch)];
    }

    curl_close($ch);

    $data = json_decode($response, true);

    return $data;
}

function getRandomRecipes($count = 1) {
    $recipes = [];
    for ($i = 0; $i < $count; $i++) {
        $data = callMealDbApi('random.php');
        if (isset($data['meals']) && is_array($data['meals']) && !empty($data['meals'])) {
            $recipes[] = $data['meals'][0];
        }
    }
    return $recipes;
}

function getRecipeById($id) {
    $data = callMealDbApi('lookup.php?i=' . $id);

    if (isset($data['meals']) && is_array($data['meals']) && !empty($data['meals'])) {
        return $data['meals'][0];
    }

    return null;
}

function getCategories() {
    $data = callMealDbApi('categories.php');

    if (isset($data['categories']) && is_array($data['categories'])) {
        return $data['categories'];
    }

    return [];
}

function getRecipesByCategory($category) {
    $data = callMealDbApi('filter.php?c=' . urlencode($category));

    if (isset($data['meals']) && is_array($data['meals'])) {
        return $data['meals'];
    }

    return [];
}

function getAreas() {
    $data = callMealDbApi('list.php?a=list');

    if (isset($data['meals']) && is_array($data['meals'])) {
        return $data['meals'];
    }

    return [];
}

function getRecipesByArea($area) {
    $data = callMealDbApi('filter.php?a=' . urlencode($area));

    if (isset($data['meals']) && is_array($data['meals'])) {
        return $data['meals'];
    }

    return [];
}

function searchRecipes($query) {
    $data = callMealDbApi('search.php?s=' . urlencode($query));

    if (isset($data['meals']) && is_array($data['meals'])) {
        return $data['meals'];
    }

    return [];
}

function getFeaturedRecipes($count = 8) {
    $categories = getCategories();
    $featured = [];

    if (empty($categories)) {
        return getRandomRecipes($count);
    }

    $categories_to_use = array_slice($categories, 0, min(4, count($categories)));

    foreach ($categories_to_use as $category) {
        $recipes = getRecipesByCategory($category['strCategory']);

        if (!empty($recipes)) {
            $random_keys = array_rand($recipes, min(2, count($recipes)));

            if (!is_array($random_keys)) {
                $random_keys = [$random_keys];
            }

            foreach ($random_keys as $key) {
                $featured[] = $recipes[$key];

                if (count($featured) >= $count) {
                    break 2;
                }
            }
        }
    }

    if (count($featured) < $count) {
        $additional = getRandomRecipes($count - count($featured));
        $featured = array_merge($featured, $additional);
    }

    return $featured;
}
