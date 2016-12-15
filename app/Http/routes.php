<?php

Route::controller('auth', 'Auth\AuthController');

Route::controller('topic', 'TopicController');

Route::get('topic/view/{topicId}', 'TopicController@getView');

Route::controller('comment', 'CommentController');

Route::get('/comment/view/{commentId}', 'CommentController@getView');

Route::controller('subscriptions', 'SubscriptionsController');

Route::get('/', 'ProfileController@getIndex');

Route::controller('profile', 'ProfileController');

Route::get('/profile/view/{userId}', 'ProfileController@getView');