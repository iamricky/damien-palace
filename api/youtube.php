<?php

class YouTubeApi {

    private $request = "https://www.googleapis.com/youtube/v3/playlistItems";
    private $params = array(
        "key"           => null,
        "maxResults"    => 30,
        "part"          => "snippet",
        "playlistId"    => array (
            "featured"    => "PLx01nh2XnVSV1r7ogt5KLEoY8l9-cwJO6",
            "official"    => "PLx01nh2XnVSX1L2gZV4Xe_41ceA9ZTBY4",
            "munzmind"    => "PLx01nh2XnVSWwq4mvO7IoegXKote5dA1L"
        )
    );
    private $data = array (
        "response" => array (
            "featured"    => array(),
            "official"    => array(),
            "munzmind"    => array()
        ),
        "videos" => array (
            "featured"    => array(),
            "official"    => array(),
            "munzmind"    => array()
        )
    );
    public function __construct( $key ) {
        $this->params["key"] = $key;
        $this->api_request();
    }
    private function compile_request() {
        $endpoint = $this->request;
        $params = $this->params;
        $output;

        reset( $params );
        $first = key( $params );

        foreach ( $params as $key => $val ) {
            if ( $key === "playlistId" ) {
                foreach ( $params[$key] as $key => $val ) {
                    $value = $endpoint . "&playlistId=${val}";
                    $output[$key] = $value;
                }
                break;
            }
            $prefix = $key === $first ? "?" : "&";
            $endpoint .= "${prefix}${key}=${val}";
        }
        return $output;
    }
    private function api_request() {

        $resources = $this->compile_request();

        foreach ( $resources as $key => $request ) {

            $res  = wp_remote_get( $request, array( "timeout" => 10 ) );
            $body = wp_remote_retrieve_body( $res );

            try {
                $response = json_decode( $body, true );
                $this->data["response"][$key] = $response["items"];

                $this->setup_data( $this->data, $key );

            } catch ( Exception $ex ) {
                $this->data["response"][$key] = null;
            }

        }
    }
    private function setup_data( $data, $key ) {

        foreach ( $data["response"][$key] as $obj ) {

            $resObj     = $obj["snippet"];
            $images     = $resObj["thumbnails"];
            $videoId    = $resObj["resourceId"]["videoId"];

            $new_obj = array(
                "id"            => $videoId,
                "default_img"   => $images["default"]["url"],
                "medium_img"    => $images["medium"]["url"],
                "high_img"      => $images["high"]["url"]
            );
            if ( isset( $images["standard"] ) ) {
                $new_obj["standard_img"] = $images["standard"]["url"];
            }
            array_push( $this->data["videos"][$key], $new_obj );
        }
    }
    public function query_videos() {
        $output = json_encode( $this->data["videos"] );
        return $output;
    }
} ?>
