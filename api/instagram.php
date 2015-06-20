<?php

class InstagramApi {

    private $data = array (
        "response"   => null,
        "next_page"  => null,
        "photos"     => array()
    );
    private $request = "https://api.instagram.com/v1/users/26970451/media/recent/?client_id=";
    private $params = array ( "key" => null );

    public function __construct( $key ) {
        $this->params["key"] = $key;
        $this->api_request();
    }
    private function api_request( $request = null ) {

        if ( is_null( $request ) ) {
            $request = $this->request;
            $request .= $this->params["key"];
        }

        $body = wp_remote_retrieve_body( wp_remote_get( $request, array(
                    "timeout" => 18,
                    "content-type" => "application/json"
                )
            )
        );

        try {
            $response = json_decode( $body, true );
            $this->data["response"] = $response["data"];
            $this->data["next_page"] = $response["pagination"]["next_url"];

            $this->setup_data( $this->data );

            while ( count( $this->data["photos"] ) < 160 ) {
                $this-> api_request( $this->data["next_page"] );
            }

        } catch ( Exception $ex ) {
            $this->data = null;
        }
    }
    private function setup_data( $data ) {

        foreach ( $data["response"] as $obj ) {

            $images = $obj["images"];

            $new_obj = array(
                "id"            => $obj["id"],
                "type"          => $obj["type"],
                "large_img"     => $images["standard_resolution"]["url"],
                "small_img"     => $images["low_resolution"]["url"],
                "thumb_img"     => $images["thumbnail"]["url"]
            );

            if ( $obj["type"] === "video" ) {
                $videos = $obj["videos"];
                $new_obj["large_mp4"] = $videos["standard_resolution"]["url"];
                $new_obj["small_mp4"] = $videos["low_resolution"]["url"];
            }
            array_push( $this->data["photos"], $new_obj );
        }
    }
    public function query_photos() {
        $output = json_encode( $this->data["photos"] );
        return $output;
    }
    public function pagination_query() {

        $this->data["photos"] = array();
        $this->api_request( $this->data["next_page"] );
        $output = json_encode( $this->data["photos"] );

        return $output;
    }
} ?>
