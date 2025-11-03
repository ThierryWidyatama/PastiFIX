<?php

use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;


function getOption($option)
{
    $table = $option['table'];
    $value_option = $option['value'];
    $label = $option['label'];
    $data = DB::table($table);
    if (isset($option['where'])) {
        $data = $data->where($option['where']);
    }
    $data = $data->get();
    $result = [];
    foreach ($data as $key => $value) {
        $result[$value->$value_option] = $value->$label;
    }
    return $result;
}

function insert_log($activity,$ref_id = null,$json = null)
{
    DB::table('logs')->insert([
        'user_id' => auth()->user()->id ?? null,
        'session_id' => session()->getId() ?? null,
        'ip' => request()->ip(),
        'browser' => getBrowser().getDeviceInfo(),
        'activity' => $activity,
        'ref_id' => $ref_id ?? null,
        'json' => $json ?? null,
        'created_at' => now()
    ]);
}
function getBrowser()
{
    // Create an instance of the Agent class
    $agent = new Agent();

    // Get the user's browser
    $browser = $agent->browser();

    // Get the user's browser version
    $version = $agent->version($browser);

    return "Browser: $browser, Version: $version";
}

function getDeviceInfo()
{
    // Create an instance of the Agent class
    $agent = new Agent();

    // Get the user's device
    $device = $agent->device();

    // Get the user's platform
    $platform = $agent->platform();

    // Get the user's browser
    $browser = $agent->browser();

    // Get the user's browser version
    $version = $agent->version($browser);

    return " Device: $device, Platform: $platform, Browser: $browser, Version: $version";
}

function setAction($label,$icon,$url,$color = "btn-primary",$onclick = null)
{
    return  '<button type="button" onclick="location.href=' . "'" .$url. "'" . ';" class="btn btn-icon '.$color.' btn-sm" title="'.$label.'">
    '.$icon.'</button>';
}
