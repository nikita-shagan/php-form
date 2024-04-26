<?php

session_start();

include 'functions.php';
include 'amo-crm-client.php';


if(!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = get_new_token();
}

try {
    $leads = AmoCrmClient::getLeads();
    $requests_count = count($leads);
} catch(\Exception $e) {
    $requests_count = 1033;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'error') : 
            $errors = $_SESSION['errors'];
        ?>
            <ul class="errors">
                <?php foreach($errors as $e) : ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        <?php elseif(isset($_SESSION['status']) && $_SESSION['status'] === 'success') :?>
            <div class="success">
                <p>Заявка успешно отправленна!</p>
            </div>
        <?php endif; ?>
        <button class="main-button">
            Кликни
        </button>
        <div class="popup">
            <div class="popup__container">
                <img class="popup__close" src="../images/cross.svg"/>
                <div class='promo'>
                    <h2 class="promo__title">
                        <span>
                            Дарим скидку 200 рублей 
                        </span>
                        на&nbsp;первый&nbsp;визит до 7 апреля
                    </h2>
                    <div class="promo__body">
                        <div>
                            <div class="promo__more">
                                <p class="promo__more-heading">
                                    А также:
                                </p>
                                <ul class="promo__more-list">
                                    <li class="promo__more-list-item">
                                        <span>
                                            участие в розыгрыше SPA для двоих;
                                        </span>
                                    </li>
                                    <li class="promo__more-list-item">
                                        программу лояльности с экономией до 10%;
                                    </li>
                                    <li class="promo__more-list-item">
                                        беспроигрышную лотерею в студии с бесплатными процедурами.
                                    </li>
                                </ul>
                            </div>
                            <form class="promo__form" action="handle-form.php" method="post">
                                <label for="number" class="promo__form-label">Введи телефон для получения подарка:</label>
                                <input
                                    class="promo__form-input"
                                    type="text"
                                    name="number"
                                    id="number"
                                    placeholder="+7 (000) 000-00-00"
                                    pattern="^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$"
                                    required
                                >
                                <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                                <button class="promo__form-button" type="submit">Получить купон на скидку</button>
                                <div class="promo__form-agreement">
                                    <div class="promo__form-agreement-checkbox-wrapper">
                                        <input
                                            type="checkbox"
                                            name="agreement"
                                            class="promo__form-agreement-checkbox"
                                            id="checkbox"
                                            required
                                        >
                                        <label for="checkbox">Я даю согласие на обработку</label>
                                        <a href="/" class="promo__form-agreement-link">
                                            персональных данных
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            <img class="promo__card" src="../images/card.png" alt="card">
                            <div class="promo__got">
                                <img src="../images/people.svg" alt="icon" class="promo__got-img">
                                <p class="promo__got-text">
                                    Уже получили <span><?php echo $requests_count ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts.js"></script> 
</body>
</html>

<?php

unset($_SESSION['status']);
unset($_SESSION['errors']);
