<?php

use Illuminate\Support\Facades\Schedule;

$categories = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];
$delays = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
    21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

foreach ($categories as $category) {
    Schedule::command("fetch:news1 {$category}")
        ->hourlyAt($delays[array_search($category, $categories)])
        ->withoutOverlapping(60);

    Schedule::command("fetch:news2 {$category}")
        ->hourlyAt($delays[array_search($category, $categories)])
        ->withoutOverlapping(60);
}

$nyCategories = [
    'arts', 'automobiles', 'business', 'fashion', 'food', 'health', 'home',
    'insider', 'magazine', 'movies', 'nyregion', 'obituaries', 'opinion', 'politics',
    'realestate', 'science', 'sports', 'sundayreview', 'technology', 'theater',
    't-magazine', 'travel', 'upshot', 'us', 'world',
];

foreach ($nyCategories as $category) {
    Schedule::command("fetch:news3 {$category}")
    ->hourlyAt($delays[array_search($category, $categories)])
    ->withoutOverlapping(60);
}
