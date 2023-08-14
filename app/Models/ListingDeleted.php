<?php

namespace App\Models;

class Listing {

    public static function all() {

        return [
            [
                'id' => 1,
                'title' => 'Listing one',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum nisl dictum euismod dignissim. Vivamus ultrices lectus sit amet tristique lacinia. Vestibulum a interdum quam. Sed dignissim magna ipsum, id gravida magna venenatis eu. Donec ut justo porta turpis congue blandit. In ac odio sit amet libero sollicitudin dignissim. Vivamus laoreet rutrum mattis.'
            ],
            [
                'id' => 2,
                'title' => 'Listing two',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum nisl dictum euismod dignissim. Vivamus ultrices lectus sit amet tristique lacinia. Vestibulum a interdum quam. Sed dignissim magna ipsum, id gravida magna venenatis eu. Donec ut justo porta turpis congue blandit. In ac odio sit amet libero sollicitudin dignissim. Vivamus laoreet rutrum mattis.'
            ]
        ];
    }

    public static function find($id) {

        $listings = self::all();

        foreach($listings as $listing) {

            if($listing['id'] == $id) {

                return $listing;
            }
        }

    }

}