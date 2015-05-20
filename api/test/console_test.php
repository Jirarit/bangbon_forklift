#!/usr/bin/php -q
<?php
@require(dirname(__FILE__).'/inc.front-console/JsonRpcClientV1.php');
@include(dirname(__FILE__).'/../conf/front-console.conf');

$url = defined("API_URL") ? API_URL : "localhost:10320/api/"; 

hr();
echo "URL : {$url}" . PHP_EOL;
hr();

$jr = new JsonRpcClient($url);
$jr->IsDebug=TRUE;
$ssid = 0;
$auto_login = ["root", "password"];
_Login_();

$menus = ['L'=>'_Login_', 'E'=>'_Exit_'];

while (TRUE){

    echo PHP_EOL, 'Press Enter return to menu...'; fgets(STDIN);
    echo color::ClearScreen;

    echo "URL : {$url}" . PHP_EOL;
    echo "SSID : {$ssid}" . PHP_EOL;

    hr();

    echo "MENUs : \t" . PHP_EOL;

    hr();

    $func = get_class_methods('Methods');
    unset($func[0]);
    print_r($func);

    hr();

    foreach($menus as $k=>$v){ echo "[{$k}] {$v} \t"; }

    echo PHP_EOL;

    hr();

    echo 'menu : '; $menu = trim(fgets(STDIN), "\n");

    hr();

    if(array_key_exists(strtoupper($menu), $menus)){
        $menus[strtoupper($menu)]();
    }elseif(array_key_exists($menu, $func)){
        call_user_func("Methods::" . $func[$menu], $jr, $ssid);
    }else{
        echo "Menu '{$menu}' not found";
    }

    echo PHP_EOL;
    hr();
}

echo PHP_EOL;

function hr(){
    echo str_repeat("-", 50). PHP_EOL;
}

function _Login_() {
    global $auto_login, $jr, $ssid;
    $ssid = 0;
    while(TRUE){

        echo 'Authen::login' . PHP_EOL;
        echo 'user : '; if(empty($auto_login)) $login = rtrim(fgets(STDIN),"\n"); else echo ($login = $auto_login[0]) . PHP_EOL;
        echo 'pass : '; if(empty($auto_login)) $pass = rtrim(fgets(STDIN),"\n"); else echo ($pass = $auto_login[1]) . PHP_EOL;

        $result = $jr->call('Authen::login',['login'=>$login,'pass'=>$pass]);

        if($result !== 0){
            $ssid = $result['SSID'];
            break;
        }

        if($result === 0 && !empty($auto_login)){
            break;
        }
    }

    hr();

    if($ssid === 0){
        echo "auto login fail" . PHP_EOL . PHP_EOL;
        exit();
    }
}

function _Exit_() {
    exit();
}

Class Methods{

    static function input($method, $params){

        echo "Method : {$method}" . PHP_EOL;
        echo "Params : [" . PHP_EOL;

        $input = NULL;

        foreach ($params as $key => $value) {
            echo "\t{$key} => "; $input[$key] = trim(fgets(STDIN), "\n");
            $input[$key] = empty($input[$key]) && $value !== NULL ? $value : $input[$key];
            if(strtoupper($input[$key]) === "NULL") unset($input[$key]);
        }

        echo "]" . PHP_EOL;
        return $input;

    }

    static function product_cre_wh_item($jr, $ssid){

        $method = "Product::create_warehouse_item";
        $params = [
            "code" => "",
            "name" => "Warehouse Product",
            "description" => "",
            "subtype" => "S",
            "ctype" => "S",
            "pbrand_id" => "1",
            "model" => "xxxxxx",
            "unit_name" => "unit",
            "pcategory_id" => "1",
            "price" => "10",
            "supplier_id" => "0",
            "order_code" => "",
            "barcode" => "19209092012"
        ];

        $params = Methods::input($method, $params);
        $jr->call($method, $params, $ssid);
    }

    static function product_cre_st_item($jr, $ssid){

        $method = "Product::create_store_item";
        $params = [
            "code" => "",
            "name" => "Store Product",
            "description" => "",
            "subtype" => "P",
            "ctype" => "I",
            "pbrand_id" => "1",
            "model" => "xxxxxx",
            "unit_name" => "unit",
            "pcategory_id" => "1",
            "price" => "10",
            "supplier_id" => "0",
            "order_code" => "",
            "barcode" => "19209092012"
        ];

        $params = Methods::input($method, $params);
        $jr->call($method, $params, $ssid);
    }

    static function product_cre_as_item($jr, $ssid){

        $method = "Product::create_asset_item";
        $params = [

            "code" => "",
            "name" => "Asset Product",

            "description" => "",

            "ctype" => "I",

            "unit_name" => "unit",

            "pcategory_id" => "1",

            "price" => "10",

            "barcode" => "19209092012"

        ];

        

        $params = Methods::input($method, $params);

        

        $jr->call($method, $params, $ssid);

    }

    

    static function product_cre_ex_item($jr, $ssid){

        $method = "Product::create_expense_item";

        $params = [

            "code" => "",

            "name" => "Expense Product",

            "description" => "",

            "pcategory_id" => "1",

            "price" => "10",

            "barcode" => "19209092012"

        ];

        

        $params = Methods::input($method, $params);

        

        $jr->call($method, $params, $ssid);

    }

    

    static function product_cre_re_item($jr, $ssid){

        $method = "Product::create_revenue_item";

        $params = [

            "code" => "",

            "name" => "Revenue Product",

            "description" => "",

            "pcategory_id" => "1",

            "price" => "10",

            "barcode" => "19209092012"

        ];

        

        $params = Methods::input($method, $params);

        

        $jr->call($method, $params, $ssid);

    }

}

?>

