<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="frontend/css/style.css">
  </head>

  <?php
  include_once 'backend/config/Database.php';
  include_once 'backend/classes/Currency.php';

  $data = new Currency();
  $currencies = $data->getCurrencies();
  ?>

  <body>
    <form action="#" method="post" id="purchase">
      <b>Please choose how much money you want to convert</b><br>
      <input type="number" id="amount" name="amount"><br>
      <b>Please choose what currency you want to purchase</b>
      <select class="select" onchange="getOption()" name="currency" id="currency">
        <option>Currency</option>
        <?php foreach ($currencies as $value) : ?>
          <option value="<?php echo $value['id'] ?>" data-rate="<?php echo $value['exchange_rate'] ?>"><?php echo $value['code'] ?></option>
        <?php endforeach; ?>
      </select>
      <br>
      <b>You will get <span class="converted_amount"></span> <span class="currency_chosen"></span> </b>
      <input type="submit" value="Purchase"></input>
    </form>

  </body>
  <script type="text/javascript" src="frontend/js/jquery-3.6.3.min.js"></script>
  <script type="text/javascript" src="frontend/js/currency_exchange.js"></script>

</html>