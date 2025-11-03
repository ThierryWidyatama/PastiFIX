<?php

use App\Models\Role;
use Ramsey\Uuid\Uuid;
use App\Models\Module;
use Illuminate\Support\Str;
use App\Models\ModulePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

if (! function_exists('check')) {
    function check($model)
    {
        return $model . " activated";
    }
}

// * Reference Function, function that use for reference
if (! function_exists('reference')) {
    function reference($code, $value = null)
    {
        switch ($code) {
            case 'gender':
                (object) $data = [
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ];
                return ($value == null) ? $data : $data[$value];
                break;
            case 'posisi_pegawai':
                (object) $data = [
                    'SHP' => 'Shopper',
                    'DRV' => 'Driver',
                    'ADM' => 'Admin CS',
                    'DIR' => 'Direktur',
                ];
                return ($value == null) ? $data : $data[$value];
                break;
            case 'status':
                (object) $data = [
                    '0' => 'Tidak Aktif',
                    '1' => 'Aktif',
                ];
                return ($value == null) ? $data : $data[$value];
                break;
            default:
                return "not found";
                break;
        }
    }
}
if (! function_exists('show_image')) {
    function show_image($src = null)
    {
        if (!empty($src)) {
            if (file_exists(public_path($src))) {
                return asset($src);
            } else {
                return asset('static/not_found.png');
            }
        } else {
            return asset('static/not_found.png');
        }
    }
}

if (! function_exists('isAccess')) {
    function isAccess($act, $module, $user)
    {
        $action = ModulePermission::where('role_id', Auth::user()->role_id)->where('module_id', $module)->first();
        //tidak memiliki akses
        if ($action == NULL) {
            return FALSE;
        }
        if (strpos($action->action, $act) !== false) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (! function_exists('isPermission')) {
    function isPermission($route_module, $user)
    {
        $module_id = Module::where('link', $route_module)->first();
        if ($module_id && ModulePermission::where('role_id', Auth::user()->role_id)->where('module_id', $module_id->id)->exists()) {
            return TRUE;
        }
        return FALSE;
    }
}

if (! function_exists('get_module_id')) {
    function get_module_id($module)
    {
        $moduleData = Module::where('link', $module)->first();
        // $action = $role->where('usergroup_gmd',$user)->where('module_gmd',$module)->where('publish','1')->first();
        return $moduleData->id;
    }
}

if (! function_exists('isSelected')) {
    function isSelected($a, $b)
    {
        if ($a == $b) {
            echo "selected";
        }
    }
}

if (! function_exists('rupiah_format')) {
    function rupiah_format($nominal)
    {
        return number_format($nominal, 0, 0, ".");
    }
}

if (! function_exists('number_wa')) {
    function number_wa($number)
    {
        if ($number == "") {
            return "";
        }
        $code = substr($number, 0, 1);
        if ($code == "0") {
            // echo $code;
            $phone = "62" . substr($number, 1);
        } elseif ($code == "62") {
            // echo $code;
            $phone = $number;
        } elseif ($code == "+62") {
            // echo $code;
            $phone = substr($number, 1);
        } else {
            $phone = $number;
        }
        return $phone;
    }
}

function xprint_r($print)
{
    echo "<pre>";
    print_r($print);
    echo "</pre>";
}

if (! function_exists('whatNumber')) {
    function whatNumber($number)
    {
        $number = strtolower($number);
        $words = array(
            'a' => "1",
            'b' => "2",
            'c' => "3",
            'd' => "4",
            'e' => "5",
            'f' => "6",
            'g' => "7",
            'h' => "8",
            'i' => "9",
            'j' => "10",
            'k' => "11",
            'l' => "12",
            'm' => "13",
            'n' => "14",
            'o' => "15",
            'p' => "16",
            'r' => "17",
            's' => "18",
            't' => "19",
            'u' => "20",
            'v' => "21",
            'w' => "22",
            'x' => "23",
            'y' => "24",
            'z' => "25",

        );
        return $words[$number];
    }
}

function method1($a, $b)
{
    return ($a['item'][0]["group_transaction"] <= $b['item'][0]["group_transaction"]) ? -1 : 1;
}

if (! function_exists('smt_reference')) {
    function smt_reference($code, $value = null)
    {
        switch ($code) {
            case 'status_supplier':
                $data = array(
                    '0' => 'Belanja Langsung',
                    '1' => 'Whatsapp'
                );
                if ($value != NULL) {
                    return $data[$value];
                } else {
                    return $data;
                }
                break;
            case 'supplier_position':
                $data = array(
                    'B' => 'Belakang',
                    'D' => 'Depan',
                    'T' => 'Tengah',
                    'L' => 'Luar'
                );
                if ($value != NULL) {
                    return $data[$value];
                } else {
                    return $data;
                }
                break;

            case 'status_transaction':
                $data = array(
                    '0' => 'Menunggu Belanja',
                    '1' => 'Selesai Belanja',
                    '2' => 'Selesai'
                );
                if ($value != NULL) {
                    return $data[$value];
                } else {
                    return $data;
                }
                break;
            case 'status_faq':
                $data = array(
                    '0' => 'Tidak Aktif',
                    '1' => 'Aktif'
                );
                if ($value != NULL) {
                    return $data[$value];
                } else {
                    return $data;
                }
                break;

            default:
                # code...
                break;
        }
    }
}
if (! function_exists('IsSelected')) {
    function IsSelected($param_one, $param_two)
    {
        return ($param_one == $param_two) ? "SELECTED" : null;
    }
}
if (! function_exists('fdate')) {
    function fdate($value, $format)
    {
        $date = explode("-", $value);

        $tgl = $date[2];
        $bln = $date[1];
        $thn = $date[0];

        $return = "";
        switch ($format) {
            case "DDMMYYYY":
                $return = $tgl . " " . fbulan($bln) . " " . $thn;
                break;
            case "DD":
                $return = $tgl;
                break;
            case "MM":
                $return = $bln;
                break;
            case "YYYYY":
                $return = $thn;
                break;
            case "MMYYYY":
                $return = fbulan($bln) . " " . $thn;
                break;
            case "mm":
                $return = fbulan($bln);
                break;
            case "HHDDMMYYYY":
                $eks = explode(" ", $tgl);
                $tgl = $eks[0];
                $jam = $eks[1];
                list($H, $M, $S) = explode(":", $jam);
                $return = $tgl . " " . fbulan($bln) . " " . $thn . " | " . $H . ":" . $M . ":" . $S;
                break;
        }
        return $return;
    }
}
if (!function_exists('hp')) {
    function hp($nohp)
    {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            }
        }
        return $hp;
    }
}

if (! function_exists('fbulan')) {
    function fbulan($bulan)
    {
        $bulan = (int) $bulan;
        if ($bulan == "7") {
            $bln = "Juli";
        } else if ($bulan == "8") {
            $bln = "Agustus";
        } else if ($bulan == "9") {
            $bln = "September";
        } else if ($bulan == "10") {
            $bln = "Oktober";
        } else if ($bulan == "11") {
            $bln = "November";
        } else if ($bulan == "12") {
            $bln = "Desember";
        } else if ($bulan == "1") {
            $bln = "Januari";
        } else if ($bulan == "2") {
            $bln = "Februari";
        } else if ($bulan == "3") {
            $bln = "Maret";
        } else if ($bulan == "4") {
            $bln = "April";
        } else if ($bulan == "5") {
            $bln = "Mei";
        } else if ($bulan == "6") {
            $bln = "Juni";
        } else {
            $bln = "Gaji " . $bulan;
        }
        return $bln;
    }
}

if (! function_exists('create_link')) {
    function create_link($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and', "'" => '');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }
}

if (! function_exists('show_image')) {
    function show_image($source)
    {
        if ($source == NULL) {
            $source = "https://img.icons8.com/color/96/undefined/user.png";
        }
        return $source;
    }
}
//generate path function
if (! function_exists('generate_duotone_icon')) {
    /**
     * Generate a duotone icon with a specified class and number of paths.
     *
     * @param string $class The class of the icon.
     * @param int $path_count The number of paths to create for the icon.
     * @return string The HTML code for the duotone icon.
     */
    function generate_duotone_icon($class, $path_count)
    {
        $paths = '';
        for ($i = 1; $i <= $path_count; $i++) {
            $paths .= '<span class="path' . strval($i) . '"></span>';
        }
        $icon = '<i class="ki-duotone ' . $class . '">' . $paths . '</i>';
        return $icon;
    }
}

if (! function_exists('generate_user_group')) {
    function generate_user_group($code, $name)
    {
        $created_at = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $id_usergroup = Uuid::uuid4();

        DB::table('ms_usergroup')->insert([
            'id_usergroup' => $id_usergroup,
            'code_usergroup' => $code,
            'name_usergroup' => $name,
            ...$created_at
        ]);

        return $id_usergroup;
    }
}

if (! function_exists('generate_ms_module')) {
    function generate_ms_module($code, $name, $upid = '0', $icon = 'ki-home fs-2', $path = 0, $action = 'list,roles,show,create,read,update,delete', $order = 1)
    {
        $created_now = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Insert modules into the database
        $modules_id = DB::table('ms_module')->insertGetId([
            'id' => Uuid::uuid4(),
            'upid' => $upid,
            'code' => $code,
            'name' => $name,
            'link' => strtolower($name),
            'description' => '',
            'icon' => generate_duotone_icon($icon, $path),
            'action' => $action,
            'order' => $order,
            ...$created_now
        ]);
        return $modules_id;
    }
}

if (! function_exists('create_permission')) {
    function create_permission($code_role, $id, $action = 'list,roles,show,create,read,update,delete')
    {
        $created_now = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $modules_id = DB::table('ms_module_permission')->insert([
            'id' => Str::uuid(),
            'role_id' => DB::table('ms_role')->where('code', $code_role)->first()->id,
            'module_id' => $id,
            'action' => $action,
            'publish' => 1,
            ...$created_now
        ]);
        return true;
    }
}
