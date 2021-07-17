<?php

namespace ext;

class CoreClass
{
    /**
     * @var array
     */
    protected $white = ["import" => 1, "new" => 1];

    /**
     * Check get
     * 
     * @return
     */
    public function getGet()
    {
        if( isset( $_GET["edit"] ) )
        {
            if( isset( $this->white[ htmlentities( $_GET["edit"] ) ] ) )
                return $_GET["edit"];
        }
        return null;
    }
}