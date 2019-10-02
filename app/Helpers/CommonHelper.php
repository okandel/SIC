<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\ItemTemplate; 
use App\Country; 
use Illuminate\Pagination\LengthAwarePaginator; 
use DB;
use Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Snowfire\Beautymail\Beautymail;
use DateTime;
use Config;
use Swap;
use Carbon\Carbon;
use App\Helpers\Polyline;
use Validator;
use Illuminate\Support\Facades\Cache;
use libphonenumber\PhoneNumberFormat;

class CommonHelper
{

    public static function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125); // "}"
            return trim($uuid, '{}');;
        }
    }

    public static function arrayToString($request_filter)
    {
        $filters = "";
        if ($request_filter) {
            $filters = implode("][", $request_filter);
            $filters = '[' . $filters . ']';
        }
        return $filters;
    }

    // $convert_mention = CommonHelper::mathMentions("@Sitepoint1 is the best forum @Site_point2");
    // return $convert_mention; 
    public static function mathMentions($str)
    {
        $regex = "/@+([a-zA-Z0-9_]+)/";
        $matches = [];
        preg_match_all($regex, $str, $matches);

        //$str = preg_replace($regex, '($0,$1)', $str);
        //$str = preg_replace($regex, '<a href="profile?username=$1">$0</a>', $str);
        return $matches[1];
    }

    public static function customPagination($data)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);
        // Define how many items we want to be visible in each page
        $perPage = 10;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator(collect($currentPageItems)->values(), count($itemCollection), $perPage);
        // set url path for generted links
        return $paginatedItems;
    }

    public static function customPaginationByTotal($data, $perPage, $total)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);
        // Define how many items we want to be visible in each page

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator(collect($currentPageItems)->values(), $total, $perPage);
        // set url path for generted links
        $paginatedItems->setPath(\Request::url());
        $paginatedItems = $paginatedItems->toArray();

        $paginatedItems["data"] = $data;

        $from = (($currentPage - 1) * $perPage);

        $paginatedItems["from"] = $from + 1;
        $paginatedItems["to"] = ($total > $from + $perPage) ? $from + $perPage : $total;
        return $paginatedItems;
    }

    public static function customPagination_datatable($query)
    {

        $request = app(\Illuminate\Http\Request::class);
        $length = $request->length ?: 10;
        $page = ($request->start / $length) + 1 ?: 1; /* Actual page */
        $limit = $length; /* Limit per page */

        $paged = $query->paginate($limit, ['*1'], 'page', $page);
        $total = $paged->total();

        $output = array(
            "draw" => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => collect($paged)['data'],
            "input" => []
        );
        return $output;
    }

    public static function indexingCollection($collect, $startIndex = 0)
    {
        $collect = collect($collect)->toArray();
        $count = count($collect);
        for ($i = 1; $i <= $count; $i++) {
            $collect[$i - 1]["sort"] = $i + $startIndex;
        }
        return collect($collect);
    }

    public static function getPayLoadJson($template_id, $payload)
    {
        $itemTemplate = ItemTemplate::with("customFields")->find($template_id);
        $item_payload = json_decode($payload, true);

        $res = array();
        if ($itemTemplate != null) {
            foreach ($itemTemplate->customFields as $customFields) {
                $value = $item_payload["field_" . $customFields->id] ?? $customFields->default_value;
                $res[] = [
                    "name" => $customFields->display_name,
                    "value" => $value
                ];
            }
        }
        return $res;
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function GetDayOfWeekString($day)
    {
        $days = [
            'Saturday',
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday'];
        return $days[$day];
    }
}