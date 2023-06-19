<?php

/**
 * @package Cohort13Plugin
 */

namespace Inc\Pages;

class ExternalApi{
    public function register(){
        add_shortcode('users', [$this, 'getApiData']);
    }

    public function getApiData(){
        $url = 'https://jsonplaceholder.typicode.com/users';

        $arguments = [
            'method'=>'GET',
        ];

        $response = wp_remote_get($url, $arguments);

        //display error message
        if(200 == wp_remote_retrieve_response_code($response)){
            $file_link = WP_PLUGIN_DIR. '/cohort13/data.json';

            $message = wp_remote_retrieve_body($response);
        }

        if(is_wp_error($response)){
            $error_message = $response->get_error_message();
            return "Something went wrong: $error_message";
        }

        //doing away with headers - use wp_remote_retrieve_body() function
        $users = (json_decode(wp_remote_retrieve_body($response)));

        echo '<pre>';
        // var_dump($users);
        echo '</pre>';

        // error_log(var_dump($users));


        $html = '';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Name</th>';
        $html .= '<th>User Name</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Address</th>';
        $html .= '</tr>';
        
        foreach($users as $user){
        $html .= '<tr>';
        $html .= '<td>'.$user->id.'</td>';
        $html .= '<td>'.$user->name.'</td>';
        $html .= '<td>'.$user->username.'</td>';
        $html .= '<td>'.$user->email.'</td>';
        $html .= '<td>'.$user->address->street.'</td>';
        $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
    }

    //create file
    function write_to_file($message, $file_link){
        if(file_exists($file_link)){
            $writing = fopen($file_link, 'a');
        }
    }
}