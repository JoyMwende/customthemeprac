<?php

/**
 * @package Cohort13Plugin
 */

namespace Inc\Pages;

class ShortCode{
    public function register(){
        add_shortcode('cohort13', [$this, 'ContactusForm']);
    }

    public function ContactusForm($atts){
        $defaults = [
            'title' => 'Edit this to fit your Title Name',
            'company_name'=> 'Enter Company Name Here'
        ];

        $atts = shortcode_atts(
            $defaults, $atts, 'cohort13'
        );

        $html = '';
        $html .= '<div class="d-flex flex-column align-items-center">';
        $html .= '<form>';
        $html .= '<h2>'.$atts['title'].'</h2>';
        $html .= '<h3>'.$atts['company_name'].'</h3>';
        $html .= '<input type="text" class="form-control w-75" name="firstname" placeholder="Input your first name here">';
        $html .= '<input type="text" class="form-control w-75" name="lastname" placeholder="Input your last name here">';
        $html .= '<input type="email" class="form-control w-75" name="email" placeholder="Input your email here">';
        $html .= '<input type="number" class="form-control w-75" name="phone_number" placeholder="Input your phone number here">';
        $html .= '<input type="text" class="form-control w-75" name="subject" placeholder="Input the subject here">';
        $html .= '<textarea cols="43" rows="3" placeholder="Enter your message"></textarea>';
        $html .= '<br/>';
        $html .= '<input type="submit" class="btn btn-primary w-75" value="Submit Request">';
        $html .= '</form>';
        $html .= '</div>';
        

        return $html;
    }
}