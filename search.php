<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'search';

$userDao = new UserDaoMysql($pdo);

$searchTerm = filter_input(INPUT_GET, 's');

if(empty($searchTerm)) {
    header("Location: ".$base);
    exit;
}

$userList = $userDao->findByName($searchTerm);

require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">

            <h2>Pesquisa por: <?=$searchTerm;?></h2>

            <div class="full-friend-list">
                <?php foreach($userList as $item):?>
                    <div class="friend-icon">
                        <a href="<?=$base?>/perfil.php?id=<?=$item->id;?>">
                            <div class="friend-icon-avatar">
                                <img src="<?=$base?>/media/avatars/<?=$item->avatar;?>" />
                            </div>
                            <div class="friend-icon-name">
                                <?=$item->name;?>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
            
        </div>

        <div class="column side pl-5">
            <div class="box banners">
                <div class="box-header">
                    <div class="box-header-text">Patrocinios</div>
                    <div class="box-header-buttons">
                        
                    </div>
                </div>
                <div class="box-body">
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                </div>
            </div>
            <div class="box">
                <div class="box-body m-10">
                        Criado com ❤️ por B7Web
                </div>
            </div>
        </div>
    </div>
</section>


<?php
require 'partials/footer.php';
?>