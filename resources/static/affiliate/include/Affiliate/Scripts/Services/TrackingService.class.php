<?php

class Affiliate_Scripts_Services_TrackingService
{
    protected $urls = null;

    public function __construct( $urls )
    {
        $this->urls = $urls;
    }

    public function renderImageTags()
    {
        $flattenedUrls = array();

        $imageTagBlock = Affiliate_Scripts_Services_TrackingService::generateImageTags( $this->urls, $flattenedUrls );

        echo $imageTagBlock;
    }

    protected static function generateImageTags( $urls )
    {
        $imageTagBlock = "";

        foreach ( $urls as $element )
        {
            if ( is_array( $element ) ) // if it's an array, recurse
            {
                $imageTagBlock .= Affiliate_Scripts_Services_TrackingService::generateImageTags( $element );
            }
            else if ( $element ) // if not an array, it's a url...in theory.
            {
                $cleanedElement = trim( $element ); // trim it just to be on the safe side

                if ( empty($cleanedElement) || $cleanedElement == null ) // if it's empty or null, continue
                    continue;

                $imageTagBlock .= '<img src="'.$cleanedElement."\" border=\"0\" height=\"1\" width=\"1\" />\n";
            }
        }

        return $imageTagBlock;
    }
}

?>
