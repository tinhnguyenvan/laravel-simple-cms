<?php
/**
 * @author: nguyentinh
 * @time: 10/29/19 4:05 PM
 */

namespace App\Http\Controllers\Site;

use App\Models\ToolShortLink;

/**
 * Class ToolController.
 *
 */
final class ToolController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function shortLink($shortUrl)
    {
        $object = ToolShortLink::query()->where('short_url', $shortUrl)->first();
        if (!empty($object->id) && !empty($object->url)) {
            $object->increment('views');
            sleep(2);
            return redirect($object->url, 301);
        }

        return view('errors.404');
    }
}
