<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostLikeDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, 'id');

if(!empty($id)) {
    $postLikeDao = new PostLikeDaoMysql($pdo);
    $postLikeDao->likeToggle($id, $userInfo->id);
}