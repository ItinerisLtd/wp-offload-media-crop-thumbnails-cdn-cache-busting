<?php
declare(strict_types=1);

/**
 * Plugin Name:     WP Offload Media Crop Thumbnails CDN Cache Busting
 * Plugin URI:      https://github.com/itinerisltd/wp-offload-media-crop-thumbnails-cdn-cache-busting
 * Description:     Bust WP Offload Media CDN caches when thumbnails are cropped
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     wp-offload-media-crop-thumbnails-cdn-cache-busting
 */

namespace Itineris\WPOffloadMediaCropThumbnailsCDNCacheBusting;

use Amazon_S3_And_CloudFront_Pro;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_filter('crop_thumbnails_before_update_metadata', function (array $metadata, int $attachmentId): array {
    $as3cfpro = $GLOBALS['$as3cfpro'];

    $as3cfpro instanceof Amazon_S3_And_CloudFront_Pro
        && true === $as3cfpro->download_attachment_from_provider($attachmentId)
        && $as3cfpro->delete_attachment($attachmentId);

    return $metadata;
}, 10, 2);
