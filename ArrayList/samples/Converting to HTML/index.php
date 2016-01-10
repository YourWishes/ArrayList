<?php
/*
 * Sample of how a simple function can convert an ArrayList to a HTML Table
 */

//Import ArrayList lib
require('ArrayList.php');
    
/**
 * Turns any supplied ArrayList or array into a HTML5 valid table. A few 
 * things to note on this function, first is that this function is dependant
 * on the second argument to supply the Table Matrix.
 * 
 * How does the Table Matrix work? Since the array needs some list of 
 * information to pull out of the items that are in the array.
 * 
 * So for example if your array looks like this:
 *      $arr = [
 *          {name: "My Name", date: "My Date", password: "Some Secret"},
 *          {name: "Start Name", date: "Some Date", password: "My Secret"},
 *          {name: "Some Name", date: "End Date", password: "Secret"}
 *      ];
 * 
 * Then most likely your table Matrix would be something like this:
 *      $matrix = [
 *          {name: "Name", method: "getName"},
 *          {date: "Date", method: "getDate"}
 *      ];
 * 
 * Why use this? Well two reasons, most obvious to help formatting, the 
 * other is to stop unwanted data being leaked into the table (In this case
 * the object $passsword)
 * 
 * @param ArrayList|array $table_data
 * @param ArrayList|array $table_matrix
 * @param ArrayList|array $classes
 * @param string $id
 * @param int $maxlength
 */
function generateTable($table_data, $table_matrix, $classes=null, $id=null, $maxlength=-1) {
    //Validate
    if(!is_array($table_data) && !($table_data instanceof ArrayList)) throw new Exception('Table Data must be an Array/ArrayList');
    if(!is_array($table_matrix) && !($table_matrix instanceof ArrayList)) throw new Exception('Table Matrix is invalid.');

    //Translate
    if(is_array($table_data)) $table_data = new ArrayList($table_data);
    if(is_array($table_matrix)) $table_matrix = new ArrayList($table_matrix);

    //Coordinate
    $x = '<table';
    if($classes !== null) {
        if(is_string($classes)) {
            $x .= ' class="' . $classes . '"';
        } else if(is_array($classes) || $classes instanceof ArrayList) {
            if(is_array($classes)) $classes = new ArrayList($classes);
            $x .= ' class="' . $classes->implode(' ') . '"';
        }
    }

    if($id !== null && is_string($id)) {
        $x .= ' id="' . $id . '"';
    }
    $x .= '>';

    //Now we can form our table header
    $x .= '<thead><tr>';
    foreach($table_matrix as $thead) {
        if(!is_array($thead) && !($thead instanceof ArrayList)) throw new Exception('Malformed table matrix.');
        if(is_array($thead)) $thead = new ArrayList($thead);

        if(!$thead->isKeySet('name')) throw new Exception('Malformed table matrix. (Need col name)');
        if(!$thead->isKeySet('method')) throw new Exception('Malformed table matrix. (Need col method)');

        $x .= '<th>' . $thead["name"] . '</th>';
    }
    $x .= '</tr></thead>';

    //Now the table data.
    $x .= '<tbody>';
    for($i = 0; $i < $table_data->size(); $i++) {
        $obj = $table_data[$i];

        //Now iterate over the matrix
        $x .= '<tr>';
        foreach($table_matrix as $thead) {
            $args = array();
            if(is_array($thead)) $thead = new ArrayList($thead);
            if($thead->isKeySet("args")) $args = $def["args"];

            $method = $thead["method"];
            $result;//Definition
            if(is_array($method) || $method instanceof ArrayList) {
                if(is_array($method)) $method = new ArrayList($method);
                /*
                 * If $method is an array then the expected result from a
                 * call_user_func_array on $array[0] is another object.
                 * 
                 * Basically we're going to run through until we reach 
                 * $method->size() on each returned object.
                 * 
                 * e.g. if I have the following:
                 * {
                 *      getChild() {
                 *          return {getName() {"Simon"}};
                 *      }
                 * }
                 * 
                 * I would have the following $method:
                 * ["getChild", "getName"]
                 * 
                 * To overcomplicate again, if I had:
                 *  {
                 *      getChild() {
                 *          return {
                 *              getButt() {
                 *                  return {getName() { "Simon"}};
                 *              }
                 *          };
                 *      }
                 *  }
                 * 
                 * And my $method would be:
                 * ["getChild", "getButt", "getName"]
                 * 
                 * TECHNICALLY speaking you can supply args, I will make
                 * this better in the future but for now I wouldn't.
                 */

                $result = $obj;
                foreach($method as $func) {
                    $result = call_user_func_array(array($result, $func), $args);
                }
            } else {

                $result = call_user_func_array(array($obj, $thead["method"]), $args);

            }
            //HTML Fix up for I.E.
            if($result === null || !isset($result) || $result == '') $result = '&nbsp;';

            $x .= '<td>' . $result . '</td>';
        }
        $x .= '</tr>';

        if($maxlength != -1 && $i >= $maxlength) break;
    }
    $x .= '</tbody>';

    //Finally close up the table.
    $x .= '</table>';
    return $x;
}

//Now we can test our new powers
class ClassGroup {
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function getName() {return $this->name;}
}

class ClassUser {
    private $name;
    private $username;
    private $password;
    private $faveGame;
    private $group;
    
    public function __construct($name, $username, $password, $favouriteGame, &$group) {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->faveGame = $favouriteGame;
        $this->group = $group;
    }
    
    public function getName() {return $this->name;}
    public function getUsername() {return $this->username;}
    public function getFavouriteGame() {return $this->faveGame;}
    public function getGroup() {return $this->group;}
}

//Now Let's create some messing with stuff.
$group_admin = new ClassGroup('Admin');
$group_user = new ClassGroup('User');

$listUsers = new ArrayList('ClassUser');

//Users
$user1 = new ClassUser('Dominic', 'YouWish', 'NotActuallyMyPassword', 'Gurumin', $group_admin);
$listUsers->add($user1);
$user2 = new ClassUser('The', 'RestOfThis', 'CanBeJust', 'Garbage', $group_admin);
$listUsers->add($user2);

//For the sake of testing let's add some fake values
for($i = 0; $i < 50; $i++) {
    $user = new ClassUser(rand(0, 100), rand(0, 10), md5(rand(0, 100)), rand(0, 10), $group_user);
    $listUsers->add($user);
}

//Now, let's make our table matrix
$table_matrix = new ArrayList();
$table_matrix->add(array("name" => "Name", "method" => "getName"));
$table_matrix->add(array("name" => "Username", "method" => "getUsername"));
$table_matrix->add(array("name" => "Favourite Game", "method" => "getFavouriteGame"));
$table_matrix->add(array("name" => "Group", "method" => array("getGroup", "getName")));

//Now generate our HTML
echo generateTable($listUsers, $table_matrix, "some-class");//Yep, that simple.