<?php

require_once '../models/Product.php';

$product = new Product($_POST['product_id']);

$product->update($_POST['title'], $_POST['price'], $_POST['category_id'], $_POST['collection_id']);

header('Location: product_list_adm.php?success-change=1&product_id='.$_POST['product_id']);
