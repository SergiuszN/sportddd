<?php

return [
    'index_homepage' => ['/', \Ddd\Sportyvis\Application\IndexController::class, 'homepage'],
    'index_posts' => ['/posts', \Ddd\Sportyvis\Application\IndexController::class, 'posts'],
    'index_post' => ['/post', \Ddd\Sportyvis\Application\IndexController::class, 'post'],
    'index_post_comments' => ['/post/comments', \Ddd\Sportyvis\Application\IndexController::class, 'postComments'],
];