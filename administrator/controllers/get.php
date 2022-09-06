<?php
require_once("../core/init.php");
$user = new User();
$faculty = new General('faculties');
$dept = new General('departments');
$world = isset($world) ? $world : new World();
//$board = new General('message_boards');

$result = array();
if (Input::exists() && Input::get('req')) {
  switch (trim(Input::get('req'))) {
    case 'statelist':
      $res = $world->getStatesByCountryId(Input::get('countryid'), true);
      if($res){
        $result['success'] = $res;
      }else{
        $result['error'] = 'Data Not found';
      }
    break;
    case 'getdepts':
      $res = $dept->getAll(Input::get('facultyid'), "faculty_id", '=');
      if($res){
        $out = null;
        foreach($res as $index =>$con){
          $out .= "<option value='{$con->id}'>{$con->title}</option>";
        }
        $result['success'] = $out ? $out : "No Data";
      }else{
        $result['error'] = 'Data Not found';
      }
    break;
    case 'fund-account':
      $item = $user->get(Input::get('b_id'), 'email');

        $result['success'] = "Message sent successfully";
      $result['error'] = 'Error! Data Not Found.';

      break;
    case 'send-friend-chat':

      try {
        $friend_chat->create(array(
          'friend_id' => Input::get('f_id'),
          'user_id' => $user->data()->id,
          'text' => Input::get('msg'),
          'date_added' => date('Y-m-d H:i:s'),
        ));

        $result['success'] = "Message sent successfully";
      } catch (Exception $e) {
        $result['success'] = $e->getMessage();
      }


      break;
  }
}
echo json_encode($result);
