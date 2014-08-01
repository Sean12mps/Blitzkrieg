<?php
/**
 * blitzkrieg
 *
 * blitzkrieg Theme by Calibrefx Team
 *
 * @package     blitzkrieg
 * @author      Calibrefx Team
 * @link        http://www.calibrefx.com/
 * @since       Version 1.2
 * @filesource 
 *
 * @package blitzkrieg
 */

add_action('calibrefx_do_ajax', 'childfx_ajax_handler');
function childfx_ajax_handler() {
	global $calibrefx;

	if(empty($_REQUEST['do'])) return;

	$do = $_REQUEST['do'];
	
	switch($do){

        case 'access_post':
            

            $data = $_POST['data'];

            $the_slug = $data['value'];

            $args=array(
                'name' => $the_slug,
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 1
            );
            $my_posts = get_posts( $args );
            if( $my_posts ) {

                // echo 'slug on the first post found ' . $my_posts[0]->post_name;
                $postID= $my_posts[0]->ID;
                $dataX = get_post_data($postID);
                // echo $dataX->post_title;
                // echo $dataX->post_content;
                $response = array(
                    "html" => '',
                    "title" => "$dataX->post_title",
                    "content" => $dataX->post_content,
                    "state" => "success",
                );
            }

            

        break;

		// case 'update-reseller-account': 
		// 	global $current_user;
  //     		get_currentuserinfo();

  //     		$data = $_POST['data'];

  //     		switch ($data['key']) {
  //     			case 'display_name':
  //     			case 'user_email':
  //     				# code...
  //     				wp_update_user( array( 'ID' => $current_user->ID, $data['key'] => $data['value'] ) );
  //     				break;
      			
  //     			default:
		// 			    update_user_meta($current_user->ID, $data['key'], $data['value']);
  //     				# code...
  //     				break;
  //     		}


		// 	$response = array(
		// 		"html" => '',
  //       		"message" => "",
	 //            "state" => "success",
	 //        );
		// break;

		// case 'update-admin-account': 
		// 	global $current_user;
  //     		get_currentuserinfo();

  //     		$data = $_POST['data'];

  //     		switch ($data['key']) {
  //     			case 'display_name':
  //     			case 'user_email':
  //     				# code...
  //     				wp_update_user( array( 'ID' => $current_user->ID, $data['key'] => $data['value'] ) );
  //     				break;
      			
  //     			default:
		// 			update_user_meta($current_user->ID, $data['key'], $data['value']);
  //     				# code...
  //     				break;
  //     		}


		// 	$response = array(
		// 		"html" => '',
  //       		"message" => "",
	 //            "state" => "success",
	 //        );
		// break;

		// case 'update-superadmin-account': 
		// 	global $current_user;
  //     		get_currentuserinfo();

  //     		$data = $_POST['data'];

  //     		switch ($data['key']) {
  //     			case 'display_name':
  //     			case 'user_email':
  //     				# code...
  //     				wp_update_user( array( 'ID' => $current_user->ID, $data['key'] => $data['value'] ) );
  //     				break;
      			
  //     			default:
		// 			update_user_meta($current_user->ID, $data['key'], $data['value']);
  //     				# code...
  //     				break;
  //     		}

		// 	$response = array(
		// 		"html" => '',
  //       		"message" => "",
	 //            "state" => "success",
	 //        );
		// break;

  //       case 'update-website-account': 
  //           global $current_user;
  //           get_currentuserinfo();

  //           $data = $_POST['data'];

  //           switch ($data['key']) {
  //               case 'display_name':
  //               case 'user_email':
  //                   # code...
  //                   wp_update_user( array( 'ID' => $current_user->ID, $data['key'] => $data['value'] ) );
  //                   break;
                
  //               default:
  //                   update_user_meta($current_user->ID, $data['key'], $data['value']);
  //                   # code...
  //                   break;
  //           }


  //           $response = array(
  //               "html" => '',
  //               "message" => "",
  //               "state" => "success",
  //           );
  //       break;


  //       case 'getcity': 
  //           global $current_user;
  //           get_currentuserinfo();

  //           $post_data = $_POST['data'];

  //           $name = sanitize_text_field( $post_data['kota'] );

  //           $result = CFX_Shipping::get_shipping_city( $name );
  //           $cities = array();

  //           foreach ($result as $city) {
  //               $cities[] = $city['district'];
  //           }

  //           $response = array(
  //               "html" => '',
  //               "message" => "",
  //               "data" => $cities,
  //               "state" => "success",
  //           );
  //       break;

  //       case 'getprice': 
  //           global $current_user;
  //           get_currentuserinfo();

  //           $post_data = $_POST['data'];

  //           $name = sanitize_text_field( $post_data['kota'] );

  //           $result = CFX_Shipping::get_shipping_cost( $name, "jne" );
            
  //           $response = array(
  //               "html" => '',
  //               "message" => "",
  //               "data" => $result,
  //               "state" => "success",
  //           );

  //       break;

       /* case 'approvedeposit':
            global $current_user;
            get_currentuserinfo();

            $order_id = absint( $_POST['trans_id'] );

            

            $response = array(
                "html" => '',
                "message" => "",
                "data" => $post_data,
                "state" => "success",
            );
        break;*/
	}
    

	echo json_encode($response);
	exit;
}