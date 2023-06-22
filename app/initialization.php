<?php
session_start();
require_once 'validations/Validator.php';

require_once 'products/ProductAbstract.php';
require_once 'products/Dvd.php';
require_once 'products/Book.php';
require_once 'products/Furniture.php';
require_once 'products/DataForSave.php';

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';